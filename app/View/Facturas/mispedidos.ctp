<?php
 echo $this->Html->css(array("vendor/magnific-popup/magnific-popup" ));
?>
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><?php echo $this->Html->link('Menú',array('controller'=>'categorias', 'action'=>'home')); ?></li>
				  <li><?php echo $this->Html->link('Ver Historial de Pagos',array('controller'=>'Pagos', 'action'=>'vermispagos')); ?></li>
				  <li class="active">Lista de Pedidos</li>
				</ol>
			</div>
			<div class="review-payment">
				<h2>Lista de Mis Pedidos</h2>
			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<th><?php echo $this->Paginator->sort('id','Nro Pedido.'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Usuario'); ?></th>
							<th><?php echo $this->Paginator->sort('created','Realizado'); ?></th>
							
							<th><?php echo $this->Paginator->sort('total','Total'); ?></th>
							<th><?php echo 'Pagado' ?></th>
							<th><?php echo $this->Paginator->sort('statuspago','Estado Pago'); ?></th>
							<th><?php echo $this->Paginator->sort('empaquetado','Estado'); ?></th>
							<th> <?php echo 'Envio'; ?>
							<th><?php echo $this->Paginator->sort('fechaenvio','Fecha de Envio'); ?></th>
							<th><?php echo 'Ver'; ?></th>
							<th><?php echo 'Info Extra'; ?></th>
						
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pedidos as $pedido):
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
										
										<td><?php  echo h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y H:m')); ?>&nbsp;</td>
										
										<td>$<?php echo h($pedido['Factura']['total']); ?>&nbsp;</td>
										
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
										<td><?php 
												if ($pedido['Factura']['empaquetado']){

													if ($pedido['Factura']['entregado']){
														echo '<b style="color:green">Armado</b>';
													}else{
														echo '<b style="color:#FFA011">Armado ( Pase a Retiralo) </b>';
													}

												}else{
													echo '<b style="color:red"> Sin Armar </b>'; 
												}
											?>

										</td>

										<td><?php echo ($pedido['Factura']['entregado'])? '<b style="color:green">Entregado</b>': '<b style="color:#FFA011"> En Cola de Envio</b>'; ?>&nbsp;</td>
										
										<td><?php  echo h(date_format(date_create($pedido['Factura']['fechaenvio']), 'd-m-Y')); ?>&nbsp;</td>

										<td class="actions">
											<?php echo $this->Html->link(__('Ver'), array('action' => 'vermispedidos', $pedido['Factura']['id'])); ?>
											
											
										</td>
										<td class="actions">
											<?php 
											if($pedido['Factura']['tipodepago']=='Deposito'){
												echo '<a href="#test-popup" class="open-popup-link">Cuentas Bancos</a>';
											}  
											if(($pedido['Factura']['tipodepago']=='TarjetadeCredito')&&($pedido['Factura']['statuspago']!='Pagado'))
											{
												echo $this->Html->link('Cupon Mercadopago',array('controller'=>'Facturas','action'=>'comprafinalizada',$pedido['Factura']['id']));
											} 
											?>
											
										</td>
										
										
									</tr>
								<?php endforeach; ?>
						
					</tbody>
				</table>
				<?php
					echo $this->Paginator->counter(array(
					'format' => __('Página {:page} de {:pages}')
					));
					?>	</p>
					<div class="paging pagination">
						<?php
							echo $this->Paginator->prev('< ' . __('Anterior - '), array(), null, array('class' => 'prev disabled'));
							echo $this->Paginator->numbers(array('separator' => ' - '));
							echo $this->Paginator->next(__(' - Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
						?>
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<style type="text/css">
	 thead a, thead a:hover{color: #fff}

	</style>



<?php echo $this->Html->script(array('vendor/magnific-popup/magnific-popup')); ?>
	
<div id="test-popup" class="white-popup mfp-hide">
  	<div class="col-sm-12" style="text-align:center; margin:0 auto; background: #fff; padding: 20px;">
		<h2> Cuentas Bancarias para Deposito </h2>
		<span class="col-sm-12" style="margin-bottom:20px;"><b>Recuerde que una vez realizado el pago debe enviarnos  una foto del comprobante y el numero de pedido al que corresponde al correo <b>overallbahia@gmail.com</b>. Muchas gracias </b> </span>
		<div class="col-sm-6 col-sm-offset-1" style="text-align:left; margin:0 auto;">
			<b>Banco Galicia</b><br>
			Titular: Ningbo SA <br>
			CUIT: 33-71137774-9 <br>
			Cuenta Corriente: 6311/1 <br>
			CBU: 0070095520000006311188<br>
			Sucursal: 095 – 8 Munro<br>
		</div>
		<div class="col-sm-5" style="text-align:left; margin:0 auto;">
			<b>CREDICOOP </b><br>
			Titular: Ningbo SA <br>
			CUIT: 33-71137774-9 <br>
			Cuenta Corriente: 004779/3<br>
			CBU: 1910033955003300477932<br>
			Sucursal: 033 – Munro<br>
		</div>
	</div>
</div>

<style type="text/css">
.white-popup {
  position: relative;
  background: #FFF;
  
  width: auto;
  max-width: 500px;
  margin: 20px auto;
}

</style>
<script type="text/javascript">
$('.open-popup-link').magnificPopup({
  type:'inline',
  midClick: true 
});

</script>