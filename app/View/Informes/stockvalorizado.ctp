<?php
	echo $this->Html->css(array('vendor/select2/select2','vendor/select2/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));

?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Productos Vendidos','shorturl'=>'Lista de Productos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
			<div class="col-sm-12" style="margin-bottom:20px;">
				<h2 class="panel-title">Ventas Por Categoria</h2>
				<?php
				    echo $this->Form->create('Categoria', array(
				    'inputDefaults' => array(
				        'div' => 'form-group',
				        'wrapInput' => false,
				        'class' => 'form-control'
				    ),
				    'class' => false
				));
				?>
			</div>
			<div class="col-sm-6">
				<div class="form-group" id="categorias-select">
					<label class="col-md-12 panel-title" style="margin-bottom: 15px;">Seleccione Categorías</label>
					<div class="col-md-12" style="padding-left:0;">
						<select class="form-control" name="data[Categoria][categoriaid][]" multiple="multiple[]" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "includeSelectAllOption": true }' id="ms_example5">
						    <?php foreach ($listacategoriaspadre as $key => $categoria) {
										echo '<option value="'.$key.'" selected>'.$categoria.'</option>';
							} ?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group" id="categorias-select">
					<label class="col-md-12 panel-title" style="margin-bottom: 15px;">Visualizar Producos</label>
					<div class="col-md-12" style="padding-left:0;">
						<div class="checkbox-custom checkbox-primary">
							<input type="checkbox" name='data[Categoria][showproductos]'value="1" checked="" id="checkboxExample2">
							<label for="checkboxExample2">Ver Productos</label>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12" style="clear: both; margin-top:20px; margin-bottom:20px;">
				<?php
			    	echo $this->Form->submit(__('Buscar'), array('class' => 'btn btn-primary'));
	            	echo $this->Form->end();
	 			?>
			</div>
	
			<div style="clear:both;"> </div>
	</header>
	<div class="panel-body">
		<section class="col-md-12">
			<legend> Resumen </legend>
			<section  class="col-md-12">
				<div class="table-responsive">
					<table class="table" style="font-size:15px;">
						<tr>
						  <td style="color:green;">Valor del Stock</td>
						  <td style="color:green;">$<span id="tablavalorstock"></span></td>
						</tr>
					</table>
				</div>
			</section>
		</section>
		<section  class="col-md-12">
			<div class="table-responsive">
					<?php 
					$idcategoria=0;
					$sumatotal=0;
					$sumavalorizacion=0;
					$sumastock=0;
					$sumaprecio=0;
					
					$idtotales=[];
					$idvalorizado=[];
					$idprecio=[];
					$idstock=[];
					
					$subcategoriaid=-1;
					$categoriapadre=-1;
					foreach ($productos as $producto){
						
						if ($producto['Producto']['categoria_id'] != $idcategoria){ 

							if ($idcategoria != 0){ 
								echo '</table>';
								$idtotales[$idcategoria]=$sumatotal;
								$idvalorizado[$idcategoria]=$sumavalorizacion;
								$idstock[$idcategoria]=$sumastock;
								$idprecio[$idcategoria]=$sumaprecio;
								
								if ($listahijospadre[$idcategoria] == 0){
									
									if(isset($listadodecostosporcategoria[$idcategoria])){
									$listadodecostosporcategoria[$idcategoria]['stock']=$sumastock;
									$listadodecostosporcategoria[$idcategoria]['preciocompra']=$sumaprecio;
									$listadodecostosporcategoria[$idcategoria]['valorizacioncat']=$sumavalorizacion;
									$listadodecostosporcategoria[$idcategoria]['total']=$sumatotal;
									}
								
								}else{
									
									$padreid=$listahijospadre[$idcategoria];
									$listadodecostosporcategoria[$padreid][$idcategoria]['preciocompra']=$sumaprecio;
									$listadodecostosporcategoria[$padreid][$idcategoria]['stock']+=$sumastock;
									$listadodecostosporcategoria[$padreid][$idcategoria]['valorizacioncat']=$sumavalorizacion;
									$listadodecostosporcategoria[$padreid][$idcategoria]['total']+=$sumatotal;
								}
								
								$sumavalorizacion = 0;
								$sumaprecio = 0;
								$sumastock =0 ;
							}	
							
							
							if (($categoriapadre != $listahijospadre[$producto['Producto']['categoria_id']])){
								
								if ($listahijospadre[$producto['Producto']['categoria_id']] == 0){
									echo '<h1>'.$listacategorias[$producto['Producto']['categoria_id']].'</h1><span  style=" font-size: 18px; font-weight: bold; color: #5bc0de;" id="total'.$producto['Producto']['categoria_id'].'"></span>';
	
								}else{
									$categoriapadre = $listahijospadre[$producto['Producto']['categoria_id']];
									echo '<h1>'.$listacategorias[$categoriapadre].'</h1><span style=" font-size: 18px; font-weight: bold; color: #5bc0de;" id="total'.$categoriapadre.'"></span>';
									
								}
							}

							?>		
							<h4> <?php  echo $listacategorias[$producto['Producto']['categoria_id']].'<span style="font-size:12px;" id="subtotal'.$producto['Producto']['categoria_id'].'"></span><h3>'; 
							?></h4>

							<table class="table table-hover ">
								<?php if ($showproductos){ ?>
									<tr><th>Nombre del Producto</th><th>Categoria</th><th>Stock</th><th>Por Armar</th><th>Stock Real</th><th>Precio</th><th>Valor</th></tr>
								<?php } ?>

			<?php				$idcategoria = $producto['Producto']['categoria_id'];
						}

						//Asigno todas las variables antes de imprimir por si selecciona la opcion no visualizar productos desde los filtros
						
						$sumaprecio=(float) $producto['Producto']['preciocompra'];
						$sumastock=$sumastock+$producto['Producto']['stock'];

						$stock= (float) $producto['Producto']['stock'];
						
						if (isset($listapendientesdearmar[$producto['Producto']['id']])){
							$porarmar= $listapendientesdearmar[$producto['Producto']['id']];
						}else{
							$porarmar=0;
						}
					    $preciocompra = (float) $producto['Producto']['preciocompra'];
					    $sumatotal=$sumatotal+$stock * $preciocompra;
						$sumavalorizacion = $sumavalorizacion+($stock*$preciocompra);


						if ($showproductos){
			?>				

							<tr>
								<td><?php echo h($producto['Producto']['nombre']); ?>&nbsp;</td>
								<td><?php 
								if (isset($listacategorias[$producto['Producto']['categoria_id']])){ echo  $listacategorias[$producto['Producto']['categoria_id']];
								} ?>&nbsp;</td>
								<td><?php echo h($producto['Producto']['stock']);  ?>&nbsp;</td>
								<td><?php echo $porarmar;  ?>&nbsp;</td>
								<td><?php echo $porarmar+$stock;  ?>&nbsp;</td>
								<td><?php echo h($producto['Producto']['preciocompra']); ; ?>&nbsp;</td>
								
								<td>$<?php 
									echo $stock * $preciocompra;
								?>&nbsp;</td>

							</tr>

				<?php 
					
						} ///FIN DEL IF SHOWPRODUCTOS
				?>

			  <?php }

					if ($idcategoria != 0){ 
						$idtotales[$idcategoria]=$sumatotal;
						$idvalorizado[$idcategoria]=$sumavalorizacion;
						$idstock[$idcategoria]=$sumastock;
						$idprecio[$idcategoria]=$sumaprecio;
						if ($listahijospadre[$idcategoria] == 0){
							$listadodecostosporcategoria[$idcategoria]['stock']+=$sumastock;
							$listadodecostosporcategoria[$idcategoria]['preciocompra']=$sumaprecio;
							$listadodecostosporcategoria[$idcategoria]['valorizacioncat']=$sumavalorizacion;
						
						}else{

							$padreid=$listahijospadre[$idcategoria];
							$listadodecostosporcategoria[$padreid][$idcategoria]['preciocompra']=$sumaprecio;
							$listadodecostosporcategoria[$padreid][$idcategoria]['stock']+=$sumastock;
							$listadodecostosporcategoria[$padreid][$idcategoria]['valorizacioncat']=$sumavalorizacion;
						}
						
						$sumavalorizacion = 0;
						$sumaprecio = 0;
						$sumastock =0 ;

					}
					
				?>
							</table>
					
			</div>
			
		</section>
	</div>
	
</section>
<?php
echo $this->Html->script(array('vendor/select2/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect' ));
?>

<script type="text/javascript">
var js_array =<?php echo json_encode($idtotales);?>;
var js_valorizado =<?php echo json_encode($idvalorizado);?>;
var js_precio =<?php echo json_encode($idprecio );?>;
var js_stock =<?php echo json_encode($idstock );?>;
var js_listapadrehijoinfo = <?php echo json_encode($listadodecostosporcategoria); ?>


console.log(js_listapadrehijoinfo);

function llenartotales(){


	$.each(js_array, function(i, item) {
    	
    		
    	item = js_precio[i];
    	textoprecio=' - Precio de Compra $: '+item;
  	
    	item = js_stock[i];
    	textocosto=' - Stock : '+item;
  	
    	item = js_valorizado[i];
    	textoganancia=' - Valor $: '+item;

    	$("#subtotal"+i).html(textocosto+' '+textoprecio+' '+textoganancia);
    	
	});

	
}

function infocategoriapadre(){
	var valorizacioncat=0;
	var precioventa=0;
	var totalstock=0;
	var sumatotal=0
    //console.log(js_listapadrehijoinfo);
	$.each(js_listapadrehijoinfo, function(i, item){
		if (i != 0){
			if (typeof item.stock !== 'undefined') {
	  			
	  			texto=' Cant Stock: '+item.stock;
		    	textoprecio=' - Precio Compra $: '+item.preciocompra; 	
		    	textocosto=' - Valor $: '+item.valorizacioncat;	    	
		    	totalstock=totalstock+item.stock;
		    	precioventa=item.preciocompra;
		    	valorizacioncat=valorizacioncat+item.valorizacioncat;
		    	sumatotal=sumatotal+item.valorizacioncat;
		    	$("#total"+i).html(texto+' '+textocosto);

			}else{
				
				subprecio=0;
				substock=0;
				subvalorizacioncat=0;
				$.each(item, function(x, subitem) {

					if (typeof subitem.stock !== 'undefined') {
			  			///FALTA AGREGAR VARIABLES QUE SUMEN LOS SUBTOTALES	  			
				    	substock= substock + subitem.stock;		    	
				    	subprecio=subitem.preciocompra;
				    	subvalorizacioncat= subvalorizacioncat+subitem.valorizacioncat;
				    	sumatotal=sumatotal+subitem.valorizacioncat;			    	
					}
				});

				
				texto=' Cant Stock: '+substock;
				textoprecio=' - Precio Compra $: '+subprecio;
				textovalor=' - Valor $: '+subvalorizacioncat;			
				
				$("#total"+i).html(texto+' '+textovalor);
			}	
		}
	});
	
	$('#tablavalorstock').html(Math.round(sumatotal * 100) / 100);
	/*
	$('#tablacosto').html(Math.round(totalcosto * 100) / 100);
	$('#tablafacturado').html(Math.round(totalfacturado * 100) / 100);
	*/
}
llenartotales();
infocategoriapadre();
</script>