<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Productos','shorturl'=>'Lista de Productos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Lista de Productos</h2>
	</header>
	<div class="col-xs-12 col-md-4 " style="margin-top:10px; margin-bottom:10px;">
		<div action="#" class="search nav-form ">
	        <div class="input-group input-search">
	          <?php echo $this->Form->input('searchprod',array('label'=>false, 'class'=>"form-control" ,'placeholder'=>'Buscar Producto')); ?>
	          
	          <span class="input-group-btn">
	          	<?php echo $this->Form->button('<i class="fa fa-search"></i>',array('id'=>'ajaxbuscar', 'class'=>"btn btn-default", 'type'=>'button'), array('escape'=>false)); ?>
	           
	          </span>
	        </div>
	     </div>
    </div>
    <div id='ajaxlistaprod'>
		<div class="panel-body">
			<section  class="col-md-12">
				<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Cod.'); ?></th>
							<th><?php echo $this->Paginator->sort('codigo','Cod Prove.'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Nombre.'); ?></th>
							<th><?php echo $this->Paginator->sort('categoria_id','Cat.'); ?></th>
							<th><?php echo $this->Paginator->sort('stock','Stock'); ?></th>
							<th><?php echo $this->Paginator->sort('preciocompra','Costo'); ?></th>
							<th><?php echo $this->Paginator->sort('iva','iva'); ?></th>
							<th><?php echo $this->Paginator->sort('precio','$ sin/iva'); ?></th>
							<th><?php echo '$ c/Iva' ?></th>
							<th><?php echo $this->Paginator->sort('disponible','Dispo.'); ?></th>
							<th class="actions"><?php echo __('Editar'); ?></th>	
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					
													
					<?php 

						foreach ($productos as $producto){
					?>
						<tr>
							<td>
								<?php echo $producto['Producto']['id']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['codigo']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['nombre']; ?>
							</td>
							<td>
								<?php echo $listacategorias[$producto['Producto']['categoria_id']]; ?>
							</td>
							<td>
								<b>
								<?php echo $producto['Producto']['stock']; ?>
								</b>
							</td>
							<td>$
								<?php echo $producto['Producto']['preciocompra']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['iva']; ?>
								%
							</td>
							<td>
								$
								<?php echo $producto['Producto']['precio']; ?>
							</td>
							<td><b>$
								<?php echo $producto['Producto']['preciobruto']; ?>
								</b>
							</td>
							<td>
								<?php echo ($producto['Producto']['disponible'])? 'Disponible' : 'No Disponible'; ?>
							</td>
							<td class="actions">
								
									<?php echo $this->Html->link('Editar', array('action' => 'edit',$producto['Producto']['id']), array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-success', 'style'=>'color:#fff')); 
									?>
									
								</td>
								
								
								<td class="actions">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $producto['Producto']['id']), array('escape'=>false, 'onclick'=>"return confirm('Esta Seguro que desea eliminar el Producto ".$producto['Producto']['nombre']."?')")); ?>
								</td>
						</tr>
					<?php
						}
					?>
				</table>
				<div>			
			</section>

		</div>
	</div>						
</section>
<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}')
	));
	?>	</p>
	<div class="paging pagination">
		<?php
			echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
	<?php echo $this->Js->writeBuffer();?>

<script>
$("#searchprod").keypress(function(e) {
       if(e.which == 13) {
            var buscar=$('#searchprod').val();
			if (buscar.length ==0 ){
				alert('Campo de Busqueda Vacio');
			}else{
				$.ajax({
	  				method: "POST",
	 			    url: '<?php echo $this->Html->url(array(
	   								"controller" => "productos",
	    							"action" => "ajaxsearchproducto" ));?>',
	  				data: { busqueda: buscar },
	  				dataType: "html",
					
	  				success:  function (response) {
		        	
		        	 $('#ajaxlistaprod').html(response)
		        	
		       		}
	  		    });

			}
       }
});


$('#ajaxbuscar').click(function(){

		var buscar=$('#searchprod').val();

		if (buscar.length ==0 ){
			alert('Campo de Busqueda Vacio');
		}else{

			
			$.ajax({
  				method: "POST",
 			    url: '<?php echo $this->Html->url(array(
   								"controller" => "productos",
    							"action" => "ajaxsearchproducto" ));?>',
  				data: { busqueda: buscar },
  				dataType: "html",
				
  				success:  function (response) {
	        	
	        	 $('#ajaxlistafact').html(response)
	        	
	       		}
  		    });

		}


});
</script>



