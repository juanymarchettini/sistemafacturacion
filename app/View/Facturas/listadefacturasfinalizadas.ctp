<?php echo $this->Element('backend/headerpage',array('titleheader'=>$titulo,'shorturl'=>'Facturas')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $titulo.' (Entregados y Pagados)'; ?></h2>	
	</header>
	<div class="col-xs-12 col-md-4 " style="margin-top:10px; margin-bottom:10px;">
		<?php
		    echo $this->Form->create('Factura', array(
		    'action'=>'listadefacturasfinalizadas',
		    'inputDefaults' => array(
		        'div' => 'form-group',
		        'wrapInput' => false,
		        'class' => 'form-control'
		    ),
		    'class' => false
		)); ?>
		<div action="#" class="search nav-form ">
	        <div class="input-group input-search">
	          <?php echo $this->Form->input('searchfact',array('label'=>false, 'class'=>"form-control" ,'placeholder'=>'Buscar factura','value'=>$search)); ?>
	          
	          <span class="input-group-btn">
	          	<?php echo $this->Form->button('<i class="fa fa-search"></i>',array('id'=>'ajaxbuscar', 'class'=>"btn btn-default", 'type'=>'button'), array('escape'=>false)); ?>
	           
	          </span>
	        </div>
	     </div>
    </div>
    <div id='ajaxlistafact'>
	<?php echo $this->element('backend/facturas/listafacturas'); ?>
	</div>
</section>
<script>
$("#searchfact").keypress(function(e) {
       if(e.which == 13) {
            var buscar=$('#searchfact').val();
			if (buscar.length ==0 ){
				alert('Campo de Busqueda Vacio');
			}else{
				
				$('#FacturaListadefacturasfinalizadasForm').submit();
			}
       }
});


$('#ajaxbuscar').click(function(){

		var buscar=$('#searchfact').val();

		if (buscar.length ==0 ){
			alert('Campo de Busqueda Vacio');
		}else{

			$('#FacturaListadefacturasfinalizadasForm').submit();

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