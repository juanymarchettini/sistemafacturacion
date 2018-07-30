<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Categorias','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('Categoria', array(
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
				<legend><?php echo __('Info Categoria'); ?></legend>
				<?php
					echo $this->Form->input('id',array('label'=>false,'hidden'=>true));
					echo $this->Form->input('disponible',array('label'=>'Activo','options'=>array('0'=>'Desactivar','1'=>'Activar'),'empty'=>'Seleccione Estado','required'));
					echo $this->Form->input('nombre',array('label'=>'Título','required'));
					echo $this->Form->input('descripcion',array('label'=>'Descripción','required'=>false));
					echo $this->Form->input('parent_id',array('label'=>'Pertenece a:','options'=>$categorias , 'empty'=>'Seleccione Categoria si es necesario'));
				
					echo $this->Form->submit(__('Guardar Categoria'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
					echo $this->Form->end();
			?>
			</fieldset>
		</section>
	</div>
</section>