<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Listad de Pagos a Proveedores','shorturl'=>'Pago Proveedores')); ?>
<section class="panel panel-danger">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo 'Pagos a Proveedores' ?></h2>
	</header>	
	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro.'); ?></th>
							<th><?php echo $this->Paginator->sort('created','Fecha'); ?></th>
							<th><?php echo $this->Paginator->sort('proveedorfactura_id','Factura Proveedor Nro'); ?></th>
							<th><?php echo $this->Paginator->sort('proveedore_id','Proveedor'); ?></th>
							<th><?php echo $this->Paginator->sort('tipopago_id','Forma de Pago:'); ?></th>
							<th><?php echo $this->Paginator->sort('monto','Monto $'); ?></th>
							<th><?php echo $this->Paginator->sort('starus','Estado'); ?></th>
							<th><?php echo 'Ver Factura'?></th>
							
					</tr>
					<?php
						$totalpedido = 0;
						$totalefectivo = 0;
						$totaltransferencia = 0;
						$totalajuste = 0;

						$totalcheque = 0;
						$totaltarjetas = 0;;
						foreach ($pagos as $pago):
							
							if ($pago['Proveedorpago']['status']){
								
								switch ($pago['Proveedorpago']['tipopago_id']) {
									case '1':
										$totalefectivo=$totalefectivo+$pago['Proveedorpago']['monto'];
										$totalpedido = $totalpedido + $pago['Proveedorpago']['monto'];
										break;
									case '2':
										$totaltransferencia=$totaltransferencia+$pago['Proveedorpago']['monto'];
										$totalpedido = $totalpedido + $pago['Proveedorpago']['monto'];
										break;
									case '3':
										$totalcheque=$totalcheque+$pago['Proveedorpago']['monto'];
										$totalpedido = $totalpedido + $pago['Proveedorpago']['monto'];
										break;
									case '5':
										$totaltarjetas=$totaltarjetas+$pago['Proveedorpago']['monto'];
										$totalpedido = $totalpedido + $pago['Proveedorpago']['monto'];
										break;
									case '6':
										$totalajsute=$totalajsute+$pago['Proveedorpago']['monto'];
										break;
									
									default:
										# code...
										break;
								}
							}
					?>
							
								<td><?php echo h($pago['Proveedorpago']['id']); ?>&nbsp;</td>
								<td><?php  echo h(date_format(date_create($pago['Proveedorpago']['created']), 'd-m-Y')); ?>&nbsp;</td>
								<td><?php echo h($pago['Proveedorpago']['proveedorfactura_id']);?>&nbsp;</td>
								<td><?php echo $pago['Factura']['apellido'].' , '.$pago['Factura']['nombre']; ?>&nbsp;</td>
																
								<td><?php echo $listatipodepagos[$pago['Proveedorpago']['tipopago_id']]; ?></td>
								<td>$<?php echo h($pago['Proveedorpago']['monto']);?>&nbsp;</td>
								<td><?php echo ($pago['Proveedorpago']['status'])? '<b style="color:green;">Ok</b>': '<b style="color:red;">Cancelado</b>'; ?>&nbsp;</td>

								<td></td>
								
							</tr>
					<?php endforeach; ?>
				</table>
				<div class="col-xs-12">
					<p><?php echo 'Total Efectivo: $'.$totalefectivo; ?></p>
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


	</div>
</section>