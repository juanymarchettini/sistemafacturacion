<div id='ajaxresultado'>
	<div id="custom-content" class="modal-block modal-block-md">
	 	
	<?php
	    echo $this->Form->create('Producto', array(
	    'default'=>false,
	    'inputDefaults' => array(
	        'div' => 'form-group col-md-12',
	        'wrapInput' => false,
	        'class' => 'form-control '
	    ),
	    'class' => false
	)); ?>
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title"><?php echo "Buscar Producto"; ?></h2>
			</header>	
			<div class="panel-body">
				<div><?php echo $this->Session->flash();?>
            	</div>
				<fieldset>
				
				<?php
					
					echo $this->Form->input('searchprod',array('label'=>false,'placeholder'=>'Ingrese Busqueda','div' => 'form-group col-md-8'));
				?>
				<div class="col-md-4 text-left">
					<?php
						echo $this->Form->submit('Buscar',array('class'=>array('btn btn-primary')));
						$this->Form->end();

					
			       	?>
			       	
		       	</div>
				</fieldset>
			

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-condensed mb-none">
						<thead>
							<tr>
								<th>Cod</th>
								<th>Nombre</th>
								<th class="text-right">Stock</th>
								<th class="text-right"> $ Neto</th>
								<th class="text-right">Iva</th>
								<th class="text-right">$ Bruto</th>
								<th class="text-right">Action</th>
							
							</tr>
						</thead>
						<tbody>
							<?php foreach ($resultado as $key => $producto) { ?>
							
							
							<tr>
								<td><?php echo $producto['Producto']['id']; ?></td>
								<td><?php echo $producto['Producto']['nombre']; ?></td>
								<td class="text-right"><?php echo $producto['Producto']['stock']; ?></td>
								<td class="text-right"><?php echo $producto['Producto']['precio']; ?></td>
								<td class="text-right"><?php echo $producto['Producto']['iva']; ?></td>
								<td class="text-right"><?php echo $producto['Producto']['preciobruto']; ?></td>
								
								<td class="text-center">	<button class="btn btn-success info-select" codid="<?php echo $producto['Producto']['id']; ?>">Seleccionar</button>

								</td>
								
							</tr>
							<?php } ?>
							
						</tbody>
					</table>
				</div>

				<div class="col-xs-12 text-right" style="margin-top:20px;">
					
			       	<button class="btn btn-default modal-dismiss">Close</button>
		       	</div>
				
			</div>
			
		</section>
	</div>
</div>

<?php
// JsHelper should be loaded in $helpers in controller
// Form ID: #ContactsContactForm
// Div to use for AJAX response: #contactStatus
$data = $this->Js->get('#ProductoModalListaproductosForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#ProductoModalListaproductosForm')->event(
   'submit',
   $this->Js->request(
    array('action' => 'modal_listaproductos', 'controller' => 'productos'),
    array(
        'update' => '#ajaxresultado',
        'data' => $data,
        'async' => true,  
        'type '=>'HTML',  
        'dataExpression'=>true,
        'method' => 'POST'
    )
  )
);
echo $this->Js->writeBuffer(); 
?>
