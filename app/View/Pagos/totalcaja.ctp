<?php
echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Html->css(array('vendor/chartist/chartist')); ?>

<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Caja','shorturl'=>$label)); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</header>	
	<div class="panel-body">
		<section  class="col-md-12 panel">
			<div class="panel-body bg-primary">
				<?php
					
				    echo $this->Form->create('Pago', array(
				    'action'=>'totalcaja',
				    
				    'inputDefaults' => array(
				        'div' => 'form-group',
				        'wrapInput' => false,
				        'class' => 'form-control'
				    ),
				    'class' => false

				)); ?>

					
					<div class="form-group">
						<label class="col-md-3 control-label">Tipos de Pago</label>
						<div class="col-md-6">
							<select class="form-control" multiple="multiple" data-plugin-options='{ "maxHeight": 200 }' name="data[Pago][tiposdepagos][]" data-plugin-multiselect id="ms_example2">
								<?php foreach ($listatipodepagos as $key => $tipopago) { ?>
									
										<?php echo '<option value="'.$key.'" selected>'.$tipopago.'</option>'; ?>
										
								<?php } ?>
							</select>
						</div>

					</div>
					
					<?php
						echo $this->Form->submit(__('Buscar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-default'));
						echo $this->Form->end();
					?>
					
				
			</div>

		</section>
		<div id="ajax_respuestabusqueda">
			<section  class="col-xs-12 col-md-6">
				<legend> Ingresos </legend>
					<section  class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<tr>
											
											<th><?php echo 'Año+Mes'; ?></th>							
											<th><?php echo 'Monto $'; ?></th>
											
											
									</tr>
									<?php
										$totalingreso = 0;									
										 foreach ($movimientosingresos as $ingreso):		
										
										?>
											<tr>
												
												<td><?php  echo $ingreso[0]['aniomes']; ?>&nbsp;</td>
												
												<td>$<?php echo  $ingreso[0]['total']; $totalingreso=$totalingreso+ $ingreso[0]['total'] ?>&nbsp;</td>
												
												
											</tr>
									<?php endforeach; ?>
								</table>
								<div class="col-xs-12" style="color:green;">
									
									<p><?php echo '<b>Total Caja: $</b>'.$totalingreso; ?></p>
									<h3> <?php echo 'Nota '.$label; ?> </h3>

								</div>
							</div>
						</section>
					
						
						
			</section>
			<section  class="col-xs-12 col-md-6">
				<legend> Egresos </legend>
				<section  class="col-md-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
										
										<th><?php echo 'Año+Mes'; ?></th>
										<th><?php echo 'Pago $'; ?></th>
										
										
								</tr>
								<?php
									$totalpagos = 0;
									
									 foreach ($movimientosegresos as $egreso):		
								?>
										
											
											<td><?php  echo $egreso[0]['aniomes'] ?>&nbsp;</td>
											
											<td>$<?php echo h($egreso[0]['total']); $totalpagos=$totalpagos+$egreso[0]['total']; ?>&nbsp;</td>
											
											
										</tr>
								<?php endforeach; ?>
							</table>
							<div class="col-xs-12" style="color:red">
								
								<p><?php echo '<b>Total pagos: $</b>'.$totalpagos; ?></p>

							</div>
						</div>
					</section>
				
			</section>
			<section class="col-md-12">
				<div class="step-one" >
					<legend style="padding-top:60px;">Detalle  <?php echo $label; ?></legend>
				</div>
				<table class="table table-condensed total-result">
					<tr>
						<td style="color:green">Total Ingreso</td>
						<td><span>$ </span><span class=""> <?php echo $totalingreso  ?></span>.-</td>
					</tr>
				    <tr class="shipping-cost">
						<td style="color:red">Total Egreso</td>
						<td><span>$ </span><span class=""> <?php echo $totalpagos ?></span>.-</td>										
					</tr>
					<tr>
						<td>Total Caja</td>
						<td><span>$ </span><span class=""><?php $totalcaja= $totalingreso-$totalpagos; echo $totalcaja ; ?></span>.-</td>
					</tr>
				</table>
			</section>
		</div>
		<div class="row">
			<div class="col-md-12">
				<section class="panel col-md-8">
					<header class="panel-heading">
						
		
						<h2 class="panel-title">Detalle  <?php echo $label; ?></h2>
					</header>
					<div class="panel-body">
						<div id="ChartistLineChartWithTooltips" class="ct-chart ct-perfect-fourth ct-golden-section"></div>
		
						<!-- See: assets/javascripts/ui-elements/examples.charts.js for the example code. -->
					</div>
				</section>
			</div>
		</div>

	</div>
</section>
<?php
echo $this->Html->script(array('vendor/select2/js/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect','vendor/chartist/chartist' ));
?>



<script type="text/javascript">
var seriesingreso = <?php echo  json_encode($jsoningreso); ?>;
var seriesegreso = <?php echo  json_encode($jsonegreso); ?>;
var labelaux =<?php echo json_encode($listameses); ?>;
(function() {
	new Chartist.Line('#ChartistLineChartWithTooltips', {
		labels: labelaux,
		series: [ seriesingreso, seriesegreso]
	});

	var $chart = $('#ChartistLineChartWithTooltips');

	var $toolTip = $chart
		.append('<div class="tooltip"></div>')
		.find('.tooltip')
		.hide();

	$chart.on('mouseenter', '.ct-point', function() {
		var $point = $(this),
			value = $point.attr('ct:value'),
			seriesName = $point.parent().attr('ct:series-name');
		$toolTip.html(seriesName + '<br>' + value).show();
	});

	$chart.on('mouseleave', '.ct-point', function() {
		$toolTip.hide();
	});

	$chart.on('mousemove', function(event) {
		$toolTip.css({
			left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 - 10,
			top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() - 40
		});
	});
})();

</script>

