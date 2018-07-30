<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Pedido Detalle','shorturl'=>'Pedido')); ?>
<?php 
	echo $this->Form->create('Factura', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false)); 
?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo 'Pedido #'.$pedido['Factura']['id']; ?></h2>
		<?php echo $this->Html->link('< Anterior',array('controller'=>'Facturas', 'action'=>'view',$anteriorysiguiente['prev']['Factura']['id']),array('escape'=>false)); ?>	
		<?php echo $this->Html->link('Siguiente >',array('controller'=>'Facturas', 'action'=>'view',$anteriorysiguiente['next']['Factura']['id']),array('escape'=>false)); ?>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php  echo __('Info Comprador'); ?></legend>
				<div class="mr-lg" style="float:right;">
					<?php
						echo ($pedido['Factura']['facturado'])?   ' ' : $this->Html->link('<i class="fa fa-pencil"></i> Editar Pedido',array('controller'=>'Facturas', 'action'=>'edit/'.$pedido['Factura']['id']),array('class'=>"btn btn-primary ml-sm", 'target'=>'_blank', 'escape'=>false)); 
					?>
					<?php echo $this->Html->link('<i class="fa fa-print"></i> Print Pedido',array('controller'=>'Facturas', 'action'=>'view/'.$pedido['Factura']['id'].'/factura'),array('class'=>"btn btn-primary ml-sm", 'target'=>'_blank', 'escape'=>false)); ?>	
					<?php echo $this->Html->link('<i class="fa fa-print"></i> Datos Encomienda',array('controller'=>'Facturas', 'action'=>'view/'.$pedido['Factura']['id'].'/encomienda'),array('class'=>"btn btn-primary ml-sm", 'target'=>'_blank', 'escape'=>false)); ?>	
					
								
						
				</div>	
				<h3><?php echo __('Comprador: '.ucwords($pedido['Factura']['nombre']).','.ucwords($pedido['Factura']['apellido'])); ?></h3>
				<p>
					
					<b>Pedido: </b>
					<?php echo ($pedido['Factura']['entregado'])? 
						'<b style="color:green;">Entregado &nbsp;</b>'.$this->Html->link(__('Esta sin Entregar'), array('action' => 'entregar_compra', $pedido['Factura']['id'],'0'))
						: 
						'<b style="color:red;">Sin Entregar &nbsp;</b>'.$this->Html->link(__('Fue Entregado'), array('action' => 'entregar_compra', $pedido['Factura']['id'],'1')); 
					?>

					&nbsp;
				</p>
				<p>
					<b>Estado Factura:</b> 

					<?php echo ($pedido['Factura']['facturado'])? 
						'<b style="color:green;">Facturado &nbsp;</b>'
						: 
						'<b style="color:red;">Sin Facturar &nbsp;</b>'.$this->Html->link(__('Facturar'), array('action' => 'facturarpedido', $pedido['Factura']['id'],1)); ?>&nbsp;
					
				</p>
				<p>
					
					<b>Usuario Nro:</b> 

					<?php echo 
						'<b>'.$pedido['Factura']['user_id'].'</b>';
					?>
					</br>
					<b>Armado Por:</b> 
					<?php echo (isset($operarios[$pedido['Factura']['armadopor']]))?
						$operarios[$pedido['Factura']['armadopor']] : '----';
					?>
					<b style="margin-left:20px;">Fecha de Armado:</b> 
					
					<?php echo (!empty($pedido['Factura']['fechaarmado']))?
						date_format(date_create($pedido['Factura']['fechaarmado']), 'd-m-Y H:m') : '----';
					?>
					</br>
					<b>Fecha de Envio:</b> 

					<?php echo  (!empty($pedido['Factura']['fechaenvio']))?
						date_format(date_create($pedido['Factura']['fechaenvio']), 'd-m-Y H:m') : 'Sin Entregar';
					?>
					
				</p>
				<div class="table-responsive">
					<table class="table table-hover" id="tableprice">
			
						<tr>
								<th><?php echo 'Nro Pedido.'; ?></th>
								<th><?php echo 'Apellido'; ?></th>
								<th><?php echo 'Nombre'; ?></th>
								<th><?php echo 'Tel'; ?></th>
								<th><?php echo 'Email'; ?></th>
								<th><?php echo 'Realizada'; ?></th>
								<th><?php echo 'Cp'; ?></th>
								<th><?php echo 'Localidad'; ?></th>
								<th><?php echo 'Direccion'; ?></th>
								
						</tr>
						<tr>
							<td><?php echo h($pedido['Factura']['id']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['apellido']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['nombre']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['tel']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['email']); ?>&nbsp;</td>
							<td><?php echo h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y H:m')); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['cp']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['localidad']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['direccion']); ?>&nbsp;</td>
						</tr>
					</table>
				</div>
			</fieldset>
			<div col="col-md-12">
				<div class="panel-group" id="accordion2">
					
					
					<div class="panel panel-accordion panel-accordion-primary">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse2One">
									<i class="glyphicon glyphicon-shopping-cart"></i> Detalle del Pedido
								</a>
							</h4>
						</div>
						<div id="collapse2One" class="accordion-body collapse in">
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover" id="tableprice">
							
										<tr> <td colspan="10"> <h3><?php echo __('Detalle Pedido'); ?></h3></td> </tr>
										<tr>
												
												<th  colspan="2"><?php echo 'Codigo'; ?></th>
												<th  colspan="3"><?php echo 'Nombre Producto'; ?></th>
												<th><?php echo 'Cantidad'; ?></th>
												<th  colspan="1"><?php echo 'PrecXuni'; ?></th>
												<th  colspan="1"><?php echo 'Iva'; ?></th>
												<th  colspan="1"><?php echo 'Subtotal'; ?></th>
												
										</tr>
										<?php $total=0;
											foreach ($pedido['Detalle'] as  $value) {
												if (isset($productlistxcat[$value['producto_id']])){
													$idcategoria= $productlistxcat[$value['producto_id']];
													$cantidadporcategorias[$idcategoria] = $cantidadporcategorias[$idcategoria] + $value['cantidad'];
												}
											$total = $total + (float)$value['precio'] *  (float)$value['cantidad'] * (((float)$value['iva']/100)+1) ;
										?>
										<tr>
											
											<td colspan="2"><?php echo h($value['codigo']); ?>&nbsp;</td>
											<td colspan="3"><?php echo h($value['nombre']); ?>&nbsp;</td>
											<td><?php echo h($value['cantidad']); ?>&nbsp;</td>
											<td colspan="1">$<?php echo h($value['precio']); ?>&nbsp;</td>
											<td colspan="1"><?php echo  (float)$value['iva'] ; ?>%&nbsp;</td>
											<td colspan="1">$<?php echo  (float)$value['precio'] *  (float)$value['cantidad'] * ((((float)$value['iva']/100)+1)) ; ?>&nbsp;</td>
											
										</tr>
										<?php } ?>
										<tr>
											<td colspan="2"> &nbsp;</td>
											<td colspan="8">&nbsp;</td>
											
										</tr>
										<tr>
											<td colspan="2"><?php echo '<b>TOTAL</b>'; ?>&nbsp;</td>
											<td colspan="8"> <b> $<?php echo  $total; ?>.-</b></td>
											
										</tr>
									</table>
								</div>

								<div class="col-xs-12 col-md-12">
									<?php 
										  echo $this->Form->input('message',array('label'=>'<b>Mensajes</b>','type'=>"textarea"));
									?>
								</div>
								<div class="col-xs-12">
									<?php
									echo $this->Form->submit(__('Guardar Datos'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
									echo $this->Form->end();
									?>

								</div>
							</div>
						</div>
					</div>
					
					<?php   if ($pedido['Factura']['facturado']){ ?>
							    <div class="panel panel-accordion panel-accordion-primary">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2bis" href="#collapse2bis">
												<i class="glyphicon glyphicon-usd"></i> Cobros
											</a>
										</h4>
									</div>
									<div id="collapse2bis" class="accordion-body collapse">
										<div class="panel-body">
											<div class="col-md-12">
												<fieldset>
													<legend>
														<?php echo $this->Html->link(('Nuevo Pago'),array('controller'=>'Pagos', 'action'=>'pagar',$pedido['Factura']['id']),array('class'=>'mb-xs mt-xs mr-xs btn btn-success','target'=>'_blank'));
														?>
													</legend>
													
													<div class="table-responsive">
														<table class="table table-hover">
															<tr>
																	<th>Tipo de Pago</th>
																	<th>Datos Cheque</th>
																	<th>Monto ($)</th>
																	<th>Fecha de Pago</th>
																	<th>Modificado</th>
																	<th>Estado</th>
																	<th>Realizado Por</th>
																	<th>Info Extra</th>
															
																	
															</tr>
															<?php  foreach ($pedido['Pago'] as $pago): ?>
															<tr>
																<td><?php echo h($listatipodepagos[$pago['tipopago_id']]); ?>&nbsp;</td>
																<td><?php echo h($pago['nrocheque']); ?>&nbsp;</td>
																<td><?php echo h($pago['monto']); ?>&nbsp;</td>
																<td><?php echo h($pago['created']); ?>&nbsp;</td>
																<td><?php echo h($pago['modified']); ?>&nbsp;</td>
																<td><?php echo ($pago['status']=='0')? '<span class="label label-danger">Cancelado</span>' : '<span class="label label-success">Success</span>'; ?>&nbsp;</td>
																
																<td>
																	<?php 
																		if (isset($listaoperadores[$pago['operador_id']])){
																			echo $listaoperadores[$pago['operador_id']];
																			}else{
																				echo 'Mercadopago';
																			}

																	?>&nbsp;

																</td>
																<td><?php echo h($pago['infoextra']); ?>&nbsp;</td>
																
															</tr>
															<?php endforeach; ?>
														</table>
														
													</div>
											
												</fieldset>
											</div>
										</div>
									</div>
								</div>
					<?php   } ?>
					
				</div>
			</div>
			
		</section>
	</div>
</section>
<style type="text/css">
td{
	padding: 0px;
}

</style>