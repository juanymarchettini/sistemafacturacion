
<section id="cart_items" style="margin-bottom:40px;">
	<?php echo $this->Form->create('Factura'); ?>
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><?php echo $this->Html->link('Inicio', array('controller'=>'Categorias', 'action'=>'home')); ?></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->
			<div class="review-payment">
				<h2>Lista de Productos & Envio</h2>
			</div>
			<ul class="nav nav-tabs" style="border-bottom: 1px solid;">
				<?php   $categoriaid='-1';
				    foreach ($categorias as  $item) { 
				    	$printhtml='';
				  		// Solo se realiza este control para ver si es el primero que debe estar activo
			  			($categoriaid == -1)? $printhtml='<li class="active">' :  $printhtml='<li>';
			  			echo $printhtml.'<a data-toggle="tab" href=#section'.$item['Categoria']['id'].'>'.$item['Categoria']['nombre'].'</a></li>';
				  		$categoriaid = $item['Categoria']['id'];
				  		
				  	}
				?>
			</ul>
			<div class="tab-content">
			    	
				<?php 
				  	$i=0;
				  	$totalfact=0;
				  	$categoriaid='-1';
				  	$conjuntocategorias=array();
			    ?>
			    <?php   
			    foreach ($categorias as  $catseccion) : 
		    	    $printhtml='';
		       
			  		if  ($catseccion['Categoria']['id'] != $categoriaid){ 
			  			($categoriaid == -1)? $printhtml='<div id="section'.$catseccion['Categoria']['id'].'" class="tab-pane fade in active">' :  $printhtml='</tbody>
						</table></div></div><div id="section'.$catseccion['Categoria']['id'].'" class="tab-pane fade">';
			  			echo '<tr><td colspan="3"></td><td colspan="2"><div  style="font-size: 14px; font-family: serif;"id="jq_resutadosubtotales'.$categoriaid.'"></div></td></tr>';
				  		echo $printhtml;
				  		$categoriaid = $catseccion['Categoria']['id'];
					?>
					    <div class="table-responsive cart_info">
						<table class="table table-condensed">
							<thead>
								<tr class="cart_menu">
									<td colspan="2" class="description">Producto</td>
									<td class="price">Precio x unidad</td>
									<td class="quantity">Cantidad</td>
									<td class="total">Sub-Total</td>
									
								</tr>
							</thead>
							<tbody>
							<?php
								if (!empty($catseccion['Categoria']['descripcion'])){
								 	echo '<tr><b style="font-size:22px; font-style:italic;">'.$catseccion['Categoria']['descripcion'].'</b></tr>'; 
								}
								
					}   ?>
					<?php 		
					//CREAR HELPER
								// Genero un array con  la cateogria , sus subcate y sus productos
								$categoriaysubcatgoria=array();
								$categoriaysubcatgoria[]=$catseccion['Categoria'];
								$categoriaysubcatgoria[0]['Producto']=$catseccion['Producto'];
								$categoriaysubcatgoria[0]['Preciosproducto']=$catseccion['Preciosproducto'];
								
								foreach ($catseccion['Subcategoria'] as $itemsubcategoria ) {
									$categoriaysubcatgoria[]= $itemsubcategoria;
								}
					/// FIN DE HELPERS			
								
								foreach ($categoriaysubcatgoria as  $subcategoria) :
									
									foreach ($subcategoria['Producto'] as  $item) : 

										$conjuntocategorias[]=$subcategoria['id'];
										if ( $item['disponible']  && $item['stock']>0){
									  	 ?>
										<tr subcategoria=<?php echo $subcategoria['id']; ?> id=<?php echo "'"."jq_nro_renglon_".$i." "."jq_cat_id_".$categoriaid."'";?> >
											<td colspan="2" class="cart_description">
												<?php
													 echo $this->Form->hidden('Detalle.'.$i.'.producto_id', array('value'=>$item['id'],'disabled'=>'disabled'));
													 echo $this->Form->hidden('Detalle.'.$i.'.nombre', array('value'=>$item['codigo'].'-'.$item['nombre'],'disabled'=>'disabled')); 
													 echo $this->Form->hidden('Detalle.'.$i.'.costo', array('value'=>$item['preciocompra'],'disabled'=>'disabled')); 
													 ?>
												<?php echo $this->Form->hidden('categoria_id', array('value'=>$item['categoria_id'],'disabled'=>'disabled')); ?>
												<h4><?php echo $item['nombre']; ?></h4>
												
											</td>

											<td class= <?php echo ' "cart_price jq_categoriaprecio_'.$categoriaid.' "'; ?> >
												<?php 
													if (isset($subcategoria['Preciosproducto'][0])){
														$result = Hash::sort($subcategoria['Preciosproducto'], '{n}.desde', 'asc');

														echo $this->Form->hidden('Detalle.'.$i.'.precio', array('class'=>'jq_inputprecio precio_'.$i,'idrenglon'=>$i, 'value'=>$result[0]['precio'],'disabled'=>'disabled'));
													}else{
														echo $this->Form->hidden('Detalle.'.$i.'.precio', array('class'=>'jq_inputprecio precio_'.$i,'idrenglon'=>$i, 'value'=>0,'disabled'=>'disabled'));
													}
												?>
												<p class="jq_labelprecio"> <?php echo (isset($result[0]['precio']))? '$ '.$result[0]['precio'].'.-' : 'Consultenos'; ?></p>
											</td>

											<td class=<?php echo ' "cart_quantity jq_inputcantidad_'.$categoriaid.'"'; ?> >
												<div class="cart_quantity_button">
													<a class="cart_quantity_down_12" href=""> -12 </a>
													
													<a class="cart_quantity_down" href=""> -</a>
													
													
													
													<?php echo $this->Form->input('Detalle.'.$i.'.cantidad', array( 'label'=>false, 'class'=>"cart_quantity_input", 'readonly' ,'idrenglon'=>$i,'idsubcategoria'=>$subcategoria['id'] ,'idcategoria'=>$categoriaid ,'type'=>"number",'div'=>false ,'autocomplete'=>"off", 'size'=>"2",'value'=>0,'disabled'=>'disabled', 'max'=>$item['stock']));?>
													
													<a class="cart_quantity_up" href=""> + </a>
													
													<a class="cart_quantity_up_12" href=""> +12</a>
												</div>
											</td>
											<td class=<?php echo ' "cart_total jq_inputtotal_'.$categoriaid.'"'; ?> >
												<?php echo $this->Form->hidden('totalinput', array('class'=>'jq_subtotal jq_totalinput_'.$i, 'id'=>'jq_totalinput_'.$i ,'value'=>0,'disabled'=>'disabled')); ?>
												<p class="cart_total_price" >$
													<span class=<?php echo 'total_'.$i; ?>>
														<?php 
															echo 0;
															$totalfact=$totalfact+0;
														?>
													</span>
												</p>
											</td>			
										</tr>
								 	<?php $i++; 
								 		}
									endforeach;
								endforeach;
							  	?>
							  <?php
							 	// esta linea se utiliza para cerrar cada tab
						    	echo '<tr><td colspan="3"></td><td colspan="2"><div  style="font-size: 14px; font-family: serif;"id="jq_resutadosubtotales'.$categoriaid.'"></div></td></tr>';  ?>
						    
				<?php  
				endforeach; 	 
								  ?>
							
				</tbody>
						</table></div></div>		
			</div>
			<div class="step-one">
				<h2 class="heading">Detalle de Compra</h2>
			</div>
			<table class="table table-condensed total-result">
				<tr>
					<td>Compra Sub Total</td>
					<td><span>$ </span><span class="jq_totalfact"> <?php  echo $totalfact; ?></span>.-</td>
				</tr>
			    <tr class="shipping-cost">
					<td>Gasto de Envio</td>
					<td>Consultar</td>										
				</tr>
				<tr>
					<td>Total</td>
					<?php echo $this->Form->hidden('total', array('value'=>$totalfact)); ?>
					<td><span>$ </span><span class="jq_totalfact"><?php  echo $totalfact; ?></span>.-</td>
				</tr>
			</table>

			<div class="step-one">
				<h2 class="heading">Datos Comprador</h2>
			</div>
			
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-6 clearfix">
						<div class="bill-to">
						
							<p>Comprado Por</p>
							<div class="form-one">

									<?php echo $this->Form->Hidden('user_id', array('type'=>'text','value'=>$userid,  'required')); ?>
									<?php echo $this->Form->input('nombre', array('label'=>false, 'div'=>false ,'placeholder'=>'Nombre *',  'value'=>$usuario['nombre'], 'required')); ?>
									<?php echo $this->Form->input('apellido', array('label'=>false, 'div'=>false, 'placeholder'=>'Apellido *', 'value'=>$usuario['apellido'],  'required')); ?>
									<?php echo $this->Form->input('email', array('label'=>false, 'div'=>false, 'placeholder'=>'Email *', 'value'=>$usuario['username'],  'required')); ?>
									
									
									
							</div>
							<div class="form-two">
									<?php echo $this->Form->input('tel', array('label'=>false, 'div'=>false, 'placeholder'=>'Teléfono *', 'value'=>$usuario['telefono'] ,'required')); ?>
									<?php echo $this->Form->input('localidad', array('label'=>false, 'div'=>false, 'placeholder'=>'Localidad *',  'value'=>$usuario['localidad'] , 'required')); ?>
									<?php echo $this->Form->input('direccion', array('label'=>false, 'div'=>false, 'placeholder'=>'Direccion *',  'value'=>$usuario['direccion'], 'required')); ?>
									<?php echo $this->Form->input('cp', array('label'=>false, 'div'=>false, 'placeholder'=>'Codigo Postal *', 'required')); ?>
									
							</div>
						</div>
					</div>
					<div class=" col-sm-6">
						<div class="order-message col-xs-12">
							<p>Nota Adjunta con Orden</p>
							<?php echo $this->Form->input('message', array('label'=>false, 'type'=>'textarea' ,'div'=>false, 'placeholder'=>'Ingrese algun comentario que sea necesario', 'row'=>'16')); ?>
						</div>	
					</div>					
				</div>
				
			</div>
			<div class="step-one">
				<h2 class="heading">Datos de Envio</h2>
			</div>
			
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-6 clearfix">
						<div class="bill-to">
							<div class="form-one">
									<?php echo $this->Form->input('tipodepago',array('label'=>'Pago','options'=>array('Contrareembolso'=>'Contrareembolso (Envio de Pedido 72Hs)', 'Deposito'=>'Deposito/Transferencia (Envio de Pedido 24Hs)','Efectivo'=>'Efectivo ( Retiro en Deposito - Envio de Pedido 48Hs)','TarjetadeCredito'=>'Tarjetad de Credito (Envio de Pedido 24Hs)'), 'empty'=>'Seleccione Forma','required'=>'required'));
									?>
									
									<span style="font-weight:bold">El Tiempo de Entrega es Aproximado.</span>
							</div>
							
						</div>
					</div>
					<div class="col-sm-6 clearfix">
						<div class="bill-to">
							<div class="form-one">
									
									<?php echo $this->Form->input('formadeenvio',array('label'=>'Forma de Envio','options'=>array('sugerido'=>'Transporte sugerido', 'retira'=>'Retira en Deposito', 'otros'=>'Otros transportes'),'empty'=>'Seleccione Forma', 'required'=>'required'));
									?>
								</br>
									<?php echo $this->Form->input('transporte',array('placeholder'=>'Nombre de Transporte','div'=>false));
									?>
									
							</div>
							
						</div>
					</div>
									
				</div>
				<div class="row">
					<div class="col-sm-12" id="comprasubmit">
						<?php echo $this->Form->submit('Confirmar Compra!!', array('class'=>'btn btn-fefault', 'id'=>'jq_submit')); ;?>
						
					</div>
					
				</div>
			</div>
			
		</div>
		</br>
		<?php echo $this->Form->end(); ?>
	</section> <!--/#cart_items-->

<style type="text/css">
	.cart_quantity a{
		text-decoration: none;
	}
	h5{padding-top: 0px; padding-bottom: 0px; margin-bottom: 0px; margin-top: 0px; padding-left: 25px;}
	.cart_info table tr td {
	    border-top: 0 none;
	    vertical-align: inherit;
	    margin: 0 auto;
	    padding: 0;
	}
	#cart_items .cart_info .table.table-condensed thead tr {
   		height: 25px;
	}
</style>

<script type="text/javascript">
var totalrenglones = <?php echo $i ?>;
var cantidadporcategorias = <?php  echo json_encode($cantidadporcategorias); ?>;
var conjuntocategorias = <?php echo json_encode($conjuntocategorias); ?>;

$('#FacturaMiCarroForm').submit(function(){
	
	if($('#FacturaTotal').val()==0){
		alert('No Seleccionó ningun Producto para su Compra');
		return false;
	}else{
		document.getElementById('jq_submit').style.display = 'block'; 
        this.style.display = 'none';
        
		return true;
	}
});

/** Se calcula las cantidades X Categoria **/
// Revision Ok
function calcularCantidades(categoriaid){
	var tdclass= 'jq_inputcantidad_'+categoriaid;
	var contador= 0;
	$("."+tdclass).each(function() {
	  var inputnuevo = $(this).find('.cart_quantity_input');
	  contador = parseFloat(contador) + parseFloat(inputnuevo.val());
	});
	return (contador);

}

/** Segun la cantidad que se ingrese para una categoria se calcula su precio correspondiente **/
// Revision Ok
function calcularCantidadesPrecio(categoriaid, subcategoriaid, cantidad){
	var precioporcantidad = 0;
	
	$.each(cantidadporcategorias, function(idx, obj) {
		 
		 // Asigno la cantidad a la categoria Padre.
		 if (obj.Categoria.id == categoriaid){
		 	obj.totalporcategoria = cantidad;
		 	
		 }
		 //Busco la subcategoria para obtener sus precios
		 if (obj.Categoria.id == subcategoriaid){
		 	
		 	for (i = 0; i < obj.Preciosproducto.length; i++) {
		 	    precioporcantidad = obj.Preciosproducto[i].precio;
		 	   	obj.precioporcategoria =precioporcantidad;	  
			   if (((cantidad >= obj.Preciosproducto[i].desde ) && (cantidad <= obj.Preciosproducto[i].hasta )) || (cantidad==0)){
			    	 
			   	break;
			   }
			}
		 }
	});
	
	/** Agrego al final de cada seccion la cantidad de productos , el costo y el precio **/
	$.each(cantidadporcategorias, function(i, item) {
		if ((item.Categoria.id == categoriaid) && (item.Categoria.subcategoria_id == 0)){
		    $('#jq_resutadosubtotales'+item.Categoria.id).html('<b>'+item.Categoria.nombre+'</b></br><b> Cantidad:</b> '+item.totalporcategoria+'</br>');
		}		
	});
	
	
	return (precioporcantidad);
 
}

function ActualizarPreciosCategoria(categoriaid, cantidad){
	// se utiliza para seleccionar el renglon completo.
	var rengloncategoria = 'jq_cat_id_'+categoriaid;
	

	$("."+rengloncategoria).each(function(){
		var inputprecioclass = $(this).find('.jq_inputprecio');
		var labelprecioprecio = $(this).find('.jq_labelprecio');
		var preciosubtotal = $(this).find('.jq_subtotal');   
		var labelpreciopreciototal = $(this).find('.cart_total_price');
		var cantidadesclass= $(this).find('.cart_quantity_input');
		var subcategoriaid = $(this).attr("subcategoria");
		
		var precionuevo = calcularCantidadesPrecio(categoriaid , subcategoriaid ,cantidad);
		
		inputprecioclass.val(precionuevo);
		labelprecioprecio.html('$'+precionuevo);

		preciosubtotal.val(parseFloat(inputprecioclass.val()) * parseFloat(cantidadesclass.val()) );
		labelpreciopreciototal.html('$'+parseFloat(inputprecioclass.val()) * parseFloat(cantidadesclass.val()));

	});


}

function sumartotales(){
	var total = 0;
	var auxprecio = 0;
	var total = 10;
	for (var i = 0; i < totalrenglones; i++) {
		//Compruebo si existe el selector
		
			auxprecio = $('#jq_totalinput_'+i).val();
	  	 	total= total + parseFloat(auxprecio);
			
  	};
  	return total;
}

function ActualizarRenglondDisabled(nrorenglon){
	var rengloncategoria = 'jq_nro_renglon_'+nrorenglon;
	
	$('#Detalle'+nrorenglon+'ProductoId').removeAttr("disabled");
	$('#Detalle'+nrorenglon+'Nombre').removeAttr("disabled");
	$('#Detalle'+nrorenglon+'Costo').removeAttr("disabled");
	$('#Detalle'+nrorenglon+'Precio').removeAttr("disabled");
	$('#Detalle'+nrorenglon+'Cantidad').removeAttr("disabled");
	
	/**
	$("."+rengloncategoria+" input").each(function(){
		$(this).removeAttr("disabled");
	});
	**/
}

$(".cart_quantity_up").on("click", function(event) {

  event.preventDefault();
  var button = $(this);
  var oldValue = button.parent().find("input").val();
  var maxvalue = button.parent().find("input").attr('max');
  var renglon = button.parent().find("input").attr('idrenglon');
  var categoriaid = button.parent().find("input").attr('idcategoria');
  var subcategoriaid = button.parent().find("input").attr('idsubcategoria');
  

  // incremento campo cantidad
  var newVal = parseFloat(oldValue) + 1;
  if (newVal <= parseFloat(maxvalue)){
	  button.parent().find("input").val(newVal);
	  
	  ActualizarRenglondDisabled(renglon);

	  //Obtengo todas las cantidades, precio y actualizo para dicha categoria
	  var cantidad = calcularCantidades(categoriaid);

	  ActualizarPreciosCategoria(categoriaid, cantidad);

	  //total de la factura
	  var newTotalfact = sumartotales();

	  $('#FacturaTotal').val(parseFloat(newTotalfact));
	  $('.jq_totalfact').html(parseFloat(newTotalfact));
  }else{
  	alert('Stock Insuficiente. Su pedido puede ser despachado con menos productos de este tipo.');
  }
});

$(".cart_quantity_up_12").on("click", function(event) {

  event.preventDefault();
  var button = $(this);
  var oldValue = button.parent().find("input").val();
  var maxvalue = button.parent().find("input").attr('max');
  var renglon = button.parent().find("input").attr('idrenglon');
  var categoriaid = button.parent().find("input").attr('idcategoria');
  var subcategoriaid = button.parent().find("input").attr('idsubcategoria');
  

  // incremento campo cantidad
  var newVal = parseFloat(oldValue) + 12;
  if (newVal <= parseFloat(maxvalue)){
	  button.parent().find("input").val(newVal);
	  
	  ActualizarRenglondDisabled(renglon);

	  //Obtengo todas las cantidades, precio y actualizo para dicha categoria
	  var cantidad = calcularCantidades(categoriaid);

	  ActualizarPreciosCategoria(categoriaid, cantidad);

	  //total de la factura
	  var newTotalfact = sumartotales();

	  $('#FacturaTotal').val(parseFloat(newTotalfact));
	  $('.jq_totalfact').html(parseFloat(newTotalfact));
  }else{
  	alert('Stock Insuficiente. Su pedido puede ser despachado con menos productos de este tipo.');
  }
});

$(".cart_quantity_down").on("click", function(event) {

  event.preventDefault();
  var newVal = 0;
  var button = $(this);
  var oldValue = button.parent().find("input").val();
  var renglon = button.parent().find("input").attr('idrenglon');
  var categoriaid = button.parent().find("input").attr('idcategoria');
  var subcategoriaid = button.parent().find("input").attr('idsubcategoria');
  
  

  
  
  
  if (oldValue > 0) {
      var newVal = parseFloat(oldValue) - 1;
  }
 // resto campo cantidad
  button.parent().find("input").val(newVal);
  
 //Obtengo todas las cantidades, precio y actualizo para dicha categoria
  var cantidad = calcularCantidades(categoriaid);
  
 
 ActualizarPreciosCategoria(categoriaid, cantidad);

  
  //total de la factura
  var newTotalfact = sumartotales();

  $('#FacturaTotal').val(parseFloat(newTotalfact));
	  $('.jq_totalfact').html(parseFloat(newTotalfact));
  

});

$(".cart_quantity_down_12").on("click", function(event) {

  event.preventDefault();
  var newVal = 0;
  var button = $(this);
  var oldValue = button.parent().find("input").val();
  var renglon = button.parent().find("input").attr('idrenglon');
  var categoriaid = button.parent().find("input").attr('idcategoria');
  var subcategoriaid = button.parent().find("input").attr('idsubcategoria');
  
  

  
  
  
  if (oldValue > 11) {
      var newVal = parseFloat(oldValue) - 12;
  }
 // resto campo cantidad
  button.parent().find("input").val(newVal);
  
 //Obtengo todas las cantidades, precio y actualizo para dicha categoria
  var cantidad = calcularCantidades(categoriaid);
  
 
 ActualizarPreciosCategoria(categoriaid, cantidad);

  
  //total de la factura
  var newTotalfact = sumartotales();

   $('#FacturaTotal').val(parseFloat(newTotalfact));
	  $('.jq_totalfact').html(parseFloat(newTotalfact));
  

});

/*
$(document).on("click",".cart_quantity_delete", function(event) {
		event.preventDefault();
		var nro_renglon = $(this).attr('nrorenglon');
		var categoriaid =  $(this).attr('categoriaid');
		var id = $(this).attr('item-id');
		
		$(this).closest("tr").remove();
		

		//Obtengo todas las cantidades, precio y actualizo para dicha categoria
		  var cantidades = calcularCantidades(categoriaid);
		  var preciocantidades = calcularCantidadesPrecio(categoriaid , cantidades);

		  ActualizarPreciosCategoria(categoriaid, preciocantidades);

		  //total de la factura
		  var newTotalfact = sumartotales();

		  $('#FacturaTotal').val(newTotalfact);
		  $('.jq_totalfact').html(newTotalfact);
	  	
	  	$.ajax({
	        data: {id: id},
	        url:   baseUrldeleteitem,
	        type:  'post',
	        async: false,
	        success:  function (response) {
	        	json = JSON.parse(response);
	        	if (json.mensaje=='OK'){
	        		$("#jq_Cartcant").html(json.cantidad);
	        		$('#css_cartcant').css('color','orange');
					$('css_cartcant').css('font-weight','bold');
	        	}
	        	else{
	        		alert('No se pudo eliminar el producto Seleccionado.')
	        	}
	        }
		});
		
		
	});

$(window).load(function(){
	
});
*/


</script>
<style type="text/css">
.nav-tabs>li {
    float: left;
    margin-bottom: -1px;
    border-color: #146CB3;
    border-left: 1px solid;
    border-top: 1px solid;
    border-right: 1px solid;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.titulosubcategoria{
	
	font-size: 14px;
	color: grey;

}
</style>