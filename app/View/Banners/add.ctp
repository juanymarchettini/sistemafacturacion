<div class="capacitaciones form">
<?php echo $this->Form->create('Banner',array('type'=>'file')); ?>
	<fieldset>
		<legend><?php echo __('Agregar promoción'); ?></legend>
	<?php
		echo $this->Form->input('ruta',array('label'=>'Foto','type'=>'file', 'required'));
		echo $this->Form->input('titulo',array('label'=>'Título','required'=>false));
		echo $this->Form->input('subtitulo',array('label'=>'Subtitulo','required'=>false));
		echo $this->Form->input('descripcion',array('label'=>'Descripción','required'=>false));
		echo $this->Form->hidden('type',array('value'=>$type));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Aceptar')); ?>
</div>