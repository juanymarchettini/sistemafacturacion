<div class="panel-body">
	<section  class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
						<th><?php echo $this->Paginator->sort('nro','Nro.'); ?></th>
						<th><?php echo $this->Paginator->sort('user_id','Usuario'); ?></th>	
						<th><?php echo $this->Paginator->sort('localidad','Localidad'); ?></th>
						<th><?php echo $this->Paginator->sort('created','Fecha'); ?></th>
						<th><?php echo $this->Paginator->sort('entregado','Envio'); ?></th>
						<th><?php echo $this->Paginator->sort('fechanevio', 'Fecha Envio'); ?></th>
						<th><?php echo 'F/Pago'; ?></th>
						<th><?php echo 'Total'; ?></th>
						<th><?php echo 'Pagó'; ?></th>
						<th><?php echo 'Estado $'; ?></th>
						<th class="actions"><?php echo __('Pagar'); ?></th>
						
				</tr>
				<?php foreach ($facturas as $pedido):
						$totalpedido = 0;
				?>
						<tr>
							<td><?php 
									echo $this->Html->link($pedido['Factura']['id'], array('action' => 'view', $pedido['Factura']['id']),array('escape'=>false,'escape'=>false));
								?>&nbsp;
							</td>
							<td><?php echo h($pedido['Factura']['nombre'].' '.$pedido['Factura']['apellido']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['localidad']); ?>&nbsp;</td>
							
							<td><?php  echo h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y')); ?>&nbsp;</td>
							<td><?php echo ($pedido['Factura']['entregado'])? '<i class="fa fa-check-square-o" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>'; ?>&nbsp;</td>

							<td><?php 
								if (!empty($pedido['Factura']['fechaenvio'])){
									echo (date_format(date_create($pedido['Factura']['fechaenvio']), 'd-m-Y')); 
								}else{
									echo '---';
								}
							?> </td>
							<td><?php echo ($pedido['Factura']['tipodepago']);
								?>
							</td>
							<td>$<?php echo h($pedido['Factura']['total']); $totalpedido= $pedido['Factura']['total']; ?>&nbsp;</td>
							<td><?php 
								$totalpagado = 0;
								
								foreach ($pedido['Pago'] as $pago) {
									
									//1= Pago Correcto ,  0=Pago Cancelado
									if($pago['status']==1){
										$totalpagado = $pago['monto']+$totalpagado;
									}
								}

								echo '$'.$totalpagado;
							?></td>
							<td><?php echo h($pedido['Factura']['statuspago']); ?>&nbsp;</td>
							<td class="actions">
							
								<?php
									echo $this->Html->link(__('Pagos'), array('controller'=>'pagos','action' => 'pagar', $pedido['Factura']['id']),array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-success', 'style'=>'color:#fff')); 
								?>
								
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