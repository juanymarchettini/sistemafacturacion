<html>
	<head>
		<title>Pedidos Tienda Overall</title>
		<!-- Web Fonts  -->
		<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<?php echo $this->Html->css(array('vendor/bootstrap/css/bootstrap', 'theme/invoice-print.css'));
		?>
		
	</head>
	<body>
		<div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-xs-5 mt-md">
						
						<h4 class="h4 m-none text-dark text-weight-bold"><?php echo 'Pedido Nro: '.$pedido['Factura']['id']; ?></h4>
						<address class="ib mr-xlg" style="margin-bottom:0px;">
								
						</address>
					</div>
					<div class="col-xs-3  mt-md mb-md">
						<div class="ib">
							<?php echo $this->Html->image('logo.png',array('class'=>'img-responsive', 'alt'=>'Empresa')); ?>
							
						</div>
					</div>
					<div class="col-xs-4 text-right mt-md mb-md">
						<address class="ib mr-xlg" style="margin-bottom:0px;">
							Tu Empresa
							<br/>
							Phone: +29 XXXXXXXX
							<br/>
							info@empresa.com
						</address>
						
					</div>
				</div>
			</header>
			<div class="bill-info">
				<div class="row">
					<div class="col-md-6">
						<div class="bill-to">
							<p class="h5 mb-xs text-dark text-weight-semibold"><?php echo 'Cliente: '.$pedido['Factura']['apellido'].' , '.$pedido['Factura']['nombre'];?></p>
							<address>
								<?php echo  'Direccion: '.$pedido['Factura']['direccion'].' , '.$pedido['Factura']['localidad'].', CP:'.$pedido['Factura']['cp'];?>
							</address>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bill-data text-right">
							<p class="mb-none">
								<span class="text-dark"><?php echo 'Fecha Pedido:'.h(date_format(date_create($pedido['Factura']['created']), 'd-m-Y')); ?></span></br>
								<?php echo h($pedido['Factura']['tel']); ?>
								<br/>
								<?php echo h($pedido['Factura']['email']); ?>
							</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					<?php echo '<b>Mensaje:</b>'; ?>
								<br/>
								<?php echo $pedido['Factura']['message']; ?>
					</div>
				</div>
			</div>
		
			<div class="table-responsive">
				<table class="table invoice-items">
					<thead>
						<tr class="h5 text-dark">
							<th id="cell-id"     class="text-weight-semibold">Codigo</th>
							<th id="cell-item"   class="text-weight-semibold">Producto</th>
							<th id="cell-qty"    class="text-center text-weight-semibold">Cant.</th>
							<th id="cell-price"  class="text-center text-weight-semibold">$ (x Unit.)</th>
							<th id="cell-price"  class="text-center text-weight-semibold">( % IVA)</th>
							<th id="cell-total"  class="text-center text-weight-semibold">Subtotal</th>
						</tr>
					</thead>
					<tbody>
						<?php $total=0;
							foreach ($pedido['Detalle'] as  $value) {
								if (isset($productlistxcat[$value['producto_id']])){
									$idcategoria= $productlistxcat[$value['producto_id']];
									$cantidadporcategorias[$idcategoria] = $cantidadporcategorias[$idcategoria] + $value['cantidad'];
								}
							
							$total = $total + (float)$value['precio'] *  (float)$value['cantidad'] * (((float)$value['iva']/100)+1);
						?>
						<tr>
							<td><?php echo h($value['codigo']); ?>&nbsp;</td>
							<td class="text-weight-semibold text-dark"><?php echo h($value['nombre']); ?>&nbsp;</td>
							
							
							<td class="text-center"><?php echo h($value['cantidad']); ?>&nbsp;</td>
							<td class="text-center">$<?php echo h($value['precio']); ?>&nbsp;</td>
							<td class="text-center">%<?php echo h($value['iva']); ?>&nbsp;</td>
							<td class="text-center">$<?php echo  (float)$value['precio'] *  (float)$value['cantidad']* (((float)$value['iva']/100)+1); ?>&nbsp;</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		
			<div class="invoice-summary" style="position:relative; botton:0">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-8">
						<table class="table h5 text-dark">
							<tbody>
								
								<tr class="h4">
									<td colspan="2">Total</td>
									<td class="text-left">$<?php echo $total; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>

		<script>
			window.print();
		</script>
	</body>
</html>
<style type="text/css">
td {font-size: 13px;}
.table > tbody > tr > td{padding: 0px;}
.panel-body p{
	margin: 0 0 0px;
    
}
</style>