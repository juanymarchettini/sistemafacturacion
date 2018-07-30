	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro.'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Usuario'); ?></th>
							<th><?php echo $this->Paginator->sort('localidad','Localidad:'); ?></th>
							<th><?php echo $this->Paginator->sort('created','Fecha '); ?></th>
							<th><?php echo 'Facturado'; ?></th>
							<th><?php echo 'Armado'; ?></th>
							<th><?php echo 'Envio'; ?></th>
							<th><?php echo 'Fecha Envio'; ?></th>
							<th><?php echo $this->Paginator->sort('tipodepago','F/Pago'); ?></th>
							<th><?php echo $this->Paginator->sort('total','Total'); ?></th>
							<th><?php echo 'Pagó'; ?></th>
							<th><?php echo $this->Paginator->sort('statuspago','Estado $'); ?></th>
							<th class="actions"><?php echo __('Ver'); ?></th>
							<th class="actions"><?php echo __('Pagar'); ?></th>
							<th class="actions"><?php echo __('Entregado'); ?></th>
							<th class="actions"><?php echo __('Cancelar Factura'); ?></th>
							
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
								
								<td><?php echo ($pedido['Factura']['facturado'])? 'Facturado' : 'No Fact.';
									?>
								</td>
								<td><?php echo ($pedido['Factura']['empaquetado'])? '<span class="label label-success">Armado</span>' : '<span class="label label-warning">Sin Armar</span>';
									?>
								</td>
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
									<?php echo $this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>', array('action' => 'view', $pedido['Factura']['id']),array('escape'=>false)); ?>
								</td>
								
								<td class="actions">
								
									<?php
										echo $this->Html->link(__('Pagos'), array('controller'=>'pagos','action' => 'pagar', $pedido['Factura']['id']),array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-success', 'style'=>'color:#fff')); 
									?>
									
								</td>
								<td class="actions">
								
									<?php echo ($pedido['Factura']['entregado'])? 
										$this->Html->link(__('Cancelar'), array('action' => 'entregar_compra', $pedido['Factura']['id'],'0'),array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-warning', 'style'=>'color:#fff'))
										: 
										$this->Html->link(__('Entregar'), array('action' => 'entregar_compra', $pedido['Factura']['id'],'1'),array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-success', 'style'=>'color:#fff')); 
									?>
									
								</td>
								
								
								
								
								<td class="actions">
									<?php 
										if ($pedido['Factura']['facturado']){
											echo $this->Html->link(__('Cancelar'), array('action' => 'cancelar_compra', $pedido['Factura']['id']),array('class'=>'mb-xs mt-xs mr-xs btn btn-xs btn-danger', 'style'=>'color:#fff'));
										}else{
											echo 'Sin Facturar';
										}
										 ?>	
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