<div class="panel-body">
			<section  class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">

						<tr>

							<th><?php echo 'Nro.'; ?></th>
							<th><?php echo 'Título'; ?></th>
							<th><?php echo 'Subcategoria de'; ?></th>
							<th class="actions" tyle="text-align:center;"><?php echo __('Editar'); ?></th>
							<th class="actions" tyle="text-align:center;"><?php echo __('Eliminar'); ?></th>
								
						</tr> 
						<?php foreach ($categorias as $capacitacione):?>
								<tr>
									<td><?php echo h($capacitacione['Categoria']['id']); ?>&nbsp;</td>
									<td><?php echo h($capacitacione['Categoria']['nombre']); ?>&nbsp;</td>
									<td><?php echo ($capacitacione['Categoria']['subcategoria_id'] != 0)? $subcategoria[$capacitacione['Categoria']['subcategoria_id']] : '---'; ?>&nbsp;</td>
									<td class="actions">
										<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $capacitacione['Categoria']['id']),array('escape'=>false)); ?>
									</td>
									<td class="actions">
										<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $capacitacione['Categoria']['id']), array('escape'=>false), __('¿Estás seguro que deseas eliminar %s?', $capacitacione['Categoria']['nombre'])); ?>
									</td>
								</tr>
						<?php endforeach; ?>
					</table>
						
				</div>
			</section>

			
		</div>