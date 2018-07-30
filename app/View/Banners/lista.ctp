<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Promociones','shorturl'=>'Lista de Promociones')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Lista de Promociones</h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro.'); ?></th>
							<th><?php echo $this->Paginator->sort('imagen','Imagen'); ?></th>
							<th><?php echo $this->Paginator->sort('type','Tipo:'); ?></th>
							<th class="actions"><?php echo __('Editar'); ?></th>
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					<?php foreach ($banners as $capacitacione): ?>
					<tr>
						<td><?php echo h($capacitacione['Banner']['id']); ?>&nbsp;</td>
						
						<td><?php echo $this->Html->image('Banners/'.$capacitacione['Banner']['ruta'], array('class'=>"rounded img-responsive", 'style'=>'max-height:150px;' )); ?>&nbsp;</td>
						<td>
							<?php echo $capacitacione['Banner']['type']; ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $capacitacione['Banner']['id']),array('escape'=>false)); ?>
						</td>
						<td class="actions">
							<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $capacitacione['Banner']['id']), array('escape'=>false), __('¿Estás seguro que deseas eliminar %s?', $capacitacione['Banner']['id'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php
					echo $this->Paginator->counter(array(
					'format' => __('Página {:page} de {:pages}')
					));
					?>	</p>
					<div class="paging">
					<?php
						echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
						echo $this->Paginator->numbers(array('separator' => ''));
						echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
				?>

			</div>
		</section>
	</div>
</section>