<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Seccion Pagos','shorturl'=>$label)); ?>
<?php
    echo $this->Form->create('Pago', array(
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
					echo $this->Form->hidden('factura_id');  
					echo $this->Form->input('tipopago_id',array('label'=>'Forma de Pago','options'=>$listatipodepagos,'empty'=>'Seleccione Pago','required'=>true));
					echo $this->Form->input('cuentabancaria_id',array('label'=>'Cuenta de Banco','options'=>$listacuentas,'empty'=>'Seleccione Cuenta' ,'div'=>'form-group cuentas-banco'));
				?>
					<div class="datos-cheques">
						<h3 style="color:#fff">Datos Cheque</h3>
					<?php
						echo $this->Form->input('Cheque.0.banco', array('label'=>'Banco Emisor','div'=>'form-group col-xs-12 col-md-4'));
						echo $this->Form->input('Cheque.0.fechacobro', array('label'=>'Ingrese Fecha de Cobro','date'=>'date','separator'=>'','dateFormat'=>'DMY','monthNames' => false,'maxYear' => date('Y')+1,'minYear' => date('Y')-1,'div'=>'form-group col-xs-12 col-md-4'));
						echo $this->Form->input('Cheque.0.nro', array('label'=>'Nro de Cheque','div'=>'form-group col-xs-12 col-md-4'));
						echo $this->Form->input('Cheque.0.titular', array('label'=>'Titular del Cheque','div'=>'form-group col-xs-12 col-md-4'));
						echo $this->Form->input('Cheque.0.cuit', array('label'=>'Cuit/Cuil Titular','div'=>'form-group col-xs-12 col-md-4'));
						echo $this->Form->input('Cheque.0.monto', array('label'=>'Ingrese Monto del Cheque',"step"=>"any","type"=>"number",'div'=>'form-group col-xs-12 col-md-4'));
						
					?>
						<div style='clear:both;'></div>
					</div>
			    <?php
			        echo $this->Form->input('monto', array('label'=>'<b>$ Monto a Pagar de la Factura </b>','required'=>true));
			        
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
								<th>Datos Cuenta Banc o Cheque</th>
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
							<td><?php echo h($listatipodepagos[$pago['Pago']['tipopago_id']]); ?>&nbsp;</td>
							<td><?php 
								if (!empty($pago['Pago']['cuentabancaria_id'])){
									echo $listacuentas[$pago['Pago']['cuentabancaria_id']];
								}
								if (($pago['Pago']['tipopago_id']==3) && (!empty($pago['Cheque']))){
									echo '<b> Banco:</b> '.h($pago['Cheque'][0]['banco']); 
									echo ' </br>  <b>Fecha Cobro:</b> '.h(date_format(date_create($pago['Cheque'][0]['fechacobro']), 'd-m-Y')); 
									echo ' </br>  <b>Titular:</b> '.h($pago['Cheque'][0]['titular']); 
									echo ' </br>  <b>Cuit:</b> '.h($pago['Cheque'][0]['cuit']); 
									echo ' </br>  <b>Nro:</b> '.h($pago['Cheque'][0]['nro']); 
								}
								?>&nbsp;
							</td>
							<td><?php echo h($pago['Pago']['monto']); ?>&nbsp;</td>
							<td><?php echo h($pago['Pago']['created']); ?>&nbsp;</td>
							<td><?php echo h($pago['Pago']['modified']); ?>&nbsp;</td>
							<td><?php echo ($pago['Pago']['status']=='0')? '<span class="label label-danger">Cancelado</span>' : '<span class="label label-success">Success</span>'; ?>&nbsp;</td>
							
							<td>
								<?php 
									if (isset($listaoperadores[$pago['Pago']['operador_id']])){
										echo $listaoperadores[$pago['Pago']['operador_id']];
										}else{
											echo 'Mercadopago';
										}

								?>&nbsp;

							</td>
							<td><?php echo h($pago['Pago']['infoextra']); ?>&nbsp;</td>
							<td class="actions">
								<?php echo ($pago['Pago']['status']=='0')? '--' : $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $pago['Pago']['id']), array('escape'=>false), __('¿Estás seguro que deseas cancelar  %s?',$pago['Pago']['monto'])); ?>&nbsp;
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					
				</div>
		
			</fieldset>
			
		</section>
	</div>
</section>
<style type="text/css">
.cuentas-banco{
	display: none;
}
.datos-cheques{
	display: none;
	background: #5bc0de;
    padding: 20px;
}
.datos-cheques label{
	color: #31708f;
    font-weight: bold;
    display: block;
}
.datos-cheques select{
	
    width: 33%;
    float: left;

}
</style>

<script type="text/javascript">

$('#PagoTipopagoId').on('change', function() {
  var seleccion=$(this).val();
  
  	$('.cuentas-banco').hide();
  	$('.datos-cheques').hide();
  	$('.datos-cheques input').val('');
  	$('#PagoCuentabancariaId').val("");
  

  	switch(seleccion){
	    case '2':
	    	console.log(seleccion);
	        $('.cuentas-banco').show();
  			$('#PagoCuentabancariaId').val("");
	        break;
	    case '3':
	        $('.datos-cheques').show();
	        $('.datos-cheques input').val('');
	        break;
	    default:
	    	$('.cuentas-banco').hide();
		  	$('.datos-cheques').hide();
		  	$('.datos-cheques input').val('');
		  	$('#PagoCuentabancariaId').val("");
		  	break;
	}

});


</script>