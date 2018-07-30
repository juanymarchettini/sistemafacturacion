<div id='ajaxresultado'>
	<div id="custom-content" class="modal-block modal-block-md">
	 	
	<?php
	    echo $this->Form->create('Armarpedido', array(
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
				<h2 class="panel-title">Armar Pedido Nro: <?php echo $idfactura; ?> </h2>
			</header>	
			<div class="panel-body">
				<div><?php echo $this->Session->flash();?>
            	</div>
				<div class="row">
					<div class="col-md-12">
						<?php 
						
							echo $this->Form->hidden('factura_id', array('value'=>$idfactura,'required'=>'required'));
							if (!empty($this->request->data['Armarpedido']['armadopor'])) {
						?>

							<div class="col-xs-12">
								<p> Armado Por: </p>
								<h4> <?php echo $operarios[$this->request->data['Armarpedido']['armadopor']]; ?></h4>
								<?php echo $this->Form->hidden('armadopor',array('label'=>'Armado Por','options'=>$operarios,'empty'=>'Seleccione Quien Armó','required'=>'required')); ?> 						
							</div>
						
						<?php 
							}else{
								echo $this->Form->input('armadopor',array('label'=>'Armado Por','options'=>$operarios,'empty'=>'Seleccione Quien Armó','required'=>'required'));
							}

							if ($this->request->data['Armarpedido']['empaquetado']) {
								echo $this->Form->input('empaquetado', array('label'=>'Estado del Pedido','options'=>array(1=>'Armado',0=>'Sin Armar'),'value'=>1)); 
							}else{
								echo $this->Form->input('empaquetado', array('label'=>'Estado del Pedido','options'=>array(1=>'Armado',0=>'Sin Armar'),'value'=>0));
							}

							echo $this->Form->hidden('armadocorrecto', array('value'=>1));
					               
					        

				       	?>
					</div>
				</div>
				
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-12 text-right">
						<?php echo $this->Form->submit('Guardar',array('class'=>array('btn btn-primary')));
							$this->Form->end();
						 ?>

						<button class="btn btn-default modal-dismiss">Close</button>
					</div>
				</div>
			</footer>
		</section>
	</div>
</div>

<?php
// JsHelper should be loaded in $helpers in controller
// Form ID: #ContactsContactForm
// Div to use for AJAX response: #contactStatus
$data = $this->Js->get('#ArmarpedidoArmarpedidoForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#ArmarpedidoArmarpedidoForm')->event(
   'submit',
   $this->Js->request(
    array('controller' => 'Facturas', 'action' => 'armarpedido'),
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