<?php echo $this->Element('backend/headerpage',array('titleheader'=>$titulo,'shorturl'=>'Facturas Compra')); ?>
<section class="panel panel-danger">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $titulo; ?></h2>	
		<div class="panel-body ">
			<?php
			    echo $this->Form->create('Proveedorfactura', array(
			    'action'=>'listafacturas',
			    'inputDefaults' => array(
			        'div' => 'form-group',
			        'wrapInput' => false,
			        'class' => 'form-control'
			    ),
			    'class' => false
			)); 
			    echo $this->Form->hidden('esgasto',array('value'=>$esgasto));
			?>
			
		        <div class="col-xs-12 col-md-6">
					<label class="col-md-12 control-label">Fechas de Facturas</label>
					
						<div class="input-daterange input-group" data-plugin-datepicker>
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<input type="text" class="form-control" name="data[Proveedorfactura][start]">
							<span class="input-group-addon">Hasta</span>
							<input type="text" class="form-control" name="data[Proveedorfactura][end]">
						</div>

				</div>
				
				<div class="col-xs-6 col-md-6">
			    	
						<label class="col-md-12 control-label">Proveedor</label>
						
							<?php echo $this->Form->input('proveedor_id',array('label'=>false,'options'=>$listaproveedores,'empty'=>'Todos los Proveedores')); ?>

			    </div>
			    <?php 
			    	if (isset($resumentexto)){
			    ?>
			    	<div class="col-xs-12 col-md-12" style="font-size:15px; margin-top:20px;">
			    		<?php echo $resumentexto; ?>
			    	</div>
			    <?php		
			    	}
			    ?>

			    <div class="col-xs-12 col-md-12">
			    <?php
					echo $this->Form->submit(__('Buscar'),array('class'=>'mb-xs mt-xs mr-xs btn btn-default'));
				?>
				</div>
						
			  <?php  echo $this->Form->end(); ?>
		</div>
	    
	</header>
	
    <div id='ajaxlistafact'>
	<?php echo $this->element('backend/facturascompra/listafacturas'); ?>
	</div>
</section>
<?php echo $this->element('sql_dump'); ?>
