
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Lista de Proveedores','shorturl'=>'')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Proveedores</h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
							<th><?php echo $this->Paginator->sort('nombre','Nombre.'); ?></th>
							<th><?php echo $this->Paginator->sort('cuit','Cuit'); ?></th>
							<th><?php echo $this->Paginator->sort('tel','Telefono'); ?></th>
							<th><?php echo $this->Paginator->sort('email','Email'); ?></th>
							<th><?php echo $this->Paginator->sort('ciudad','Ciudad'); ?></th>
							<th><?php echo $this->Paginator->sort('direccion','Direccion'); ?></th>
							<th><?php echo $this->Paginator->sort('contacto','Contacto'); ?></th>

							<th class="actions"><?php echo __('Editar'); ?></th>
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					<?php foreach ($proveedores as $proveedor): ?>
					<tr>
						<td><?php echo h($proveedor['Proveedore']['nombre']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['cuit']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['tel']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['email']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['ciudad']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['direccion']); ?>&nbsp;</td>
						<td><?php echo h($proveedor['Proveedore']['contacto']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('controller'=>'Proveedores','action' => 'edit', $proveedor['Proveedore']['id']),array('escape'=>false)); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller'=>'Proveedores','action' => 'delete', $proveedor['Proveedore']['id']), array('escape'=>false), __('¿Estás seguro que deseas eliminar %s?',$proveedor['Proveedore']['nombre'])); ?>
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