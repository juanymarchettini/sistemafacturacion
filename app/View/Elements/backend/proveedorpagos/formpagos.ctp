<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Seccion Proveedor Pagos','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('Proveedorpago', array(
    'action'=>$action,
    'type'=>'file',
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false
)); ?>

<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $label; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<div style="font-size: 16px; padding-top: 20px; padding-bottom: 20px;">
					
					<b>
						<p> Resumen de Pagos en la Factura</p>
						<?php
							
							echo '<p style="font-size:14px;"> Total Factura: $'.$totalfactura.' - <span style="color:#23D823"> Total Pagado: $'.$totalpagado.' </span> - <span style="color:red"> Resta Pagar: $'.$restofactura.'</span> </p>' ; 
						?>
					</b>
				</div>
				<?php 
				
					echo $this->Form->input('id');
					echo $this->Form->hidden('proveedorfactura_id',array('value'=>$factura['Proveedorfactura']['id']));  
					echo $this->Form->input('tipopago_id',array('label'=>'Forma de Pago','options'=>$listatipodepagos,'empty'=>'Seleccione Pago','required'=>true));
			        echo $this->Form->input('monto', array('label'=>'Ingrese Monto a Pagar','required'=>true,'step'=>'any','min'=>0, 'max'=>$restofactura));
			        echo $this->Form->input('nrocheque', array('label'=>'Ingrese Nro de Cheque (De ser necesario)'));
			        echo $this->Form->input('infoextra',array('label'=>'Informacion Extra'));
			        echo $this->Form->hidden('operador_id',array('value'=>$operadorid));
			        
		       	?>
			</fieldset>
			<?php
			echo $this->Form->submit(__('Guardar Pago '),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
		</section>
	</div>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Historial de Pagos de la Factura'); ?></legend>
				
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
								<th>Tipo de Pago</th>
								<th>Datos Cheque</th>
								<th>Monto ($)</th>
								<th>Fecha de Pago</th>
								<th>Modificado</th>
								<th>Estado</th>
								<th>Realizado Por</th>
								<th>Info Extra</th>
								
								<th class="actions"><?php echo __('Cancelar'); ?></th>
						</tr>
						<?php foreach ($pagos as $pago): ?>
						<tr>
							<td><?php echo h($listatipodepagos[$pago['Proveedorpago']['tipopago_id']]); ?>&nbsp;</td>
							<td><?php echo h($pago['Proveedorpago']['nrocheque']); ?>&nbsp;</td>
							<td><?php echo h($pago['Proveedorpago']['monto']); ?>&nbsp;</td>
							<td><?php echo h($pago['Proveedorpago']['created']); ?>&nbsp;</td>
							<td><?php echo h($pago['Proveedorpago']['modified']); ?>&nbsp;</td>
							<td><?php echo ($pago['Proveedorpago']['status']=='0')? '<span class="label label-danger">Cancelado</span>' : '<span class="label label-success">Success</span>'; ?>&nbsp;</td>
							
							<td><?php echo h($listaoperadores[$pago['Proveedorpago']['operador_id']]); ?>&nbsp;</td>
							<td><?php echo h($pago['Proveedorpago']['infoextra']); ?>&nbsp;</td>
							<td class="actions">
								<?php echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $pago['Proveedorpago']['id']), array('escape'=>false), __('¿Estás seguro que deseas cancelar  %s?',$pago['Proveedorpago']['monto'])); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					
				</div>
		
			</fieldset>
			
		</section>
	</div>
</section>