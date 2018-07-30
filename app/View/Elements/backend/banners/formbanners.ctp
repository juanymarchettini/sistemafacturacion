<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Banners','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('Banner', array(
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
				<legend><?php echo __('Info Banner'); ?></legend>
					<?php
						echo $this->Form->input('id',array('label'=>false,'hidden'=>true));
						echo $this->Form->input('ruta',array('label'=>'Foto','type'=>'file'));
						if (isset($this->request->data['Banner']['ruta'])){
							echo $this->Html->image('Banners/'.$this->request->data['Banner']['ruta'], array('width'=>'	400px;'));
						}
						echo $this->Form->input('titulo',array('label'=>'Título','required'=>false));
						echo $this->Form->input('subtitulo',array('label'=>'Subtitulo','required'=>false));
						echo $this->Form->input('descripcion',array('label'=>'Descripción','required'=>false));
						echo $this->Form->hidden('type',array('value'=>'mayorista'));
					?>
				<?php echo $this->Form->end(__('Guardar')); ?>
			</fieldset>
		</section>
	</div>
</section