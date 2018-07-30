<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Listado de Deuda','shorturl'=>'Informes')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<div class="panel-actions">
			<span style="font-size: 20px; color: #000;"class="panel-action">Total de Deudas por Clietnes :$ </span>
			<span style="font-size: 20px; color: green; font-weight: bold;" class="panel-action"><?php echo $totalfinal; ?></span>
		</div>
		<h2 class="panel-title"><?php echo 'Lista de Facturas Adeudadas'; ?></h2>	
	</header>
	<div class="col-xs-12 col-md-12 " style="margin-top:10px; margin-bottom:10px;">
			    
    </div>
    <div id='ajaxlistafact'>
		<?php echo $this->element('backend/informes/deudastotalporcliente'); ?>
	</div>
</section>
<?php
echo $this->Html->script(array('vendor/select2/js/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect' ));
?>
<script>
$("#searchfact").keypress(function(e) {
       if(e.which == 13) {
            var buscar=$('#searchfact').val();
			if (buscar.length ==0 ){
				alert('Campo de Busqueda Vacio');
			}else{
				
				$('#FacturaListadefacturasForm').submit();
			}
       }
});


$('#ajaxbuscar').click(function(){

		var buscar=$('#searchfact').val();

		if (buscar.length ==0 ){
			alert('Campo de Busqueda Vacio');
		}else{

			$('#FacturaListadefacturasForm').submit();

		}


});
</script>
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
<?php 	//echo $this->element('sql_dump'); ?>