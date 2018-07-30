<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Ciudades','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('City', array(
    'type'=>'file',
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false
)); ?>

<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Ciudad de Revendedor'); ?></legend>
				<?php   
					echo $this->Form->input('nombre',array('placeholder'=>'Ingrese Nombre de la Ciudad'));
			        echo $this->Form->input('lat', array('placeholder'=>'Ingrese Latitud'));
			        echo $this->Form->input('long', array('placeholder'=>'Ingrese Longitud'));
		       	?>
			</fieldset>
			<?php
			echo $this->Form->submit(__('Guardar '),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
		</section>
	</div>
</section>