<html>
	<head>
		<title>Envios de Producto</title>
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
					<div class="col-md-12" >
						<div class="ib" style="text-align:center;">
							<?php echo $this->Html->image('logo.png',array('height'=>'60px', 'alt'=>'Overall')); ?>				
						</div>
					</div>
				</div>
				<br/><br/>
				<div class="row"  style="text-align:center;">
					
					<div class="col-sm-12 mt-md mb-md">
						<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">Envia:</h2>
						<address class="ib mr-xlg">
							Datos de la Empresa
							<br/>
							Tel: +xxxxxx
							<br/>
							Mar del Plata, Buenos Aires, Argentina
							<br/>
							info@empresa.com
						</address>
						
					</div>
				</div>
			</header>
			<div class="bill-info">
				<div class="row">
					<div class="col-md-12" style="text-align:center;">
						<div class="bill-to">
							<h2 class="h2 mt-none mb-sm text-dark text-weight-bold">Destinatario:</h2>
							<address>
								
								<?php echo $pedido['Factura']['apellido'].' , '.$pedido['Factura']['nombre'];?>
								<br/>
								<?php echo  $pedido['Factura']['direccion'].' , '.$pedido['Factura']['localidad'] ?>
								<br/>
								<?php echo h($pedido['Factura']['tel']); ?>
								<br/>
								<?php echo h($pedido['Factura']['email']); ?>
								<h4 class="h4 m-none text-dark text-weight-bold"><?php echo 'Pedido Nro: '.$pedido['Factura']['id']; ?></h4>
							</address>
						</div>
					</div>
					
				</div>
				
			</div>
		
			
				
						<?php $total=0;
							foreach ($pedido['Detalle'] as  $value) {
								if (isset($productlistxcat[$value['producto_id']])){
									$idcategoria= $productlistxcat[$value['producto_id']];
									$cantidadporcategorias[$idcategoria] = $cantidadporcategorias[$idcategoria] + $value['cantidad'];
								}
							$total = $total + (float)$value['precio'] *  (float)$value['cantidad'];
						?>
						
						<?php } ?>
		
			
			
		<div class="row">
					<div class="col-md-12" >
						<div class="ib" style="text-align:center;">
							<?php echo $this->Html->image('logo.png',array('height'=>'60px', 'alt'=>'Overall')); ?>				
						</div>
					</div>
		</div>
		</div>

		<script>
			window.print();
		</script>
		<style type="text/css">
		address {
			font-size: 20px;
		}
		</style>
	</body>

</html>