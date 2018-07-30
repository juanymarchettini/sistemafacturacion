	<div class="panel-body">
			<section  class="col-md-12">
				<div class="table-responsive">
				<table class="table">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Cod.'); ?></th>
							<th><?php echo $this->Paginator->sort('codigo','Cod Prove.'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Nombre.'); ?></th>
							<th><?php echo $this->Paginator->sort('categoria_id','Cat.'); ?></th>
							<th><?php echo $this->Paginator->sort('stock','Stock'); ?></th>
							<th><?php echo $this->Paginator->sort('preciocompra','Costo'); ?></th>
							<th><?php echo $this->Paginator->sort('iva','iva'); ?></th>
							<th><?php echo $this->Paginator->sort('precio','$ sin/iva'); ?></th>
							<th><?php echo '$ c/Iva' ?></th>
							<th><?php echo $this->Paginator->sort('disponible','Dispo.'); ?></th>
							<th class="actions"><?php echo __('Editar'); ?></th>	
							<th class="actions"><?php echo __('Eliminar'); ?></th>
					</tr>
					
													
					<?php 

						foreach ($productos as $producto){
					?>
						<tr>
							<td>
								<?php echo $producto['Producto']['id']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['codigo']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['nombre']; ?>
							</td>
							<td>
								<?php echo $listacategorias[$producto['Producto']['categoria_id']]; ?>
							</td>
							<td>
								<b>
								<?php echo $producto['Producto']['stock']; ?>
								</b>
							</td>
							<td>$
								<?php echo $producto['Producto']['preciocompra']; ?>
							</td>
							<td>
								<?php echo $producto['Producto']['iva']; ?>
								%
							</td>
							<td>
								$
								<?php echo $producto['Producto']['precio']; ?>
							</td>
							<td><b>$
								<?php echo $producto['Producto']['preciobruto']; ?>
								</b>
							</td>
							<td>
								<?php echo $producto['Producto']['disponible']; ?>
							</td>
						</tr>
					<?php
						}
					?>
				</table>
				<div>			
			</section>

		</div>