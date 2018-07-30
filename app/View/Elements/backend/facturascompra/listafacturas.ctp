	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro.'); ?></th>
							<th><?php echo $this->Paginator->sort('nrofact','Nro Factura (Enviada por Proveedor):'); ?></th>
							<th><?php echo $this->Paginator->sort('fecha','Fecha Fact:'); ?></th>
							<th><?php echo $this->Paginator->sort('proveedor_id','Proveedor'); ?></th>
							<th><?php echo $this->Paginator->sort('created','Creada '); ?></th>
							<th><?php echo $this->Paginator->sort('user_id','Modifico/Creo '); ?></th>
							<th><?php echo $this->Paginator->sort('total','Total'); ?></th>
							<th><?php echo $this->Paginator->sort('statuspago','Estado de Pago'); ?></th>
							<th class="actions"><?php echo __('Pagar'); ?></th>
							<th class="actions"><?php echo __('Edit'); ?></th>
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					<?php foreach ($pedidos as $pedido):
							
					?>
					<tr>
								<td><?php echo h($pedido['Proveedorfactura']['id']); ?>&nbsp;</td>
								<td><?php echo h($pedido['Proveedorfactura']['nrofact']); ?>&nbsp;</td>
								<td><?php  echo h(date_format(date_create($pedido['Proveedorfactura']['fecha']), 'd-m-Y')); ?>&nbsp;</td>
								<td><?php echo isset($listaproveedores[$pedido['Proveedorfactura']['proveedore_id']])? $listaproveedores[$pedido['Proveedorfactura']['proveedore_id']] : '--'; ?>&nbsp;</td>
								
								<td><?php  echo h(date_format(date_create($pedido['Proveedorfactura']['created']), 'd-m-Y')); ?>&nbsp;</td>
								<td><?php echo isset($listaoperadores[$pedido['Proveedorfactura']['user_id']])? $listaoperadores[$pedido['Proveedorfactura']['user_id']] : ($pedido['Proveedorfactura']['user_id']); ?>&nbsp;</td>

								<td><?php echo h($pedido['Proveedorfactura']['total']); ?>&nbsp;</td>
								<td><?php echo h($pedido['Proveedorfactura']['statuspago']); ?>&nbsp;</td>
								<td class="actions">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-usd"></span>', array('controller'=>'Proveedorpagos','action' => 'pagar', $pedido['Proveedorfactura']['id']), array('escape'=>false)); ?>
								</td>
								<td class="actions">

									<?php 

										if ($pedido['Proveedorfactura']['esgasto']){
											echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'gastosedit', $pedido['Proveedorfactura']['id']), array('escape'=>false));
										}else{
											echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $pedido['Proveedorfactura']['id']), array('escape'=>false));
										}
										 ?>
								</td>
								<td class="actions">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $pedido['Proveedorfactura']['id']), array('escape'=>false, 'onclick'=>"return confirm('Esta Seguro que desea eliminar esta carpeta?')")); ?>
								</td>
							</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</section>
	</div>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}')
	));
	?>	</p>
	<div class="paging pagination">
		<?php
			$this->Paginator->options(array('url' => $this->passedArgs));
			echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>