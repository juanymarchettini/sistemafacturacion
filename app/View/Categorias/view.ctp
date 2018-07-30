<style type="text/css">
.breadcrumbs{
	position: relative;
	background-image: url(../../../../img/<?php echo $banner;	?>);
	background-repeat:no-repeat;
	background-size:cover;
	background-position:center;
	min-height:170px;
	text-align: center;
}
.breadcrumbs img{
	text-align: center;
	margin: 0 auto;
}
.breadcrumbs h3{
	font-size: 3.5em;
    font-weight: bold;
    color: #fff;
    position: absolute;
    top: 50%;
    left: 50%;
    height: 30%;
    width: 50%;
    margin: 2% 0 0 -25%;
}
</style>
	<div class="breadcrumbs" >
		<div class="container animated wow slideInUp" data-wow-delay=".5s" >
			<h3 class="animated wow zoomIn" data-wow-delay=".5s"><?php echo  $titulobanner; ?></h3>
		</div>
	</div>
	<div class="products">
		<div class="container">
			
			
			<div class="col-md-12 single-right" style="margin-top:45px;">
				<div class="col-xs-12 col-md-5  animated wow slideInUp" data-wow-delay=".5s">
					<div class="flexslider">
						<ul class="slides">
							<li data-thumb="productos/<?php echo $producto['Producto']['imagen1']; ?>">
								<div class="thumb-image">
									<img src="https://www.tiendaoverall.com.ar/img/productos/<?php echo $producto['Producto']['imagen1'];?>" class="img-responsive" data-imagezoom='true' >
									
								</div>
							</li>
							
							
						</ul>
					</div>
					<!-- flixslider -->
						<?php echo $this->Html->script(array('frontend/jquery.flexslider'));
						echo $this->Html->css(array('frontend/flexslider'));
						?>
						<script>
						// Can also be used with $(document).ready()
						$(window).load(function() {
						  $('.flexslider').flexslider({
							animation: "slide",
							controlNav: "thumbnails"
						  });
						});
						</script>
					<!-- flixslider -->
				</div>
				<div class="col-md-7 single-right-left simpleCart_shelfItem animated wow slideInRight" data-wow-delay=".5s">
					<h3><?php echo $producto['Producto']['nombre']; ?></h3>
					<h4><span class="item_price"><?php echo 'Consultar Precio'; ?></h4>
					<div class="rating1">
						<span class="starRating">
							<input id="rating5" type="radio" name="rating" value="5" checked>
							<label for="rating5">5</label>
							<input id="rating4" type="radio" name="rating" value="4">
							<label for="rating4">4</label>
							<input id="rating3" type="radio" name="rating" value="3" >
							<label for="rating3">3</label>
							<input id="rating2" type="radio" name="rating" value="2">
							<label for="rating2">2</label>
							<input id="rating1" type="radio" name="rating" value="1">
							<label for="rating1">1</label>
						</span>
					</div>
					<div class="description">
						<h5><i>Descripción</i></h5>
						<p><?php echo $producto['Producto']['descripcion']; ?></p>
					</div>
					
					
					
					
				</div>

				<div class="col-md-12" style="margin-top:25px;">
					<!-- collections -->
					<div class="new-collections">
						<div class="">
							<h3 class="animated wow zoomIn" data-wow-delay=".5s" style="font-size:2em;"><?php echo 'Más Productos';?></h3>
							
							<div class="new-collections-grids">
								<?php
									$i=0;
									foreach ($productosdestacados as $producto) {  $i++; 
								?>
									<div class="col-xs-12 col-md-3 new-collections-grid" style="margin-top:15px;">
										<div class="new-collections-grid1 animated wow slideInUp" data-wow-delay=".5s">
											<div class="new-collections-grid1-image">
												<img src="https://www.tiendaoverall.com.ar/img/productos/<?php echo $producto['Producto']['imagen1'];?>" class="img-responsive" style="max-height:245px;">
												
												
												<div class="new-collections-grid1-image-pos">
													<?php
														echo $this->Html->link('Ver Mas',array('controller'=>'Productos','action'=>'vista',$producto['Producto']['id']));
													?>
													
												</div>
												
											</div>
											<h4><?php
														echo $this->Html->link($producto['Producto']['nombre'],array('controller'=>'Categorias','action'=>'view',$producto['Producto']['id'],$nombreseccion,$categoriapadre));
													?></h4>
											
											<div class="new-collections-grid1-left simpleCart_shelfItem">
												<p>
												
												<?php
													echo $this->Html->link('Ver Mas',array('controller'=>'Categorias','action'=>'view',$producto['Producto']['id'],$nombreseccion,$categoriapadre),array('class'=>'item_add'));
												?>
												</p>
											</div>
										</div>
									</div>
							<?php   
									if ($i==4){
										echo '<div class="clearfix"> </div>';
										$i=0;
									}
									} ?>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				<!-- //collections -->

				</div>
				<div class="clearfix"> </div>
			
			</div>

			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //breadcrumbs -->
