<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Ciudad Reveenderoes','shorturl'=>'Lista de Ciudades')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Ciudad de Revendedores</h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
							<th><?php echo $this->Paginator->sort('nombre','Nombre.'); ?></th>
							<th><?php echo $this->Paginator->sort('lat','Latitud'); ?></th>
							<th><?php echo $this->Paginator->sort('long','Longitud'); ?></th>
							<th class="actions"><?php echo __('Editar'); ?></th>
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					<?php foreach ($cities as $city): ?>
					<tr>
						<td><?php echo h($city['City']['nombre']); ?>&nbsp;</td>
						<td><?php echo h($city['City']['lat']); ?>&nbsp;</td>
						<td><?php echo h($city['City']['long']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $city['City']['id']),array('escape'=>false)); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $city['City']['id']), array('escape'=>false), __('¿Estás seguro que deseas eliminar %s?',$city['City']['nombre'])); ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php
					echo $this->Paginator->counter(array(
					'format' => __('Página {:page} de {:pages}')
					));
					?>	</p>
					<div class="paging pagination">
					<?php
						echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
						echo $this->Paginator->numbers(array('separator' => ''));
						echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
		</section>
	</div>
</section>