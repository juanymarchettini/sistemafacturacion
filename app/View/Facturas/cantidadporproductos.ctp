<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Productos Vendidos','shorturl'=>'Lista de Productos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Resumen</h2>
		<?php
		    echo $this->Form->create('Factura', array(
		    'inputDefaults' => array(
		        'div' => 'form-group',
		        'wrapInput' => false,
		        'class' => 'form-control'
		    ),
		    'class' => false
		));
		?>
		<div class="col-sm-6">
		<?php
		    echo $this->Form->input('desde',array('label'=>false,'type'=>'date','dateFormat'=>'DMY','class'=>'col-sm-4' ,'between' => false,'separator' => false,'after' => false ,'monthNames' => false, 'maxYear' => date('Y')+1,'minYear' => date('Y')-2));
		?>
		</div>
		<div class="col-sm-6">
		<?php
		    echo $this->Form->input('hasta',array('label'=>false, 'type'=>'date','dateFormat'=>'DMY', 'class'=>'col-sm-4','between' => false,'separator' => false,'after' => false, 'monthNames'=> false, 'maxYear' => date('Y')+1,'minYear' => date('Y')-2));
		?>
		</div>
		<?php
		    echo $this->Form->submit(__('Buscar'), array('class' => 'btn btn-primary'));
            echo $this->Form->end();
                  

		?>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover ">
					<tr>
							<th>Nombre del Producto</th>
							<th>Cantidad de Ventas</th>
							
					</tr>
					<?php foreach ($suma as $producto):
							
					?>
								<td><?php echo h($producto['Detalle']['nombre']); ?>&nbsp;</td>
								<td><?php echo h($producto['0']['total']); ?>&nbsp;</td>
							</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</section>
	</div>
	
</section>

<style type="text/css">
.cancelada{
	background-color:red;
	color: #fff;
}
.entregado{
	background-color: #36B500;
}
.entregado td{
	color: #fff;
}
.entregado b{
	color:#000;
}
.actions{
	text-align: center;
}
</style>