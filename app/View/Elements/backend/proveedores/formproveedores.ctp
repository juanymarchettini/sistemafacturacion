<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Proveedor','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('Proveedore', array(
    'action'=>$action,
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false
)); ?>

<section class="panel panel-danger">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
					
				<?php
					echo $this->Form->hidden('id');   
					echo $this->Form->input('nombre',array('placeholder'=>'Ingrese Nombre del Proveedor'));
					echo $this->Form->input('cuit',array('placeholder'=>'Ingrese Cuit/Cuil'));
					echo $this->Form->input('tel',array('placeholder'=>'Ingrese Nro de Telefono'));
			        echo $this->Form->input('email', array('placeholder'=>'Ingrese Email'));
			        echo $this->Form->input('ciudad', array('placeholder'=>'Ingrese Ciudad'));
			        echo $this->Form->input('direccion', array('placeholder'=>'Ingrese Direccion'));
			        echo $this->Form->input('contacto', array('placeholder'=>'Ingrese Nombre de Contacto'));
		       	?>
			</fieldset>
			<?php
			echo $this->Form->submit(__('Guardar '),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
		</section>
	</div>
</section>