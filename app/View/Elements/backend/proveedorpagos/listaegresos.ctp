
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							
							<th><?php echo $this->Paginator->sort('created','Fecha'); ?></th>
							<th><?php echo $this->Paginator->sort('proveedorfactura_id','FACTURA NRO'); ?></th>
							<th><?php echo $this->Paginator->sort('proveedore_id','Proveedore'); ?></th>
							<th><?php echo $this->Paginator->sort('tipopago_id','Forma de Pago:'); ?></th>
							<th><?php echo $this->Paginator->sort('monto','Monto $'); ?></th>
							<th><?php echo $this->Paginator->sort('starus','Estado'); ?></th>
							
					</tr>
					<?php
						$totalpagos = 0;
						$pagoefectivo = 0;
						$pagotransferencia = 0;
						$pagoajuste = 0;
						$pagocontra = 0 ;

						$pagocheque = 0;
						$pagotarjetas = 0;;
						 foreach ($movimientosegresos as $pago):
							
							if ($pago['Proveedorpago']['status']){
								
								switch ($pago['Proveedorpago']['tipopago_id']) {
									case '1':
										$pagoefectivo=$pagoefectivo+$pago['Proveedorpago']['monto'];
										$totalpagos = $totalpagos + $pago['Proveedorpago']['monto'];
										break;
									case '2':
										$pagotransferencia=$pagotransferencia+$pago['Proveedorpago']['monto'];
										$totalpagos = $totalpagos + $pago['Proveedorpago']['monto'];
										break;
									case '3':
										$pagocheque=$pagocheque+$pago['Proveedorpago']['monto'];
										$totalpagos = $totalpagos + $pago['Proveedorpago']['monto'];
										break;
									case '4':
										$pagoefectivo=$pagoefectivo+$pago['Proveedorpago']['monto'];
										$totalpagos = $totalpagos + $pago['Proveedorpago']['monto'];
										break;
									case '5':
										$pagotarjetas=$pagotarjetas+$pago['Proveedorpago']['monto'];
										$totalpagos = $totalpagos + $pago['Proveedorpago']['monto'];
										break;
									case '6':
										$pagoajuste=$pagoajuste+$pago['Proveedorpago']['monto'];
										break;
									
									default:
										# code...
										break;
								}
							}
					?>
							
								
								<td><?php  echo h(date_format(date_create($pago['Proveedorpago']['created']), 'd-m-Y')); ?>&nbsp;</td>
								<td><?php echo $this->Html->link($pago['Proveedorpago']['proveedorfactura_id'],array('controller'=>'Proveedorfacturas', 'action'=>'edit',$pago['Proveedorpago']['proveedorfactura_id']),array('target'=>'_blank'));?>&nbsp;</td>
								<td><?php echo isset($listaproveedores[$pago['Proveedorfactura']['proveedore_id']])? $listaproveedores[$pago['Proveedorfactura']['proveedore_id']] : '------' ; ?>&nbsp;</td>
								
																
								<td><?php echo $listatipodepagos[$pago['Proveedorpago']['tipopago_id']]; ?></td>
								<td>$<?php echo h($pago['Proveedorpago']['monto']);?>&nbsp;</td>
								<td><?php echo ($pago['Proveedorpago']['status'])? '<b style="color:green;">Ok</b>': '<b style="color:red;">Cancelado</b>'; ?>&nbsp;</td>
								
							</tr>
					<?php endforeach; ?>
				</table>
				<div class="col-xs-12" style="color:red">
					<p><?php echo 'Pagos con Efectivo: $'.$pagoefectivo; ?></p>
					<p><?php echo 'Pagos con Cheque: $'.$pagocheque; ?></p>
					<p><?php echo 'Pagos con Transferencia: $'.$pagotransferencia; ?></p>
					<p><?php echo 'Pagos con MercadoPago: $'.$pagotarjetas; ?></p>
					<p><?php echo 'Pagos con Ajuste (No entra en Total Caja): $'.$pagoajuste; ?></p>
					<p><?php echo '<b>Total pagos: $</b>'.$totalpagos; ?></p>

				</div>
			</div>
		</section>
	
	
	</div>