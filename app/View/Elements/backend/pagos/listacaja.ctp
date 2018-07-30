
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							
							<th><?php echo $this->Paginator->sort('created','Fecha'); ?></th>
							<th><?php echo $this->Paginator->sort('factura_id','FACTURA NRO'); ?></th>
							<th><?php echo $this->Paginator->sort('cliente_id','Cliente'); ?></th>
							<th><?php echo 'Localidad'; ?></th>
							<th><?php echo $this->Paginator->sort('tipopago_id','Forma de Pago:'); ?></th>
							<th><?php echo $this->Paginator->sort('monto','Monto $'); ?></th>
							<th><?php echo $this->Paginator->sort('starus','Estado'); ?></th>
							
					</tr>
					<?php
						$totalpedido = 0;
						$totalefectivo = 0;
						$totaltransferencia = 0;
						$totalajuste = 0;
						$totalcontra = 0 ;

						$totalcheque = 0;
						$totaltarjetas = 0;;
						 foreach ($movimientos as $pago):
							
							if ($pago['Pago']['status']){
								
								switch ($pago['Pago']['tipopago_id']) {
									case '1':
										$totalefectivo=$totalefectivo+$pago['Pago']['monto'];
										$totalpedido = $totalpedido + $pago['Pago']['monto'];
										break;
									case '2':
										$totaltransferencia=$totaltransferencia+$pago['Pago']['monto'];
										$totalpedido = $totalpedido + $pago['Pago']['monto'];
										break;
									case '3':
										$totalcheque=$totalcheque+$pago['Pago']['monto'];
										$totalpedido = $totalpedido + $pago['Pago']['monto'];
										break;
									case '4':
										$totalcontra=$totalcontra+$pago['Pago']['monto'];
										$totalpedido = $totalpedido + $pago['Pago']['monto'];
										break;
									case '5':
										$totaltarjetas=$totaltarjetas+$pago['Pago']['monto'];
										$totalpedido = $totalpedido + $pago['Pago']['monto'];
										break;
									case '6':
										$totalajsute=$totalajsute+$pago['Pago']['monto'];
										break;
									
									default:
										# code...
										break;
								}
							}
					?>
							
								
								<td><?php  echo h(date_format(date_create($pago['Pago']['created']), 'd-m-Y')); ?>&nbsp;</td>
								<td><?php echo $this->Html->link($pago['Pago']['factura_id'],array('controller'=>'Facturas', 'action'=>'view',$pago['Pago']['factura_id']),array('target'=>'_blank'));?>&nbsp;</td>
								<td><?php echo $pago['Factura']['apellido'].' , '.$pago['Factura']['nombre']; ?>&nbsp;</td>
								<td><?php echo $pago['Factura']['localidad']; ?>&nbsp;</td>
																
								<td><?php echo $listatipodepagos[$pago['Pago']['tipopago_id']]; ?></td>
								<td>$<?php echo h($pago['Pago']['monto']);?>&nbsp;</td>
								<td><?php echo ($pago['Pago']['status'])? '<b style="color:green;">Ok</b>': '<b style="color:red;">Cancelado</b>'; ?>&nbsp;</td>
								
							</tr>
					<?php endforeach; ?>
				</table>
				<div class="col-xs-12" style="color:green;">
					<p><?php echo 'Total Efectivo: $'.$totalefectivo; ?></p>
					<p><?php echo 'Total Contrareembolso: $'.$totalcontra; ?></p>
					<p><?php echo 'Total Cheque: $'.$totalcheque; ?></p>
					
					<p><?php echo 'Total Transferencia: $'.$totaltransferencia; ?></p>
					<p><?php echo 'Total Tarjeta de Credito: $'.$totaltarjetas; ?></p>
					<p><?php echo 'Total Ajuste (No entra en Total Caja): $'.$totalajuste; ?></p>
					<p><?php echo '<b>Total Caja: $</b>'.$totalpedido; ?></p>

				</div>
			</div>
		</section>
	
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

<?php //echo $this->element('sql_dump'); ?>