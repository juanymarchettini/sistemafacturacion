<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Dashboard','shorturl'=>'Inicio')); ?>

<?php //echo $this->Element('backend/dashboardgraph'); ?>
<div class="col-md-6">
	
	<section class="panel panel-featured-left panel-featured-primary">
		<div class="panel-body">
			<div class="widget-summary">
				<div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-primary">
						<i class="fa fa-shopping-cart"></i>
					</div>
				</div>
				<div class="widget-summary-col">
					<div class="summary">
						<h4 class="title">Pedidos Por Armar</h4>
						<div class="info">
							<strong class="amount"><?php echo $facturas; ?></strong>
							<span class="text-success">(Nuevos)</span>
							
						</div>
					</div>
					<div class="summary-footer">
						<?php echo $this->Html->link('(ver pedidos)',array('controller'=>'Facturas', 'action'=>'listapendientes',0), array('class'=>"text-muted text-uppercase")); ?>
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-md-6">
	<section class="panel">
		<div class="panel-body bg-success">
			<div class="widget-summary">
				<div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon">
						<?php echo $this->Html->link('<i class="fa fa-download"></i>',array('controller'=>'Informes', 'action'=>'generarplanillaprecios'), array('class'=>"text-uppercase",'escape'=>false)); ?>

					</div>
				</div>
				<div class="widget-summary-col">
					<div class="summary">
						<h4 class="title">Descargar Lista de Precios</h4>
						<div class="info">
							<strong class="amount">Lista de Precios</strong>
						</div>
					</div>
					<div class="summary-footer">
						<?php echo $this->Html->link('(Descargar)',array('controller'=>'Informes', 'action'=>'generarplanillaprecios'), array('class'=>"text-uppercase")); ?>
						
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-md-6">
	<section class="panel panel-featured-left panel-featured-tertiary">
		<div class="panel-body">
			<div class="widget-summary">
				<div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-tertiary">
						<i class="fa fa-user"></i>
					</div>
				</div>
				<div class="widget-summary-col">
					<div class="summary">
						<h4 class="title">Clientes</h4>
						<div class="info">
							<strong class="amount"><?php  echo $clientes; ?></strong>
						</div>
					</div>
					<div class="summary-footer">
						<?php echo $this->Html->link('(ver todos)',array('controller'=>'Users', 'action'=>'lista'), array('class'=>"text-muted text-uppercase")); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="col-md-6">
	<section class="panel panel-featured-left panel-featured-quartenary">
		<div class="panel-body">
			<div class="widget-summary">
				<div class="widget-summary-col widget-summary-col-icon">
					<div class="summary-icon bg-quartenary">
						<i class="fa fa-user"></i>
					</div>
				</div>
				<div class="widget-summary-col">
					<div class="summary">
						<h4 class="title">Productos</h4>
						<div class="info">
							<strong class="amount">
								<?php echo $this->Html->link($productos,array('controller'=>'Productos', 'action'=>'lista'), array('class'=>"text-muted text-uppercase")); ?>
						    </strong>
						</div>
					</div>
					<div class="summary-footer">
						<?php echo $this->Html->link('(ver todos)',array('controller'=>'Productos', 'action'=>'lista'), array('class'=>"text-muted text-uppercase")); ?>
					</div>
				</div>
			</div>
		</div>
	</section>

</div>



<style type="text/css">
a, .btn-link {
    color: #fff;
}
</style>
