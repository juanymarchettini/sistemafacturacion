<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Pedidos Aprobados - Tiendaoverall.com.ar</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">	
		<tr>
			<td style="padding: 10px 0 30px 0;">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
					<tr>
						<td align="center" bgcolor="#70bbd9" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
							<img src="https://www.tiendaoverall.com.ar/img/logo.png" alt="TiendaOverall.com.ar" width="300" height="" style="display: block;" />
						</td>
					</tr>
					<tr>
						<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
										<b>Lista de Pagos:</b>
									</td>
								</tr>
								<tr>
									<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 12px; line-height: 20px;">
										<i>En este email se detallarán, pagos entregados, aprobados o cancelados con la fecha en que se realizo el mismo. Este email tiene como finalidad mostrar un breve resumen de las transacciones realizadas, en nuestro sistema. Desde ya muchas gracias. <b>Tiendaoverall.com.ar </b></i>
									</td>
								</tr>
								<tr>
									<td>
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tr>
												<td width="70" valign="top">
													Nro
												</td>
												<td width="90" valign="top">
													Nro Fact
												</td>
												<td width="150" valign="top">
													Cliente
												</td>
												<td width="150" valign="top">
													Fecha
												</td>
												<td width="80" valign="top">
													$
												</td>
												<td width="80" valign="top">
													Estado
												</td>
												
												
											</tr>
											<?php foreach ($pagos as $pago) { ?>
												
													<tr>
														<td width="70" valign="top" style="font-size:12px;">
														  <?php echo $pago['Pagospendiente']['id'];?>
														</td>
														<td width="90" valign="top" style="font-size:12px;">
															<?php echo $pago['Pagospendiente']['factura_id'];?>
														</td>
														<td width="180" valign="top" style="font-size:12px;">
															<?php echo $pago['Factura']['apellido'].' , '.$pago['Factura']['nombre']?>
														</td>
														<td width="150" valign="top" style="font-size:12px;">
															<?php echo date_format(date_create($pago['Pagospendiente']['modified']), 'd-m-Y H:i');?>
														</td>
														<td width="80" valign="top" style="font-size:12px;">
															<b>$<?php echo $pago['Pagospendiente']['monto'];?></b>
														</td>
														<td width="80" valign="top" style="font-size:12px;">
															<?php 
																if ($pago['Pagospendiente']['status']=='1'){
																 echo 'OK';
																}else{
																 echo 'Cancelado';
																}
															;?>
														</td>
													</tr>




											<?php } ?>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td bgcolor="#70bbd9" style="padding: 30px 30px 30px 30px;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
									<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
										&reg; TiendaOverall.com.ar<br/>
										<a href="http://www.netzone.com.ar" style="color: #ffffff;"><font color="#ffffff">by</font></a> Netzone.com.ar
									</td>
									<td align="right" width="25%">
										<table border="0" cellpadding="0" cellspacing="0">
											<tr>
												
												<td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
												<td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
													<a href="http://www.tiendaoverall.com.ar/" style="color: #ffffff;">
														<img src="https://www.tiendaoverall.com.ar/img/logo.png" alt="Facebook" width="80" height="38" style="display: block;" border="0" />
													</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>