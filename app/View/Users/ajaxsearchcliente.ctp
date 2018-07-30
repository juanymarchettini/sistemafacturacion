<table class="table table-hover">
					<tr>
							<th>Usuario</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Telefono</th>
							<th class="actions"><?php echo __('Password'); ?></th>
							<th class="actions"><?php echo __('Ver Cuenta'); ?></th>
							
					</tr>
					<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['nombre']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['apellido']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['telefono']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="fa fa-key">Cambiar</span>', array('action' => 'editarpass', $user['User']['id']),array('escape'=>false)); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="fa fa-money ">Ver cuenta</span>', array('controller'=>'facturas','action' => 'listaporclientes', $user['User']['id']),array('escape'=>false)); ?>
						</td>
						
					</tr>
					<?php endforeach; ?>
				</table>

				
			</div>