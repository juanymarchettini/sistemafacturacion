<div class="panel-body">
	<section  class="col-md-12">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th><?php echo $this->Paginator->sort('factura_id','Factura'); ?></th>
					<th><?php echo $this->Paginator->sort('bancocheque','Banco'); ?></th>
					<th><?php echo $this->Paginator->sort('fechacobrocheque','Fecha Cobro'); ?></th>
					<th><?php echo $this->Paginator->sort('titularcheque','Titular'); ?></th>
					<th><?php echo $this->Paginator->sort('cuitcheque','Cuit'); ?></th>
					<th><?php echo $this->Paginator->sort('nrocheque','Nro Cheque'); ?></th>
					<th><?php echo $this->Paginator->sort('monto','$'); ?></th>
					<th><?php echo $this->Paginator->sort('estadocheque_id','Estado'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Fecha Recepción'); ?></th>
					<th><?php echo $this->Paginator->sort('proveedor_id','Entregado A:'); ?></th>
				</tr>
				<?php foreach ($cheques as $cheque):
						
				?>
						<tr>
							<td><?php 
									echo $cheque['Pago']['factura_id'];
								?>&nbsp;
							</td>
							<td><?php 
									echo $cheque['Cheque']['banco'];
								?>&nbsp;
							</td>
							<td><?php  echo h(date_format(date_create($cheque['Cheque']['fechacobro']), 'd-m-Y')); ?>&nbsp;</td>
							<td><?php 
									echo $cheque['Cheque']['titular'];
								?>&nbsp;
							</td>
							<td><?php 
									echo $cheque['Cheque']['cuit'];
								?>&nbsp;
							</td>
							<td><?php 
									echo $cheque['Cheque']['nro'];
								?>&nbsp;
							</td>
							<td><?php 
									echo $cheque['Cheque']['monto'];
								?>&nbsp;
							</td>
							<td><?php 
									echo $listaestadocheque[$cheque['Cheque']['estadocheque_id']];
								?>&nbsp;
							</td>
							<td><?php  echo h(date_format(date_create($cheque['Cheque']['created']), 'd-m-Y H:i')); ?>&nbsp;</td>

							<td><?php echo $cheque['Cheque']['proveedorpago_id']; ?>&nbsp;</td>

							
							
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