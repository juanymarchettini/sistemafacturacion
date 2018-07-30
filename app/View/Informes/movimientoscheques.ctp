<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Movimientos de Cheques','shorturl'=>'Movimientos de Cheques')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo 'Lista de Cheques'; ?></h2>
		</br>
		<?php  /* foreach ($pagostotal as $cuentapago) {  ?>
					<span style="font-size: 16px; color: #000;"class="panel-action">
						<?php echo (isset($listacuentas[$cuentapago['Pago']['cuentabancaria_id']]))? 'Cheque total' : 'Total Cehque'; ?> 
					</span>
					<span style="font-size: 16px; color: green; font-weight: bold;" class="panel-action">: $1200 ?></span>
					</br>
			<?php } */ ?>	
	</header>
	<div class="col-xs-12 col-md-12 " style="margin-top:10px; margin-bottom:10px;">
		<div class="panel-body bg-primary">
			<?php
			    echo $this->Form->create('Cheque', array(
			    'inputDefaults' => array(
			        'div' => 'form-group',
			        'wrapInput' => false,
			        'class' => 'form-control'
			    ),
			    'class' => false
			)); ?>
			
		        <div class="col-xs-12 col-md-6">
					<label class="col-md-12 control-label">Fechas de Recpeción</label>
					
						<div class="input-daterange input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="data[Cheque][start]">
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control" name="data[Cheque][end]">
						</div>

				</div>
				<div class="col-xs-12 col-md-6">
						<label class="col-md-12 control-label">Estado del Cheque</label>
							<select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Cheque][estadocheque][]" data-plugin-multiselect id="ms_example2">
									<?php foreach ($listaestadocheque as $key => $estado) {
											echo "<option value=".$key." selected>".$estado."</option>";
									 }	?>
							</select>
			    </div>
			    <div class="col-xs-12 col-md-5">
					<label class="col-md-12 control-label">Nro de Cheque</label>
					<input type="text" class="form-control" name="data[Cheque][nro]">

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
		<?php echo $this->element('backend/informes/listadecheques'); ?>
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



</script>

<?php 	//echo $this->element('sql_dump'); ?>