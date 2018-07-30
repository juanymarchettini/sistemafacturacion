<?php echo $this->Element('backend/headerpage',array('titleheader'=>$titulo,'shorturl'=>'Listado')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $titulo; ?></h2>	
	</header>
	
    <div id='ajaxlistafact'>
	<?php echo $this->element('backend/facturas/listartodo'); ?>
	</div>
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
