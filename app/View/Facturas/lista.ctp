<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Pedidos Realizados','shorturl'=>'Lista de Pedidos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Pedidos</h2>
	</header>
	<?php echo $this->element('backend/facturas/lista'); ?>
</section>

<style type="text/css">
.cancelada{
	background-color:red;
	color: #fff;
}
.entregado{
	background-color: #36B500;
}
.entregado td{
	color: #fff;
}
.entregado b{
	color:#000;
}
.actions{
	text-align: center;
}
</style>