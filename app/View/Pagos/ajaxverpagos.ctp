<div id="custom-content" class="modal-block modal-block-lg">
		<header class="panel-heading">
			<h2 class="panel-title">Historial de Pagos</h2>
		</header>
		<section class="panel">
			<div class="panel-body">
				
				
				<div class="table-responsive">
					<table class="table table-hover">
						<tr>
								<th>Tipo de Pago</th>
								<th>Datos Cheque</th>
								<th>Monto ($)</th>
								<th>Fecha de Pago</th>
								<th>Estado</th>
								<th>Realizado Por</th>
								
								<th class="actions"><?php echo __('Cancelar'); ?></th>
						</tr>
						<?php foreach ($pagos as $pago): ?>
						<tr>
							<td><?php echo h($listatipodepagos[$pago['Pagospendiente']['tipopago_id']]); ?>&nbsp;</td>
							<td><?php echo h($pago['Pagospendiente']['nrocheque']); ?>&nbsp;</td>
							<td><?php echo h($pago['Pagospendiente']['monto']); ?>&nbsp;</td>
							<td><?php echo h($pago['Pagospendiente']['created']); ?>&nbsp;</td>
							<td><?php if ($pago['Pagospendiente']['status']=='0'){ 
										  echo'<b>Cancelado</b>';
									  }else{ 
									  	if ($pago['Pagospendiente']['status']=='1'){
									  		echo 'Ok'; 
									  	}else{
									  		echo '<b style="color:orange">Pendiente de Aprobación</b>';
									  	}
									  }

								?>&nbsp;</td>
							<td><?php echo h($listaoperadores[$pago['Pagospendiente']['operador_id']]); ?>&nbsp;</td>
							<td class="actions">
								<?php  if ($this->Session->read('Auth.User.role')=='admin'){echo $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array('controller'=>'Pagos','action' => 'deletecontrareembolso', $pago['Pagospendiente']['id']), array('escape'=>false), __('¿Estás seguro que deseas cancelar  %s?',$pago['Pagospendiente']['monto'])); } ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
					
				</div>
		
			</div>
			
		</section>
		<footer class="panel-footer">
			<div class="row">
				<div class="col-md-12 text-right">
					<button class="btn btn-success modal-dismiss">Cerrar</button>
				</div>
			</div>
		</footer>
	</div>