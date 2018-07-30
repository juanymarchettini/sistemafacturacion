<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><?php echo $this->Html->link('Mis Pedidos',array('controller'=>'Facturas', 'action'=>'mispedidos')); ?></li>
				  <li class="active">Pedido</li>
				</ol>
			</div>
			<div class="review-payment">
				<h2>Dettale del Pedido</h2>
			</div>
			<p>
		
				<b>Estado de Pedido: </b>
				<?php echo ($pedido['Factura']['entregado'])? 
					'<b style="color:green;">Entregado &nbsp;</b>'
					: 
					'<b style="color:#FFA011"> En Cola de Envio</b>';
				?>

				&nbsp;
			</p>
			<div class="table-responsive cart_info">
				
				<table class="table table-condensed">
					
						<tr class="cart_menu">
							<th><?php echo 'Nro Pedido.'; ?></th>
							<th><?php echo 'Apellido'; ?></th>
							<th><?php echo 'Nombre'; ?></th>
							<th><?php echo 'Tel'; ?></th>
							<th><?php echo 'Email'; ?></th>
							<th><?php echo 'Realizada'; ?></th>
							<th><?php echo 'Localidad'; ?></th>
							<th><?php echo 'Direccion'; ?></th>
						</tr>
						<tr>
							<td><?php echo h($pedido['Factura']['id']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['apellido']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['nombre']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['tel']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['email']); ?>&nbsp;</td>
							<td><?php echo h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y')); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['localidad']); ?>&nbsp;</td>
							<td><?php echo h($pedido['Factura']['direccion']); ?>&nbsp;</td>
						</tr>
						<tr> <td colspan="8"> <h3><?php echo __('Detalle Pedido'); ?></h3></td> </tr>
						<tr>
								
								<th  colspan="2"><?php echo 'Codigo'; ?></th>
								<th  colspan="3"><?php echo 'Nombre Producto'; ?></th>
								<th><?php echo 'Cantidad'; ?></th>
								<th  colspan="1"><?php echo 'PrecXuni'; ?></th>
								<th  colspan="2"><?php echo '$'; ?></th>
								
						</tr>
						<?php $total=0;
							foreach ($pedido['Detalle'] as  $value) {
								if (isset($productlistxcat[$value['producto_id']])){
									$idcategoria= $productlistxcat[$value['producto_id']];
									$cantidadporcategorias[$idcategoria] = $cantidadporcategorias[$idcategoria] + $value['cantidad'];
								}
							$total = $total + (float)$value['precio'] *  (float)$value['cantidad'];
						?>
						<tr>
							
							<td colspan="2"><?php echo h($value['codigo']); ?>&nbsp;</td>
							<td colspan="3"><?php echo h($value['nombre']); ?>&nbsp;</td>
							<td><?php echo h($value['cantidad']); ?>&nbsp;</td>
							<td colspan="1"><?php echo h($value['precio']); ?>&nbsp;</td>
							<td colspan="2"><?php echo  (float)$value['precio'] *  (float)$value['cantidad'] ; ?>&nbsp;</td>
							
						</tr>
						<?php } ?>
						<tr>
							<td colspan="2"> &nbsp;</td>
							<td colspan="8">&nbsp;</td>
							
						</tr>
						<tr>
							<td colspan="2"><?php echo '<b>TOTAL PEDIDO:</b>'; ?>&nbsp;</td>
							<td colspan="8"> <b> $<?php echo  $total; ?>.-</b></td>
							
						</tr>
										
					</tbody>
				</table>
				<div>
					<?php echo "<b>Mensaje de Pedido: </b>".$pedido['Factura']['message']; ?>
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->
	<style type="text/css">
	.breadcrumbs .breadcrumb li a:after{
	 	left: 90px;
	 }
	</style>