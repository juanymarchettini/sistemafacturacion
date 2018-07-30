<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

	<div class="sidebar-header">
		<div class="sidebar-title">
			Menú
		</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					<li class="nav-active">
						<?php echo $this->Html->link('<i class="fa fa-home" aria-hidden="true"></i><span>Dashboard</span><span class="pull-right label label-warning"></span>', array('controller'=>'Facturas', 'action'=>'dashboard'), array('escape'=>false)); 
						?>
					</li> 
					
					<li class="nav-parent">
						<a>
							<i class="fa fa-money" aria-hidden="true"></i>
							<span>Caja</span>
						</a>
						<ul class="nav nav-children">
							<li>
								<?php echo $this->Html->link('Caja del Día', array('controller'=>'Pagos','action' => 'caja')); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('Caja Total', array('controller'=>'Pagos','action' => 'totalcaja')); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('Listar Movimientos', array('controller'=>'Pagos','action' => 'caja',date("d-m-Y"), date("d-m-Y") )); ?>		
							</li>
	
						</ul>
					</li>
					<li class="nav-parent">
						<a>
							<i class="glyphicon glyphicon-usd" aria-hidden="true"></i>
							
								<span>Pedidos</span>
							
							
						</a>
						<ul class="nav nav-children">
							<li>

									<?php echo $this->Html->link('> Nuevo Pedido', array('controller'=>'Facturas','action' => 'add'),array('escape'=>false)); ?>
							</li>
							
							<li>
									<?php echo $this->Html->link('Listar Pedidos <span class="pull-right label label-success">'.$nropedidospendientes.'</span>', array('controller'=>'Facturas','action' => 'listapendientes/0'),array('escape'=>false)); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('Facturas', array('controller'=>'Facturas','action' => 'listadefacturas')); ?>		
							</li>
							<li>
								<?php if ($nrocontrasinasignar>0){ ?>
								   <?php echo $this->Html->link('Facturas Contraree Sin Asignar<span class="pull-right label label-warning">'.$nrocontrasinasignar.'</span>', array('controller'=>'Facturas','action' => 'facturascontrareembolsosinasignar'),array('escape'=>false)); ?>	

								<?php 
								}else{
								?>
									<?php echo $this->Html->link('Facturas Contraree Sin Asignar', array('controller'=>'Facturas','action' => 'facturascontrareembolsosinasignar')); ?>	
								<?php
								}
								?>
									
							</li>
							<li>
								<?php echo $this->Html->link('Facturas Finalizadas', array('controller'=>'Facturas','action' => 'listadefacturasfinalizadas')); ?>		
							</li>

							
							
						</ul>
					</li>
					<li class="nav-parent">
						<a>
							<i class="glyphicon glyphicon-barcode" aria-hidden="true"></i>
							<span>Categorias</span>
						</a>
						<ul class="nav nav-children">
							<li>
									<?php echo $this->Html->link('Listar Categorias', array('controller'=>'categorias','action' => 'lista')); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('Nueva Categoria', array('controller'=>'categorias','action' => 'add')); ?>
									
							</li>
							
						</ul>
					</li>
					<li class="nav-parent">
						<a>
							<i class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></i>
							<span>Productos</span>
						</a>
						<ul class="nav nav-children">
							<li>
									<?php echo $this->Html->link('Listar Productos', array('controller'=>'productos','action' => 'lista')); ?>
								
							</li>
							<li>
								<?php echo $this->Html->link('Nuevo Producto', array('controller'=>'productos','action' => 'add')); ?>
									
							</li>
							
							
						</ul>
					</li>
					<li class="nav-parent">
						<a>
							<i class="fa fa-user" aria-hidden="true"></i>
							<span>Clientes</span>
						</a>
						<ul class="nav nav-children">
							
							<li>
								<?php echo $this->Html->link('Clientes ', array('controller'=>'users','action' => 'lista')); ?>
									
							</li>
							<li>
								<?php echo $this->Html->link('Nuevo Cliente', array('controller'=>'users','action' => 'add')); ?>
									
							</li>
							
						</ul>
					</li>
					<!-- BORRAR TODO DE INFORMES -->

					<li class="nav-parent">
						<a>
							<i class="glyphicon glyphicon-usd" aria-hidden="true"></i>
							<span>Gastos & Compra & Ingreso</span>
						</a>
						<ul class="nav nav-children">
							<!--
							<li class="nav-parent">
							<a> Sección Gastos </a>
								<ul class="nav nav-children" style="">
									<li>
											<?php echo $this->Html->link('Listar Gastos', array('controller'=>'Proveedorfacturas','action' => 'listafacturas/true')); ?>
										
									</li>
									<li>
										<?php echo $this->Html->link('Nuevo Gasto', array('controller'=>'Proveedorfacturas','action' => 'gastosadd')); ?>		
									</li>
								</ul>
							</li>
							<li class="nav-parent">
							<a> Ingreso de Efectivo </a>
								<ul class="nav nav-children" style="">
									<li>
											<?php echo $this->Html->link('Listar Ingresos', array('controller'=>'Facturas','action' => 'listadefacturasfinalizadas','Ingreso Dinero')); ?>
										
									</li>
									<li>
										<?php echo $this->Html->link('Nuevo Ingreso Efectivo', array('controller'=>'Facturas','action' => 'ingresoplata')); ?>		
									</li>
								</ul>
							</li>
							-->
							<li class="nav-parent">
							<a> Compra Proveedores </a>
								<ul class="nav nav-children" style="">
									<li>
											<?php echo $this->Html->link('Listar Facturas Compra', array('controller'=>'Proveedorfacturas','action' => 'listafacturas')); ?>
										
									</li>
									<li>
										<?php echo $this->Html->link('Nueva Compra', array('controller'=>'Proveedorfacturas','action' => 'add')); ?>		
									</li>
								</ul>
							</li>
							<li class="nav-parent">
							<a> Proveedores </a>
								<ul class="nav nav-children" style="">
									<li>
											<?php echo $this->Html->link('Listar Proveedores', array('controller'=>'Proveedores','action' => 'index')); ?>
										
									</li>
									<li>
										<?php echo $this->Html->link('Nuevo Proveedor', array('controller'=>'Proveedores','action' => 'add')); ?>		
									</li>
								</ul>
							</li>							
						</ul>

					</li>
					
					
					
					
					
					
					
					<li>
						<?php echo $this->Html->link('<i class="fa fa-external-link" aria-hidden="true"></i>
							<span>LogOut <em class="not-included"></em></span>',array('controller'=>'Users','action'=>'logout'),array('escape'=>false));
						?>
						</a>
					</li>
				
				</ul>
			</nav>

			<hr class="separator" />

			

			<hr class="separator" />

			<div class="sidebar-widget widget-stats">
				<div class="widget-header">
					<h6>Contacto Soporte</h6>
					
				</div>
				<div class="widget-content">
					<span>Soporte Tel: 0291-4737105 </span></br>
					<span>Soporte Email: juanmarchettini@gmail.com </span></br>
					
				</div>
				 <?php echo $this->Html->image('logo.png',array('height'=>'35px', 'alt'=>'Sistefact')); ?>
			</div>
		</div>

	</div>

</aside>
