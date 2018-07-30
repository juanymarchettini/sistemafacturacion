
<?php echo $this->Html->css(array('vendor/select2/select2','vendor/select2/select2-bootstrap','vendor/pnotify/pnotify.custom')); ?>

<?php echo $this->Element('backend/headerpage',array('titleheader'=>$titulo,'shorturl'=>'Pedidos')); ?>
<?php
    echo $this->Form->create('Factura', array(
    'type'=>'file',
    'action'=>$action,
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => false
)); 
 
 echo $this->Html->script(array('jquery.easy-autocomplete.min'));
 echo $this->Html->css(array("easy-autocomplete.min" ));

?>


<section class="panel panel-info">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo $titulo; ?></h2>

		 <?php 

		 	if ($action != 'add'){
		 		echo $this->Html->link('<i class="fa fa-step-backward"></i> Volver a Factura</button>',array('controller'=>'Facturas', 'action'=>'view/'.$this->request->data['Factura']['id']),array('escape'=>false,'class'=>"mb-xs mt-xs mr-xs btn btn-default"));
		 	}

		    
		?>
		 
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Datos del Pedido'); ?></legend>
				<div class="row">
				<?php
					
					echo $this->Form->hidden('id', array('class'=>'col-md-6'));

				?>
				    <div class="col-xs-12 col-md-6">
				<?php
						echo $this->Form->input('search',array('label'=>'Buscar Usuario','id'=>'inputSearch','div'=>'', 'type'=>'text')); ?>

						<a class="modal-with-form btn btn-default"  id="clientenuevo-ajax-modal" style="margin-top:10px;" href=<?php echo $this->Html->url(array("controller" => "users","action" =>"ajaxbloquenuevocliente" ));?>>+ Nuevo</a>
					</div>
					<?php 
					echo '<div style="clear:both;"></div>';
					echo $this->Form->hidden('user_id',array('label'=>'Nro de Usuario','div'=>'col-md-4', 'type'=>'text','required'));
					echo $this->Form->input('nombre',array('label'=>'Nombre','div'=>'col-md-4','required'));
					echo $this->Form->input('apellido',array('label'=>'Apellido','div'=>'col-md-4','required'));
					echo $this->Form->input('tel',array('label'=>'Tel','div'=>'col-md-3'));
					echo $this->Form->input('localidad',array('label'=>'Localidad','div'=>'col-md-3'));
					echo $this->Form->input('direccion',array('label'=>'Direccion','div'=>'col-md-3'));
					echo $this->Form->input('cp',array('label'=>'CP','div'=>'col-md-3'));
					echo $this->Form->input('email',array('label'=>'Email','div'=>'col-md-4','required'));
					echo '<div style="clear:both;"></div> </br>';
					if ($action != 'add'){
						echo '<div class="col-md-3"> <b> Entregado: </b> <h3>';
						echo ($pedido['Factura']['entregado'])? '<i class="fa fa-check-square-o" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>';
						echo '</h3></div>';
						echo '<div class="col-md-3"> <b>Armado: </b> <h3> ';
						echo ($pedido['Factura']['empaquetado'])? '<i class="fa fa-check-square-o" aria-hidden="true"></i>': '<i class="fa fa-times" aria-hidden="true"></i>';
						echo ' </h3></div>';
						
						echo '<div style="clear:both;"></div> </br>';
						if (!$pedido['Factura']['entregado']){
							echo $this->Form->submit(__('Guardar Factura'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
						}
					}

				?>
				</div>
				<div class="row" style="margin-top:30px;">
					<legend><?php echo __('Detalle del Pedido'); ?></legend>
					
					<div class="rangoprecios">
						<span style="font-weight:bold; font-style: italic;">Nota: Los Productos seleccionados, traen el ultimo precio de compra</span>
					
						<div class="table-responsive">
							<table class="table table-hover" id="tableprice">
							<tr>
								<th>
									Codigo
								</th>
								<th>
									Nombre
								</th>
								<th>
									Cantidad
								</th>
								<th>
									Precio
								</th>
								<th>
									Iva
								</th>
								<th>
									Eliminar
								</th>
							</tr>
							<?php 
								
							    if (isset($this->request->data['Detalle'])){
									$i=0; 
									
									foreach ($this->request->data['Detalle'] as $value) :   ?>
										
										<tr id=<?php echo  'renglon'.$i; ?> >
											<?php
												echo $this->Form->hidden('Detalle.'.$i.'.id',array('label'=>false,'required'));
												echo $this->Form->hidden('Detalle.'.$i.'.factura_id',array('label'=>false,'required'));
												echo $this->Form->hidden('Detalle.'.$i.'.producto_id',array('label'=>false,'required', 'renglon'=>$i));
												echo $this->Form->hidden('Detalle.'.$i.'.costo',array('label'=>false,'required', 'renglon'=>$i));
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.codigo',array('label'=>false,'required','readonly' ,'renglon'=>$i,'type'=>"text")).'</td>';
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.nombre',array('label'=>false,'required', 'renglon'=>$i)).'</td>';
												
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.cantidad',array('label'=>false,'required','categoria'=>$listaproductoscategoriaid[$value['producto_id']], 'renglon'=>$i,'type'=>"number",'class'=>'form-control inputcantidad', 'min'=>0)).'</td>';
												
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.precio',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'step'=>"any", 'class'=>'form-control inputprecio','min'=>0)).'</td>';
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.iva',array('label'=>false,'required', 'readonly' ,'renglon'=>$i,'type'=>"number", 'step'=>"any", 'class'=>'form-control inputprecio','min'=>0)).'</td>';
												
												//link para eliminar pedido de la factura
												if (!$pedido['Factura']['entregado']){
													echo '<td>'.$this->Form->button('<span class="glyphicon glyphicon-remove"></span>',array('label'=>false, 'type'=>"button", 'onClick'=>"if (confirm('Esta Seguro que desea Eliminar este Producto del Pedido?'))  DeleteAjax(".$i.")",'escape'=>false )).'</td>';
												}
											?>
										</tr>
									 	
								<?php $i++; endforeach; 
								
								} /* FIN DEL IF PRECIOSPRODUCTO */
								
								?>
						
						</table>
						
						</div>


						<div class="row" style="margin-top:20px;">
						<div class="col-md-5" style="margin-top:20px; margin-bottom:20px;">
							<input id="inputOne" placeholder="Ingrese Codigo o Nombre del Producto" />
							<a class="modal-with-form btn btn-default"  id="producto-ajax-lista" style="margin-top:10px;" href=<?php echo $this->Html->url(array("controller" => "productos","action" =>"modal_listaproductos" ));?>>Ver Producto</a>
						</div>

						</div>
						<div class="row" style="margin-left:5px; margin-bottom:20px;">
							
							<?php echo $this->Form->button('Agregar Linea Vacia', array('class'=>'mb-xs mt-xs mr-xs btn btn-success col-md-2 col-xs-12', 'type'=>'button', 'onclick'=>"AddNewline()"));?>
						</div>
					
						

					</div>
					<div class="step-one">
						<legend>Detalle del Pedido</legend>
					</div>
					<div id="detallecategoriafinal" style="font-size: 15px; font-weight: bold; margin-bottom: 20px;">

					</div>
					<table class="table table-condensed total-result">
						<tr>
							<td>Compra Sub Total</td>
							<td><b><span>$ </span><span class="jq_subtotalfact"> <?php  echo (isset($this->request->data['Factura']['total']))? $this->request->data['Factura']['total'] : '0' ; ?></span>.-</b></td>
						</tr>
					    <tr class="shipping-cost">
							<td>Iva 21% </td>
							<td>$<b id="jq_iva21">--</b></td>										
						</tr>
						 <tr class="shipping-cost">
							<td>Iva 10,5% </td>
							<td>$<b id="jq_iva105">--</b></td>										
						</tr>
						<tr>
							<td>Total</td>
							<?php echo $this->Form->hidden('total'); ?>
							<td><b><span>$ </span><span class="jq_totalfact"> <?php  echo (isset($this->request->data['Factura']['total']))? $this->request->data['Factura']['total'] : '0' ; ?></span>.-</b></td>
						</tr>
					</table>
			<?php
			if ( (!isset($pedido['Factura']['entregado'])) ||  (!$pedido['Factura']['entregado'])) {
				echo $this->Form->submit(__('Guardar Pedido'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			}
			echo $this->Form->end();

			?>
			 <?php 
			   if ($action != 'add'){
			 	echo $this->Html->link('<i class="fa fa-step-backward"></i> Volver a Pedidos</button>',array('controller'=>'Facturas', 'action'=>'view/'.$this->request->data['Factura']['id']),array('escape'=>false,'class'=>"mb-xs mt-xs mr-xs btn btn-warning"));

			   }
			 ?>

			
			 </div>
			</fieldset>
		</section>
	</div>
</section>
<script type="text/javascript">
var renglones = <?php echo (isset($this->request->data['Detalle']))? count($this->request->data['Detalle']): '0'; ?>

var categoriapadrelista = <?php echo json_encode($categoriapadrelista); ?>;
var categoriapadrenombre = <?php echo json_encode($categoriapadrenombre); ?>;
var categoriahijopadrelista= <?php echo json_encode($categoriahijopadrelista); ?>;




function Addrow(newrow){
    
	$('#tableprice > tbody').append("<tr id='renglon"+newrow+"'>"+'<td><div class="form-group"><input  class="form-control inputone" name="data[Detalle]['+newrow+'][codigo]" required="required" renglon='+newrow+' readonly id="Detalle'+newrow+'Codigo"/></div><input type="hidden" name="data[Detalle]['+newrow+'][producto_id]" required="required" id="Detalle'+newrow+'ProductoId"/><input type="hidden" name="data[Detalle]['+newrow+'][factura_id]" required="required" id="Detalle'+newrow+'factura_id"/> <input name="data[Detalle]['+newrow+'][costo]" class="form-control" required="required" renglon='+newrow+' min="0" step="any" type="hidden" id="Detalle'+newrow+'Costo"/> <td><div class="input text"><input class="form-control" name="data[Detalle]['+newrow+'][nombre]" required="required" renglon='+newrow+' maxlength="300" type="text" id="Detalle'+newrow+'Nombre"/></div></td><td><div class="form-group"><input  class="form-control inputcantidad" name="data[Detalle]['+newrow+'][cantidad]" required="required" renglon='+newrow+' min="0" type="number" id="Detalle'+newrow+'Cantidad"/></div></td><td><div class="form-group"><input name="data[Detalle]['+newrow+'][precio]" class="form-control inputprecio" required="required" renglon='+newrow+' min="0" step="any" type="number" id="Detalle'+newrow+'Precio"/></div></td>'+'<td><div class="form-group"><input name="data[Detalle]['+newrow+'][iva]" class="form-control inputiva" required="required" renglon='+newrow+' min="0" step="any" readonly type="number" id="Detalle'+newrow+'Iva"/></div></td>'+'<td><button type="button" onClick="DeleteRow('+newrow+')"><span class="glyphicon glyphicon-remove"></span></button></td>'+"</tr>");

}

function AddNewline(){
	 var newrow = renglones;
	 renglones = renglones+1;
	 Addrow(newrow);
}

var options = {

    url: '<?php echo $this->Html->url(array("controller" => "productos", "action" => "listjsonproductosconstock" ));?>',

    getValue: function(element) {
        return 'Cod: '+element.codigo+'- '+element.nombre+'- Stock: '+element.stock;
    },

    adjustWidth: false,
    

    list: {
    	match: {
            enabled: true
        },
        maxNumberOfElements: 10,
        sort: {
            enabled: true
        },
        onKeyEnterEvent: function(){

        },
        onChooseEvent: function() {
            
            var newrow = renglones;
			renglones = renglones+1;
			

			Addrow(newrow);
				
			$('#Detalle'+newrow+'ProductoId').val( $("#inputOne").getSelectedItemData().id);
			$('#Detalle'+newrow+'Codigo').val( $("#inputOne").getSelectedItemData().codigo);
			$('#Detalle'+newrow+'Precio').val( $("#inputOne").getSelectedItemData().preciocompra);
			$('#Detalle'+newrow+'Nombre').val( $("#inputOne").getSelectedItemData().nombre);
			$('#Detalle'+newrow+'Cantidad').val(1);
			$('#Detalle'+newrow+'Costo').val( $("#inputOne").getSelectedItemData().preciocompra);
			$('#Detalle'+newrow+'Cantidad').val(1);
			$('#Detalle'+newrow+'Cantidad').attr('max',$("#inputOne").getSelectedItemData().stock);
			$('#Detalle'+newrow+'Precio').val( $("#inputOne").getSelectedItemData().precio);
			$('#Detalle'+newrow+'Iva').val( $("#inputOne").getSelectedItemData().iva);
			

			
            $('#Detalle'+newrow+'Cantidad' ).focus();

            actualizarTotal();
            //categoriapadrelista
        },
        onSelectItemEvent: function() {
           $("#inputOne").val("").trigger("change");
    	}
    }
};

var optionscliente = {

    url: '<?php echo $this->Html->url(array("controller" => "users", "action" => "listjsonclientes" ));?>',

    getValue: function(element) {
        return element.apellido+','+element.nombre+"- Cuit: "+element.cuit;
    },
    adjustWidth: true,
    
    ajaxSettings: {
    dataType: "json",
    method: "POST",
    data: {
      dataType: "json"
	    }
	},

	preparePostData: function(data) {
    data.phrase = $("#inputSearch").val();
    return data;
  	},

    list: {
    	match: {
            enabled: true
        },
        maxNumberOfElements: 10,
        sort: {
            enabled: true
        },
        onKeyEnterEvent: function(){

        },
        onChooseEvent: function() {
					
			$('#FacturaUserId').val( $("#inputSearch").getSelectedItemData().id);
			$('#FacturaNombre').val( $("#inputSearch").getSelectedItemData().nombre);
			$('#FacturaApellido').val( $("#inputSearch").getSelectedItemData().apellido);
			$('#FacturaLocalidad').val( $("#inputSearch").getSelectedItemData().ciudad);
			$('#FacturaDireccion').val( $("#inputSearch").getSelectedItemData().direccion);
			$('#FacturaTel').val( $("#inputSearch").getSelectedItemData().telefono);
			$('#FacturaEmail').val( $("#inputSearch").getSelectedItemData().username);
			

            
            //categoriapadrelista
        },
        onSelectItemEvent: function() {
           $("#inputSearch").val("").trigger("change");
    	}
    }
};


$("#inputOne").easyAutocomplete(options);

$("#inputSearch").easyAutocomplete(optionscliente);



function DeleteRow(row){
	var deletevalue = $('#renglon'+row+' .inputcantidad').val();
	var categoria= $('#renglon'+row+' .inputcantidad').attr('categoria');
	
	$('#renglon'+row).remove();
	actualizarTotal();
}

// si se modifica la cantidad actualizo arreglos

function actualizarTotal(){
	var i;
	var total=0;
	var subtotal=0;
	var iva21=0;
	var iva105=0;

	for (i = 0; i < renglones; i++) { 
		cantidad = $('#renglon'+i+' .inputcantidad').val();
		precio =  $('#renglon'+i+' .inputprecio').val();
		iva =  $('#renglon'+i+' .inputiva').val();

		
		if (cantidad !=undefined ){
			ivafinal=(parseFloat(iva)/100)+1;
			if (parseFloat(iva)==21){
				iva21+=  parseInt(cantidad) * parseFloat(precio) * (parseFloat(iva)/100);
			}
			console.log(parseFloat(iva21));

			subtotal += parseInt(cantidad) * parseFloat(precio);
			total += parseInt(cantidad) * parseFloat(precio) * ivafinal ;
		}
	    
	}
	
	$('.jq_subtotalfact').html(subtotal.toFixed(2));
	$('#jq_iva21').html(iva21.toFixed(2));
	$('#jq_iva105').html(iva105.toFixed(2));
	$('.jq_totalfact').html(total.toFixed(2));
}





$('body').on('focusin','.inputcantidad', function(){
    $(this).data('valold', $(this).val());
});

$('body').on('change','.inputcantidad', function(){
    var oldvalue = $(this).data('valold');
    var newvalue = $(this).val();
    var categoria= $(this).attr('categoria');
    var renglon = $(this).attr('renglon');
   
    actualizarTotal();
    

});

//cambian los precios solo actualizo totales 
$('body').on('change','.inputprecio', function(){

	actualizarTotal();
});


$('body').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

$(window).load(function() {
      actualizarTotal();
});

function DeleteAjax(row){
	var deletevalue = $('#renglon'+row+' .inputcantidad').val();
	var categoria= $('#renglon'+row+' .inputcantidad').attr('categoria');
	var id = $('#Detalle'+row+'Id').val();
	
	$.ajax({                   
        url: '<?php echo $this->Html->url(array("controller" => "facturas","action" => "deletedetalleajax"));?>',
        data: { id: id},
        cache: false,
        type: 'GET',
        
        success: function (response) {
            
			$('#renglon'+row).remove();
			actualizarTotal();
        }
    });
	
}

</script>
<style type="text/css">
.easy-autocomplete input{
	
	width: 400px;
}

</style>


<!----- Form Para usuariio -->

<?php echo $this->Html->script(array('vendor/select2/select2','vendor/magnific-popup/magnific-popup','vendor/pnotify/pnotify.custom')); ?>

<script type="text/javascript">

/*
Modal Dismiss
*/
$(document).on('click', '.modal-dismiss', function (e) {
  e.preventDefault();
  $.magnificPopup.close();
});
    
/*
Modal Confirm
*/
$(document).on('click', '.modal-confirm', function (e) {
  e.preventDefault();
  $.magnificPopup.close();

  new PNotify({
    title: 'Ok!',
    text: 'Pago Realizado',
    type: 'success'
  });
});
//Select Confirm

$(document).on('click', '.info-select', function (e) {
  e.preventDefault();
  $.magnificPopup.close();

    var id =$(this).attr('codid');
    var newrow = renglones;
  	
  	$.ajax({
        url: "<?php echo $this->Html->url(array('controller'=>'productos', 'action'=>'jsonproductodata')); ?>",
        type: "GET",
        data: {'codid':id},
  		datatype: 'json',
	    success: function(data){
	        
	         producto=JSON.parse(data);
	         
	        
			//renglones es variable global
			renglones = renglones+1;
			

			Addrow(newrow);
				
			$('#Detalle'+newrow+'ProductoId').val(producto.id);
			$('#Detalle'+newrow+'Codigo').val(producto.codigo);
			$('#Detalle'+newrow+'Nombre').val(producto.nombre);
			$('#Detalle'+newrow+'Cantidad').val(1);
			$('#Detalle'+newrow+'Cantidad').attr('max',producto.stock);
			$('#Detalle'+newrow+'Costo').val(producto.preciocompra);	
			$('#Detalle'+newrow+'Precio').val(producto.precio);
			$('#Detalle'+newrow+'Iva').val(producto.iva);
		    $('#Detalle'+newrow+'Cantidad' ).focus();

		    actualizarTotal();
		          
	    },
	    error:function(){
	        alert('Error Al intentar Recuperar el Producto Seleccionado');
	        
	    }   
    }); 
    
});




$('#clientenuevo-ajax-modal').magnificPopup({
    type: 'ajax',
    settings: {cache:false, async:false},
    modal: true

});

$('#producto-ajax-lista').magnificPopup({
    type: 'ajax',
    settings: {cache:false, async:false},
    modal: true

});

</script>