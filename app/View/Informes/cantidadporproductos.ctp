<?php
	echo $this->Html->css(array('vendor/select2/css/select2','vendor/select2-bootstrap-theme/select2-bootstrap','vendor/bootstrap-multiselect/bootstrap-multiselect'));
?>
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Productos Vendidos','shorturl'=>'Lista de Productos')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Ventas Por Categoria</h2>
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
		<div class="col-sm-12">
			<label class="col-md-12 panel-title" style="margin-bottom: 15px; margin-top:15px;">Rango De Fechas</label>
		</div>
		
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
		<div class="col-sm-6">
			<div class="form-group" id="categorias-select">
				<label class="col-md-12 panel-title" style="margin-bottom: 15px;">Seleccione Categorías</label>
				<div class="col-md-12" style="padding-left:0;">
					<select class="form-control" name="data[Factura][categoriaid][]" multiple="multiple[]" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200, "includeSelectAllOption": true }' id="ms_example5">
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
						<input type="checkbox" name='data[Factura][showproductos]'value="1" checked="" id="checkboxExample2">
						<label for="checkboxExample2">Ver Productos</label>
					</div>
				</div>
			</div>
		</div>
		
		<div style="clear: both;">
		<?php
		    echo $this->Form->submit(__('Buscar'), array('class' => 'btn btn-primary'));
            echo $this->Form->end();
                  

		?>
		</div>
	</header>
	<div class="panel-body">
		<section class="col-md-12">
			
				<legend> Resumen </legend>
					<section  class="col-md-12">
							<div class="table-responsive">
								<table class="table" style="font-size:15px;">
									<tr>										
											<th><?php echo ''; ?></th>							
											<th><?php echo 'Monto $'; ?></th>					
									</tr>
											<tr>
												<td>Facturado</td>
												<td >$<span id="tablafacturado"></span></td>	
											</tr>
											<tr>
												<td>Costo</td>
												<td>$<span id="tablacosto"></span></td>
											</tr>
											<tr>
												
												<td style="color:green;">Ganancia</td>
												
												<td style="color:green;">$<span id="tablaganancia"></span></td>
												
												
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
					$sumaganancia=0;
					$sumacosto=0;
					$sumaprecio=0;
					$idtotales=[];
					$idganancia=[];
					$idprecio=[];
					$idcosto=[];
					$subcategoriaid=-1;
					$categoriapadre=-1;
					foreach ($suma as $producto){
						
						
							if ($producto['Producto']['categoria_id'] != $idcategoria){ 

								if ($idcategoria != 0){ 
									echo '</table>';
									$idtotales[$idcategoria]=$sumatotal;
									$idganancia[$idcategoria]=$sumaganancia;
									$idcosto[$idcategoria]=$sumacosto;
									$idprecio[$idcategoria]=$sumaprecio;
									
									if ($listahijospadre[$idcategoria] == 0){
										
										if(isset($listadodecostosporcategoria[$idcategoria])){
										$listadodecostosporcategoria[$idcategoria]['costo']=$sumacosto;
										$listadodecostosporcategoria[$idcategoria]['venta']=$sumaprecio;
										$listadodecostosporcategoria[$idcategoria]['ganancia']=$sumaprecio - $sumacosto;
										$listadodecostosporcategoria[$idcategoria]['cantvendida']=$sumatotal;
										}
									
									}else{
										
										$padreid=$listahijospadre[$idcategoria];
										$listadodecostosporcategoria[$padreid][$idcategoria]['venta']+=$sumaprecio;
										$listadodecostosporcategoria[$padreid][$idcategoria]['costo']+=$sumacosto;
										$listadodecostosporcategoria[$padreid][$idcategoria]['ganancia']+=$sumaprecio-$sumacosto;
										$listadodecostosporcategoria[$padreid][$idcategoria]['cantvendida']+=$sumatotal;
									}
									

									$sumatotal=0;
									$sumaganancia = 0;
									$sumaprecio = 0;
									$sumacosto =0 ;
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
										<tr><th>Nombre del Producto</th><th>Categoria</th><th>Cant</th><th>Venta</th><th>Costo</th><th>Ganancia</th><th>Stock</th></tr>
									<?php } ?>

				<?php				$idcategoria = $producto['Producto']['categoria_id'];
							}

							//Asigno todas las variables antes de imprimir por si selecciona la opcion no visualizar productos desde los filtros
							$sumatotal=$sumatotal+$producto['0']['total'];
							$sumaprecio=$sumaprecio+$producto['0']['precio'];
							$sumacosto=$sumacosto+$producto['0']['costo'];
							$costo = (float) $producto['0']['costo'];
						    $venta = (float) $producto['0']['precio'];
							$sumaganancia = $sumaganancia + ($venta - $costo);


							if ($showproductos){
				?>				

								<tr>
									<td><?php echo h($producto['Producto']['nombre']); ?>&nbsp;</td>
									<td><?php 
									if (isset($listacategorias[$producto['Producto']['categoria_id']])){ echo  $listacategorias[$producto['Producto']['categoria_id']];
									} ?>&nbsp;</td>
									
									
									<td><?php echo h($producto['0']['total']);  ?>&nbsp;</td>
									<td><?php echo h($producto['0']['precio']); ; ?>&nbsp;</td>
									<td><?php echo h($producto['0']['costo']);  ?>&nbsp;</td>
									<td>$<?php 
										/*
									    if ($producto['Detallejoin']['costo'] == 0){
										    $costo=(float)$producto['Producto']['preciocompra']*$producto['0']['total']; 
									    }else{
									    	$costo=(float)$producto['Detallejoin']['costo']*$producto['0']['total']; 
									    }
									    $venta=(float)$producto['Detallejoin']['precio']*$producto['0']['total'];
									    */

									    
										echo $venta - $costo;
									?>&nbsp;</td>
									<td><?php echo h($producto['Producto']['stock']);  ?>&nbsp;</td>
								</tr>

					<?php 
						
							} ///FIN DEL IF SHOWPRODUCTOS
					?>

			  <?php }
					if ($idcategoria != 0){ 
						$idtotales[$idcategoria]=$sumatotal;
						$idganancia[$idcategoria]=$sumaganancia;
						$idcosto[$idcategoria]=$sumacosto;
						$idprecio[$idcategoria]=$sumaprecio;
						if ($listahijospadre[$idcategoria] == 0){
							$listadodecostosporcategoria[$idcategoria]['costo']+=$sumacosto;
							$listadodecostosporcategoria[$idcategoria]['venta']+=$sumaprecio;
							$listadodecostosporcategoria[$idcategoria]['cantvendida']+=$sumatotal;
						
						}else{
							$padreid=$listahijospadre[$idcategoria];
							$listadodecostosporcategoria[$padreid][$idcategoria]['venta']+=$sumaprecio;
							$listadodecostosporcategoria[$padreid][$idcategoria]['costo']+=$sumacosto;
							$listadodecostosporcategoria[$padreid][$idcategoria]['cantvendida']+=$sumatotal;
						}
						$sumatotal=0;
						$sumaganancia = 0;
						$sumaprecio = 0;
						$sumacosto =0 ;

					}
					
				?>
							</table>
					
			</div>
			
		</section>
	</div>
	
</section>
<?php
echo $this->Html->script(array('vendor/select2/js/select2', 'vendor/bootstrap-multiselect/bootstrap-multiselect' ));
?>
<style type="text/css">
.table-responsive h1{font-size: 25px; font-weight: bold;}
.table-responsive h4{
	font-size: 16px;
}
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
h3 span{
    font-size: 19px;
    font-family: arial;
    color: #000;
}
#categorias-select{
	margin-top: 30px;
	margin-bottom: 30px;
}
.btn-group button{
	min-width: 270px;
}
</style>
<script type="text/javascript">
var js_array =<?php echo json_encode($idtotales);?>;
var js_ganancia =<?php echo json_encode($idganancia );?>;
var js_precio =<?php echo json_encode($idprecio );?>;
var js_costo =<?php echo json_encode($idcosto );?>;
var js_listapadrehijoinfo = <?php echo json_encode($listadodecostosporcategoria); ?>




function llenartotales(){


	$.each(js_array, function(i, item) {
    	texto=' - Cant Vendida: '+item;
    		
    	item = js_precio[i];
    	textoprecio=' - Venta $: '+item;
  	
    	item = js_costo[i];
    	textocosto=' - Costo $: '+item;
  	
    	item = js_ganancia[i];
    	textoganancia=' - Ganancia $: '+item;

    	$("#subtotal"+i).html(texto+' '+textocosto+' '+textoprecio+' '+textoganancia);
    	
	});

	
}

function infocategoriapadre(){
	var totalganancias=0;
	var totalfacturado=0;
	var totalcosto=0;
    //console.log(js_listapadrehijoinfo);
	$.each(js_listapadrehijoinfo, function(i, item) {
		if (typeof item.cantvendida !== 'undefined') {
  			
  			texto=' Cant Vendida: '+item.cantvendida;
	    	
	    	textoprecio=' - Venta $: '+item.venta;
	    	totalfacturado=totalfacturado+item.venta;
	    	textocosto=' - Costo $: '+item.costo;
	    	totalcosto=totalcosto+item.costo;
	    	
	    	itemganancia=item.venta-item.costo;
	    	textoganancia=' - Ganancia $: '+itemganancia;

	    	itemtotalganancia=item.venta-item.costo;
	    	totalganancias=totalganancias+itemtotalganancia;
	    	$("#total"+i).html(texto+' '+textocosto+' '+textoprecio+' '+textoganancia);
		}else{
			subcantvendida=0;
			subventa=0;
			subcosto=0;
			subganancia=0;

			$.each(item, function(x, subitem) {

				if (typeof subitem.cantvendida !== 'undefined') {
		  			///FALTA AGREGAR VARIABLES QUE SUMEN LOS SUBTOTALES	  			
			    	subcantvendida= subcantvendida + subitem.cantvendida;		    	
			    	totalfacturado=totalfacturado+subitem.venta;
			    	subventa= subventa+subitem.venta;			    	
			    	totalcosto=totalcosto+subitem.costo;
			    	subcosto=subcosto+subitem.costo;			    	
				}
			});
			subtotalganancia= subventa- subcosto;
			texto=' Cant Vendida: '+subcantvendida;
			textoprecio=' - Venta $: '+subventa;
			textocosto=' - Costo $: '+subcosto;
			textoganancia=' - Ganancia $: '+subtotalganancia;			
			totalganancias=totalganancias+subtotalganancia;
			$("#total"+i).html(texto+' '+textocosto+' '+textoprecio+' '+textoganancia);
		}	
	});

	$('#tablaganancia').html(Math.round(totalganancias * 100) / 100);
	$('#tablacosto').html(Math.round(totalcosto * 100) / 100);
	$('#tablafacturado').html(Math.round(totalfacturado * 100) / 100);

}
llenartotales();
infocategoriapadre();
</script>