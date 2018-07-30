<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Lista de Depositos Bancarios','shorturl'=>'Informe de Depositos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo 'Pagos realizados por Depósitos'; ?></h2>
		</br>
		<?php  foreach ($pagostotal as $cuentapago) {  ?>
					<span style="font-size: 16px; color: #000;"class="panel-action">
						<?php echo (isset($listacuentas[$cuentapago['Pago']['cuentabancaria_id']]))? $listacuentas[$cuentapago['Pago']['cuentabancaria_id']] : 'Sin Asignar' ; ?> 
					</span>
					<span style="font-size: 16px; color: green; font-weight: bold;" class="panel-action">: $<?php echo $cuentapago[0]['total'] ; ?></span>
					</br>
			<?php } ?>	
	</header>
	<div class="col-xs-12 col-md-12 " style="margin-top:10px; margin-bottom:10px;">
		<div class="panel-body bg-primary">
			<?php
			    echo $this->Form->create('Pago', array(
			    'inputDefaults' => array(
			        'div' => 'form-group',
			        'wrapInput' => false,
			        'class' => 'form-control'
			    ),
			    'class' => false
			)); ?>
			
		        <div class="col-xs-12 col-md-6">
					<label class="col-md-12 control-label">Fechas de Pago</label>
					
						<div class="input-daterange input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="data[Pago][start]">
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control" name="data[Pago][end]">
						</div>

				</div>
				<div class="col-xs-12 col-md-6">
						<label class="col-md-12 control-label">Cuenta Bancaria</label>
							<select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Pago][cuentabancos][]" data-plugin-multiselect id="ms_example2">
										
										<?php 
										foreach ($listacuentas as $key => $value) {
											echo '<option value='.$key.' selected>'.$value.'</option>';
										}
										?>	
							</select>
			    </div>
			    <div class="form-group">
						<label class="col-md-3 control-label" for="inputSuccess">Estado de Deposito</label>
						<div class="col-md-6">
							
							<label class="checkbox-inline">
								<input type="checkbox" checked  id="inlineCheckbox1" value="1" name="data[Pago][pago-aceptado]"> Aceptado
							</label>
							<label class="checkbox-inline">
								<input type="checkbox" checked  id="inlineCheckbox2" value="2" name="data[Pago][pago-cancelado]"> Pendiente
							</label>
						</div>
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
		<?php echo $this->element('backend/informes/listadedepositos'); ?>
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