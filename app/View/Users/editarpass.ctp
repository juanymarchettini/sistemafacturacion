<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Cambio de Password','shorturl'=>'Clientes')); ?>
<?php echo $this->Form->create('User', array(
	'inputDefaults' => array(
		'div' => 'form-group col-md-6',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => false
)); ?>

<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo "Cambio de Password"; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Cliente'); ?></legend>
				<?php
					echo $this->Form->hidden('id',array('label'=>'Id Usuario'));
					echo $this->Form->input('username',array('label'=>'Usuario','disabled'=>'disabled'));
					echo $this->Form->input('tel',array('label'=>'Telefono','disabled'=>'disabled'));
					echo $this->Form->input('apellido',array('label'=>'Apellido','disabled'=>'disabled'));
					echo $this->Form->input('nombre',array('label'=>'Nombre','disabled'=>'disabled'));
			        echo $this->Form->input('password', array('label'=>'Nuevo Password'));
			        echo $this->Form->input('role', array('label'=>'Rol de Usuario','options'=>array('admin'=>'admin', 'mayorista'=>'mayorista','depobancario'=>'Movimiento Bancario','distribuidor'=>'distribuidor','transporte'=>'distribuidor','transporte'=>'transporte','stock'=>'stock')));
			        
		       	?>
			</fieldset>
			<?php
			echo $this->Form->submit(__('Guardar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
		</section>
	</div>
</section>