<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Lista de Facturas Adeudadas','shorturl'=>'Informes')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<div class="panel-actions">
			<span style="font-size: 20px; color: #000;"class="panel-action">Total Por Cobrar:$ </span>
			<span style="font-size: 20px; color: green; font-weight: bold;" class="panel-action"><?php echo $totalfinal; ?></span>
		</div>
		<h2 class="panel-title"><?php echo 'Lista de Facturas Adeudadas'; ?></h2>	
	</header>
	<div class="col-xs-12 col-md-12 " style="margin-top:10px; margin-bottom:10px;">
		<div class="panel-body bg-primary">
			<?php
			    echo $this->Form->create('Informe', array(
			    'inputDefaults' => array(
			        'div' => 'form-group',
			        'wrapInput' => false,
			        'class' => 'form-control'
			    ),
			    'class' => false
			)); ?>
			
		        <div class="col-xs-12 col-md-6">
					<label class="col-md-12 control-label">Fechas de Pedidos</label>
					
						<div class="input-daterange input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="data[Factura][start]">
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control" name="data[Factura][end]">
						</div>

				</div>
				<div class="col-xs-12 col-md-6">
						<label class="col-md-12 control-label">Tipos de Pago</label>
							<select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Pago][tiposdepagos][]" data-plugin-multiselect id="ms_example2">
								
										<?php 
										echo '<option value="Contrareembolso" selected>Contrareembolso</option>';
										echo '<option value="Deposito" selected>Deposito/Transferencia</option>'; 
										echo '<option value="Efectivo" selected>Efectivo</option>'; 
										echo '<option value="TarjetadeCredito" selected>TarjetaddeCredito</option>'; 
										?>	
							</select>
			    </div>
			    <div class="col-xs-12 col-md-12">
			    <?php
					echo $this->Form->submit(__('Buscar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-default'));
				?>
				</div>
						
			  <?php  echo $this->Form->end(); ?>
		</div>
	    
    </div>
    <div id='ajaxlistafact'>
		<?php echo $this->element('backend/informes/listaimpagas'); ?>
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