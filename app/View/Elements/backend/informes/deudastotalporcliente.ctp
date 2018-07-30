<div class="panel-body">
	<section  class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
						
						<th><?php echo $this->Paginator->sort('user_id','Usuario Id'); ?></th>
						<th><?php echo $this->Paginator->sort('apellido','Apellido'); ?></th>	
						<th><?php echo $this->Paginator->sort('nombre','Nombre'); ?></th>
						<th><?php echo $this->Paginator->sort('email','Email'); ?></th>
						<th><?php echo $this->Paginator->sort('totalclientev','Total Deuda Aprox'); ?></th>
						<th class="actions"><?php echo __('Ver Facturas'); ?></th>
						
				</tr>
				<?php foreach ($facturas as $pedido):
						$totalpedido = 0;
				?>
						<tr>
							<td><?php 
									echo $this->Html->link($pedido['Factura']['user_id'], array('controller' => 'facturas', 'action'=>'listaporclientes', $pedido['Factura']['user_id']),array('escape'=>false));
								?>&nbsp;
							</td>
							<td><?php echo h($pedido['Factura']['apellido']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['nombre']);?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['email']); ?>&nbsp;</td>
							<td>$<?php echo h($pedido['Factura']['totalclientev']); ?>&nbsp;</td>
							<td><?php 
									echo $this->Html->link('Ver Facturas', array('controller' => 'facturas', 'action'=>'listaporclientes', $pedido['Factura']['user_id']),array('escape'=>false));
								?>&nbsp;
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
		</div>
	</section>
</div>