
<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Caja','shorturl'=>$label)); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</header>	
	<div class="panel-body">
		<section  class="col-md-12 panel">
			<div class="panel-body bg-primary">
				<?php
					//debug($this->request->data);
				    //if (isset($this->request->data)){debug($this->request->data);}
				    echo $this->Form->create('Pago', array(
				    'action'=>'caja',
				    
				    'inputDefaults' => array(
				        'div' => 'form-group',
				        'wrapInput' => false,
				        'class' => 'form-control'
				    ),
				    'class' => false
				)); ?>

					<div class="form-group">
						<label class="col-md-3 control-label">Date range</label>
						<div class="col-md-6">
							<div class="input-daterange input-group" data-plugin-datepicker>
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control" name="data[Pago][start]">
								<span class="input-group-addon">Hasta</span>
								<input type="text" class="form-control" name="data[Pago][end]">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Tipos de Pago</label>
						<div class="col-md-6">
							<select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Pago][tiposdepagos][]" data-plugin-multiselect id="ms_example2">
								<?php foreach ($listatipodepagos as $key => $tipopago) { ?>
									
										<?php echo '<option value="'.$key.'" selected>'.$tipopago.'</option>'; ?>
										
								<?php } ?>
							</select>
						</div>

					</div>
					<div class="form-group">
							<label class="col-md-3 control-label" for="inputDefault">Cliente/Nro Factura</label>
							<div class="col-md-6">
								<input type="text" class="form-control" id="inputDefault" name="data[Pago][inputclientefact]">
							</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label" for="inputSuccess">Estado de Pago</label>
						<div class="col-md-6">
							
							<label class="checkbox-inline">
								<input type="checkbox" checked  id="inlineCheckbox1" value="1" name="data[Pago][pago-aceptado]"> Ok
							</label>
							<label class="checkbox-inline">
								<input type="checkbox" checked  id="inlineCheckbox2" value="2" name="data[Pago][pago-cancelado]"> Cancelado
							</label>
						</div>
					</div>
					<?php
						echo $this->Form->submit(__('Buscar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-default'));
						echo $this->Form->end();
					?>
					
				
			</div>

		</section>
		<div id="ajax_respuestabusqueda">
			<section  class="col-xs-12 col-md-12">
				<legend> Ingresos </legend>
					<section  class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<tr>
											
											<th><?php echo 'Fecha'; ?></th>
											<th><?php echo 'FACTURA NRO'; ?></th>
											<th><?php echo 'Cliente'; ?></th>
											<th><?php echo 'Localidad'; ?></th>
											<th><?php echo 'Forma de Pago:';?></th>
											<th><?php echo 'Extra:';?></th>
											<th><?php echo 'Monto $'; ?></th>
											<th><?php echo 'Estado'; ?></th>
											
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
														$totalajuste=$totalajuste+$pago['Pago']['monto'];
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
					
						
						
			</section>
			<section  class="col-xs-12 col-md-12">
				<legend> Egresos </legend>
				<section  class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
										
										<th><?php echo 'Fecha'; ?></th>
										<th><?php echo 'FACTURA NRO'; ?></th>
										<th><?php echo 'Proveedore'; ?></th>
										<th><?php echo 'Forma de Pago:'; ?></th>
										<th><?php echo 'Monto $'; ?></th>
										<th><?php echo 'Estado'; ?></th>
										
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
			
				
					<div class="step-one" >
						<legend style="padding-top:60px;">Detalle Caja Chica</legend>
					</div>
					<table class="table table-condensed total-result">
						<tr>
							<td style="color:green">Efectivo+Contra Ingreso</td>
							<td><span>$ </span><span class=""> <?php $efetotal= $totalefectivo+$totalcontra;  echo $efetotal  ?></span>.-</td>
						</tr>
					    <tr class="shipping-cost">
							<td style="color:red">Efectivo Egreso</td>
							<td><span>$ </span><span class=""> <?php $pagototal=$pagoefectivo+$pagocontra; echo $pagototal ?></span>.-</td>										
						</tr>
						<tr>
							<td>Total Caja</td>
							<td><span>$ </span><span class=""><?php $totalcaja= $efetotal-$pagototal; echo $totalcaja ; ?></span>.-</td>
						</tr>
					</table>
				
			</section>
		</div>

	</div>
</section>
<?php
echo $this->Html->script(array('vendor/select2/js/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect' ));
?>
<script type="text/javascript">
$(document).on('ready',function(){       
    $('#btn-searchfiltros').click(function(){
        var url = '<?php echo $this->Html->url(array(
	   								"controller" => "pagos",
	    							"action" => "ajaxbusquedafiltros" ));?>';
        $.ajax({                        
           type: "POST",                 
           url: url,                     
           data: $("#ajaxbusquedafiltros").serialize(), 
           success: function(data)             
           {
             $('#ajax_respuestabusqueda').html(data);               
           }
       });
    });
});

</script>

