<div id='ajaxresultado'>
	<div id="custom-content" class="modal-block modal-block-md">
	 	
	<?php
	    echo $this->Form->create('User', array(
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
				<h2 class="panel-title"><?php echo "Nuevo Cliente"; ?></h2>
			</header>	
			<div class="panel-body">
				<div><?php echo $this->Session->flash();?>
            	</div>
				<fieldset>
				
				<?php
					
					echo $this->Form->input('nombre',array('label'=>'Nombre *','div' => 'form-group col-md-6', 'required'));
					echo $this->Form->input('apellido',array('label'=>'Apellido *','div' => 'form-group col-md-6','required'));
					echo $this->Form->input('cuit',array('label'=>'Cuit/Cuil/Dni *','div' => 'form-group col-md-6'));
					echo $this->Form->input('provincia',array('label'=>'Provincia','div' => 'form-group col-md-6'));
					echo $this->Form->input('localidad',array('label'=>'Localidad','div' => 'form-group col-md-6')); 
					echo $this->Form->input('direccion',array('label'=>'Direccion','div' => 'form-group col-md-6'));
					echo $this->Form->input('telefono',array('label'=>'Telefono','div' => 'form-group col-md-6'));
					echo $this->Form->input('username',array('label'=>'Email','type'=>'email','div' => 'form-group col-md-12'));
			        echo $this->Form->hidden('password', array('label'=>'Password','required','value'=>'1234567'));
			        echo $this->Form->input('role', array('label'=>'Rol de Usuario','options'=>array('cliente'=>'cliente'))); 
		       	?>
				</fieldset>
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
$data = $this->Js->get('#UserAjaxbloquenuevoclienteForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#UserAjaxbloquenuevoclienteForm')->event(
   'submit',
   $this->Js->request(
    array('action' => 'ajaxbloquenuevocliente', 'controller' => 'users'),
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