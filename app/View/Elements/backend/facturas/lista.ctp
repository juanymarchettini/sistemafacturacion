	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro.'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Usuario'); ?></th>
									
							<th><?php echo $this->Paginator->sort('localidad','Localidad:'); ?></th>
							<th><?php echo $this->Paginator->sort('created','Fecha '); ?></th>
							<th><?php echo $this->Paginator->sort('tipodepago','Tipo de Pago'); ?></th>
							<th><?php echo $this->Paginator->sort('total','Total'); ?></th>
							<th><?php echo $this->Paginator->sort('statuspago','Estado'); ?></th>
							
							<th class="actions"><?php echo __('Pedido Detalle'); ?></th>
							
							
							<th class="actions"><?php echo __('Facturar'); ?></th>
							
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					<?php foreach ($pedidos as $pedido):
							$totalpedido = 0;
							if ($pedido['Factura']['cancelado']){
								echo '<tr class="cancelada">';
							}else{
								if ($pedido['Factura']['entregado']){
								 	echo '<tr class="entregado">';
								}else{
									echo '<tr>';
								}

							}
					?>
							
								<td><?php echo h($pedido['Factura']['id']); ?>&nbsp;</td>
								<td><?php echo h($pedido['Factura']['nombre'].' '.$pedido['Factura']['apellido']); ?>&nbsp;</td>

								<td><?php echo h($pedido['Factura']['localidad']); ?>&nbsp;</td>
								
								<td><?php  echo h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y')); ?>&nbsp;</td>
								
								
								<td><?php echo $pedido['Factura']['tipodepago']; ?></td>
								<td>$<?php echo h($pedido['Factura']['total']); $totalpedido= $pedido['Factura']['total']; ?>&nbsp;</td>
								<td id=<?php echo 'success'.$pedido['Factura']['id'] ?> >
									<?php
										if (($pedido['Factura']['tipodepago'] == 'TarjetadeCredito') && ($pedido['Factura']['statuspago']=='Pendiente'))
										{
											echo $this->Js->link('<span class="glyphicon glyphicon-refresh"> Pendiente</span>', array('controller'=>'Pagos', 'action'=> 'mercadopagoverificaciones', 5206), array('escape'=>false,'update'=>'#success'.$pedido['Factura']['id'],'before' => $this->Js->get('#busy-indicator'.$pedido['Factura']['id'])->effect('fadeIn', array('buffer' => false)), 'complete' => $this->Js->get('#busy-indicator'.$pedido['Factura']['id'])->effect('fadeOut', array('buffer' => false))));
											
											echo $this->Html->image('loading-1.gif', array('width'=>'80px','style'=>'display:none','id' => 'busy-indicator'.$pedido['Factura']['id']));
										}else{
											 echo $pedido['Factura']['statuspago']; 
										}
										 
									?>
								</td>
								<td class="actions">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', array('action' => 'view', $pedido['Factura']['id']),array('escape'=>false)); ?>
								</td>
								
								
								<td class="actions">
								
									<?php echo ($pedido['Factura']['facturado'])?
										'Facturado' : 
										$this->Html->link(__('Facturar'), array('action' => 'facturarpedido/'.$pedido['Factura']['id'].'/'.'1'), array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-success', 'style'=>'color:#fff'), array('escape'=>false,'onclick'=>"return confirm('Esta Seguro que desea pasar a Factura este Pedido?')")); 
									?>
									
								</td>
								
								
								<td class="actions">
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $pedido['Factura']['id'],'Pedido'), array('escape'=>false, 'onclick'=>"return confirm('Esta Seguro que desea eliminar este Pedido ".$pedido['Factura']['id'].','.$pedido['Factura']['nombre'].' '.$pedido['Factura']['apellido']."?')")); ?>
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
			echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
		?>
	</div>
	<?php echo $this->Js->writeBuffer();?>