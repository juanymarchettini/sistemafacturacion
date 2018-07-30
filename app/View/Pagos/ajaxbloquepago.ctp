<div id='ajaxresultado'>
	<div id="custom-content" class="modal-block modal-block-md">
	 	
	<?php
	    echo $this->Form->create('Pagospendiente', array(
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
				<h2 class="panel-title">Añadir Pago Pedido Nro: <?php echo $idfactura; ?> - Total: $<?php echo $infofactura['Factura']['total']; ?></h2>
			</header>	
			<div class="panel-body">
				<div><?php echo $this->Session->flash();?>
            	</div>
				<div class="row">
					<div class="col-md-12">
						<?php 
							echo $this->Form->hidden('id');
							echo $this->Form->hidden('factura_id', array('value'=>$idfactura,'required'=>'required'));  
							echo $this->Form->input('tipopago_id',array('label'=>'Forma de Pago','options'=>$listatipodepagos,'empty'=>'Seleccione Pago','required'=>'required'));
					        echo $this->Form->input('monto', array('label'=>'Ingrese Monto a Pagar','required'=>'required'));
					        echo $this->Form->input('nrocheque', array('label'=>' Nro de Cheque'));
					        echo $this->Form->input('infoextra',array('label'=>'Info Extra', 'type'=>'text'));
					        echo $this->Form->hidden('operador_id',array('value'=>$operadorid,'required'=>'required'));
					        echo $this->Form->hidden('transporte_id',array('value'=>$transporteid,'required'=>'required'));
					        echo $this->Form->hidden('status',array('value'=>2));
					        
					        
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
$data = $this->Js->get('#PagospendienteAjaxbloquepagoForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#PagospendienteAjaxbloquepagoForm')->event(
   'submit',
   $this->Js->request(
    array('action' => 'ajaxbloquepago', 'controller' => 'pagos'),
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