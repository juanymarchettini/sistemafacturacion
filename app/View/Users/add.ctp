<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Nuevo Cliente','shorturl'=>'Clientes')); ?>
<?php echo $this->Form->create('User', array(
	'inputDefaults' => array(
		'div' => 'form-group col-md-4 col-xs-12',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => false
)); ?>

<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo "Nuevo Cliente"; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				
				<?php
					echo $this->Form->hidden('id',array('label'=>'Id Usuario'));
					echo $this->Form->input('nombre',array('label'=>'Nombre','type'=>'email','required'));
					echo $this->Form->input('apellido',array('label'=>'Apellido','required'));
					echo $this->Form->input('cuit',array('label'=>'Cuit/Cuil/Dni'));
					echo $this->Form->input('provincia',array('label'=>'Provincia'));
					echo $this->Form->input('ciudad',array('label'=>'Localidad')); 
					echo $this->Form->input('direccion',array('label'=>'Direccion'));
					echo $this->Form->input('tel',array('label'=>'Telefono'));
			        echo $this->Form->hidden('password', array('label'=>'Password','required','value'=>'1234567'));
			        echo $this->Form->input('role', array('label'=>'Rol de Usuario','options'=>array('cliente'=>'cliente'))); 
		       	?>
			</fieldset>
			<?php
			echo $this->Form->submit(__('Guardar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
		</section>
	</div>
</section>