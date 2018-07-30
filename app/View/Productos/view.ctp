\<section><!--slider-->
	<div class="container">
			<div class="row">
				<div class=" col-sm-12 breadcrumbs">
					<ol class="breadcrumb">
					  <li><?php echo $this->Html->link('Inicio', array('controller'=>'Categorias', 'action'=>'home')); ?></li>
					    <?php 
					  	   if ($producto['Categoria']['subcategoria_id'] == 0){
					    ?>
					  		<li class="active">
					  			<?php echo $producto['Categoria']['nombre']; ?>
					  		</li>
					  <?php }else
					  		{  
					  	 		    foreach ($categorias as $categoria) { ?>
								  	   
								  	       <?php echo ($categoria['Categoria']['id']== $producto['Categoria']['subcategoria_id'] ) ? '<li>'.$this->Html->link($categoria['Categoria']['nombre'] , array('controller'=>'Categorias', 'action'=>'seccion/'.$categoria['Categoria']['id'])).'</li>': false ?>
								  	    
					  				<?php } //Fin foreach ?>

							        <li class="active">
							        	<?php echo $producto['Categoria']['nombre']; ?>
							        </li>
					   <?php
							}
						?>
					  
					</ol>
				</div><!--/breadcrums-->
				<div class="col-sm-3">
					<?php echo $this->element('leftbar'); ?>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<?php echo (!empty($producto['Producto']['imagen1'])) ? $this->Html->image('productos/'.$producto['Producto']['imagen1'], array('alt'=>'', 'class'=>'jq_imgproducto1')) :  $this->Html->image('base/imgnodisponible.png' , array('alt'=>''));  ?>
								
								<?php 

									if(!empty($producto['Producto']['imagen2'])) { echo $this->Html->image('productos/'.$producto['Producto']['imagen2'], array('alt'=>'', 'class'=>'jq_imgproducto2', 'style'=>'display:none'));}

									if(!empty($producto['Producto']['imagen3'])) { echo $this->Html->image('productos/'.$producto['Producto']['imagen3'], array('alt'=>'', 'class'=>'jq_imgproducto3', 'style'=>'display:none'));}

									if(!empty($producto['Producto']['imagen4'])) { echo $this->Html->image('productos/'.$producto['Producto']['imagen4'], array('alt'=>'', 'class'=>'jq_imgproducto4', 'style'=>'display:none'));}

								?>

								
								
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">
										  <a href="#"><?php echo (!empty($producto['Producto']['imagen1'])) ? $this->Html->image('productos/'.$producto['Producto']['imagen1'], array('style'=>'max-height:83px;','attrimg'=>'jq_imgproducto1' )) :  $this->Html->image('base/imgnodisponible.png' , array('style'=>'height:83px;', 'attrimg'=>'jq_imgproducto1' ));  ?></a>
										   
										  <a href="#"><?php echo (!empty($producto['Producto']['imagen2'])) ? $this->Html->image('productos/'.$producto['Producto']['imagen2'], array('style'=>'height:83px;', 'attrimg'=>'jq_imgproducto2')) : false ; ?></a>

										   <a href="#"><?php echo (!empty($producto['Producto']['imagen3'])) ? $this->Html->image('productos/'.$producto['Producto']['imagen3'], array('style'=>'height:83px;', 'attrimg'=>'jq_imgproducto3')) : false ; ?></a>
										</div>
										<?php if (!empty($producto['Producto']['imagen4'])) { ?>
											<div class="item active">
													<a href="#">
														<?php  $this->Html->image('productos/'.$producto['Producto']['imagen4'], array('style'=>'height:83px;', 'attrimg'=>'jq_imgproducto4')); ?>
													</a>
											</div>
										<?php
											}
										?>
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information
								<img src="images/product-details/new.jpg" class="newarrival" alt="" /> -->
								<h2><?php echo $producto['Producto']['nombre']; ?></h2>
								<p>Web ID: <?php echo $producto['Producto']['codigo']; ?></p>
								<label>Precio Por unidad:</label>
								<span class="col-xs-12">
									<?php  $result = Hash::sort($producto['Categoria']['Preciosproducto'], '{n}.hasta', 'asc'); ?>
									<?php $user =$this->Session->read('Auth.User');  if (!empty($user)){ ?>			
									<span><?php echo (isset($result[0]['precio']))? '$ '.$result[0]['precio'].'.-' : 'Consultenos'; ?></span>
									<?php } /*
									<label>Cantidad:</label>
									<input type="text" value="1" id="cantidad_nro"/>
									<button type="button" class="btn btn-fefault cart jq_sumar_item_carro" item-id=<?php echo $producto['Producto']['id']; ?> >
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
									*/?>
								</span>
								<div id="jq_addok">
									<h6> Se Agrego Correctamente a su Carrito </h6>
								</div>
								<div id="jq_adderror">
									<h6> Error Producto Inexistente o Fuera de Stock </h6>
								</div>
								<p><b>Precios Por Cantidad:</b> Vea el Cuadro que se encuentra en la parte inferior</p>
								<p><b>Status:</b> <?php echo ($producto['Producto']['disponible'])? '<span style="color: green;"> Producto Disponible </span>' : '<span style="color: red;"> Producto No Disponible </span>' ; ?></p>
								<p><b>Stock:</b> <?php echo $producto['Producto']['stock']; ?></p>
								<p><b>Categoria:</b> <?php echo $producto['Categoria']['nombre']; ?></p>
								
								<div
								  class="fb-like"				
								  data-width="450"
								  data-show-faces="true">
								</div>
								<div class="fb-share-button" data-href= <?php echo $this->Html->url(array("controller" => "productos", "action" =>"view/".$producto['Producto']['id'] ));?> data-layout="button_count"></div>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#precios" data-toggle="tab">Precios X Cantidad</a></li>
								<li ><a href="#details" data-toggle="tab">Detalles</a></li>
								<li><a href="#reviews" data-toggle="tab">Consultenos</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade active in" id="precios" >
								<div class="col-sm-12" style="margin-left:5px;">
									<div class="table-responsive">
										<label><?php echo 'Promoción x Cantidad Válida para la Sección: '.$producto['Categoria']['nombre']; ?></label>
										<?php  
											    if (!empty($user)){ 
										?>
										<table class="table table-striped">
											<tr>
												<th>
													 Cantidad
												</th>
												<th>
													Precio
												</th>
					
											</tr>

											<?php
											   
													foreach ($result as $value) :
													
														echo '<tr>';
															echo '<td>';
																echo $value['descripcion'];
															echo '</td>';
															echo '<td>';
																echo '$ '.$value['precio'].'.-';
															echo '</td>';
														echo '</tr>';


													endforeach;
												
											?>
										</table>
										<?php }else{
											echo "<p><b>CONSULTENOS</b></p>";
										} ?>
									</div>
								</div>
								<div style="clear:both;"></div>
							</div>
							<div class="tab-pane fade" id="details" >
								<div class="col-sm-12" style="margin-left:5px;">
									
									<p><?php echo $producto['Producto']['descripcion']; ?></p>
								</div>
								<div style="clear:both;"></div>
							</div>
						
							<div class="tab-pane fade " id="reviews" >

								<?php echo $this->element('contactproductos'); ?>
							</div>
							
						</div>
					</div><!--/category-tab-->

				</div>
			</div>
		</div>
</section>
<style type="text/css">
#jq_addok{
	display: none;
	padding: 10px;
	text-align: center;
	background: #00BC12;
	color: white;
	margin-bottom: 10px;
}

#jq_adderror{
	display: none;
	padding: 10px;
	text-align: center;
	background: #FF5E5E;
	color: white;
	margin-bottom: 10px;
}
</style>
<script type="text/javascript">
$('.item img').click(function(event){
	event.preventDefault();
	console.log($(this).attr('attrimg'));
	$('.view-product img').hide();
	var imgactual = $(this).attr('attrimg');
	$('.'+imgactual).show();

});



</script>