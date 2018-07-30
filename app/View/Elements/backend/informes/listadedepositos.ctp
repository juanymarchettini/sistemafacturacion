<div class="panel-body">
	<section  class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
						<th><?php echo $this->Paginator->sort('nro','Nro.'); ?></th>
						<th><?php echo $this->Paginator->sort('created','Fecha'); ?></th>
						<th><?php echo $this->Paginator->sort('factura_id','Factura'); ?></th>
						<th><?php echo 'Cliente'; ?></th>		
						<th><?php echo $this->Paginator->sort('cuentabancaria_id','Cuenta'); ?></th>
						<th><?php echo $this->Paginator->sort('monto','$'); ?></th>
						<th><?php echo $this->Paginator->sort('statusdeposito', 'Estado Pago'); ?></th>
						<th><?php echo 'Acción'; ?></th>
				</tr>
				<?php foreach ($pagos as $pago): 
						
				?>
						<tr>
							<td><?php 
									echo $pago['Pago']['id'];
								?>&nbsp;
							</td>
							<td><?php  echo h(date_format(date_create($pago['Pago']['created']), 'd-m-Y')); ?>&nbsp;</td>
							<td><?php 
									if (isset($acceso)){
										echo $pago['Pago']['factura_id'];
									}else{
										echo $this->Html->link($pago['Pago']['factura_id'], array('controller'=>'facturas','action' => 'view', $pago['Pago']['factura_id']),array('escape'=>false,'target'=>'_blank'));
									}
								?>&nbsp;
							</td>
							<td><?php echo $pago['Factura']['apellido'].', '.$pago['Factura']['nombre'];?></td>
							<td><?php echo (isset($listacuentas[$pago['Pago']['cuentabancaria_id']]))? $listacuentas[$pago['Pago']['cuentabancaria_id']]   : '-----'; ?>&nbsp;</td>
							<td><b>$<?php echo h($pago['Pago']['monto']); ?></b>&nbsp;</td>
							
							
							<td><?php echo ($pago['Pago']['statusdeposito'])? '<span class="label label-success">Aprobado</span>' : '<span class="label label-warning">Pendiente</span>'; ?>&nbsp;</td>

							<td><?php echo ($pago['Pago']['statusdeposito'])? $this->Html->link('<span class="mt-sm mb-sm btn btn-warning"> Pasar a Pendiente</span>',array('controller'=>'Pagos','action'=>'statusdepositobancario',$pago['Pago']['id'],0),array('escape'=>false)) : $this->Html->link('<span class="btn btn-success">Aprobar </span>',array('controller'=>'Pagos','action'=>'statusdepositobancario',$pago['Pago']['id'],1),array('escape'=>false)); ?>&nbsp;</td>



							
							
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