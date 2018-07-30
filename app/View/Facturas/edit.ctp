<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Editar Pedido','shorturl'=>'Pedido')); ?>
<?php
    echo $this->Form->create('Factura', array(
    'type'=>'file',
    'action'=>'edit',
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
		<h2 class="panel-title"><?php echo 'Editar Pedido'; ?></h2>

		 <?php echo $this->Html->link('<i class="fa fa-step-backward"></i> Volver a Pedido</button>',array('controller'=>'Facturas', 'action'=>'view/'.$this->request->data['Factura']['id']),array('escape'=>false,'class'=>"mb-xs mt-xs mr-xs btn btn-default"));

		    
		?>
		 
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Datos Factura'); ?></legend>
				<div class="row">
				<?php
					
					echo $this->Form->hidden('id', array('class'=>'col-md-6'));
					echo $this->Form->hidden('user_id');
					echo '<div class="col-md-3"> Nro de Factura: <h3>'. $this->request->data['Factura']['id'].'</h3></div>';
					echo '<div class="col-md-3"> Fecha Factura: <h3>'. date_format(date_create($this->request->data['Factura']['created']), 'd-m-Y H:m').'</h3></div>';
					echo '<div class="col-md-3"> Tipo de Pago: <b><h3>'. $this->request->data['Factura']['tipodepago'].'</b></h3></div>';
					echo '<div class="col-md-3"> Forma de Envio: <b><h3>'. $this->request->data['Factura']['formadeenvio'].'</b></h3></div>';
					echo '<div style="clear:both;"></div>';
					echo $this->Form->input('user_id',array('label'=>'Nro de Usuario','type'=>'text'));
					echo $this->Form->input('nombre',array('label'=>'Nombre','div'=>'col-md-4'));
					echo $this->Form->input('apellido',array('label'=>'Apellido','div'=>'col-md-4'));
					echo $this->Form->input('tel',array('label'=>'Tel','div'=>'col-md-3'));
					echo $this->Form->input('localidad',array('label'=>'Localidad','div'=>'col-md-3'));
					echo $this->Form->input('direccion',array('label'=>'Direccion','div'=>'col-md-3'));
					echo $this->Form->input('cp',array('label'=>'CP','div'=>'col-md-3'));
					echo '<div style="clear:both;"></div> </br>';
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

				?>
				</div>
				<div class="row" style="margin-top:30px;">
					<legend><?php echo __('Detalle Factura'); ?></legend>
					
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
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.codigo',array('label'=>false,'required', 'renglon'=>$i,'type'=>"text")).'</td>';
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.nombre',array('label'=>false,'required', 'renglon'=>$i)).'</td>';
												
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.cantidad',array('label'=>false,'required','categoria'=>$listaproductoscategoriaid[$value['producto_id']], 'renglon'=>$i,'type'=>"number",'class'=>'form-control inputcantidad', 'min'=>0)).'</td>';
												
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.precio',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'step'=>"any", 'class'=>'form-control inputprecio','min'=>0)).'</td>';
												
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
							<td><b><span>$ </span><span class="jq_totalfact"> <?php  echo $this->request->data['Factura']['total'] ; ?></span>.-</b></td>
						</tr>
					    <tr class="shipping-cost">
							<td>Gasto de Envio</td>
							<td>Consultar</td>										
						</tr>
						<tr>
							<td>Total</td>
							<?php echo $this->Form->hidden('total'); ?>
							<td><b><span>$ </span><span class="jq_totalfact"><?php  echo $this->request->data['Factura']['total'] ; ?></span>.-</b></td>
						</tr>
					</table>
			<?php
			if (!$pedido['Factura']['entregado']){
				echo $this->Form->submit(__('Guardar Pedido'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			}
			echo $this->Form->end();

			?>
			 <?php echo $this->Html->link('<i class="fa fa-step-backward"></i> Volver a Pedidos</button>',array('controller'=>'Facturas', 'action'=>'view/'.$this->request->data['Factura']['id']),array('escape'=>false,'class'=>"mb-xs mt-xs mr-xs btn btn-warning"));?>

			
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
    
	$('#tableprice > tbody').append("<tr id='renglon"+newrow+"'>"+'<td><div class="form-group"><input  class="form-control inputone" name="data[Detalle]['+newrow+'][codigo]" required="required" renglon='+newrow+'  id="Detalle'+newrow+'Codigo"/></div><input type="hidden" name="data[Detalle]['+newrow+'][producto_id]" required="required" id="Detalle'+newrow+'ProductoId"/><input type="hidden" name="data[Detalle]['+newrow+'][factura_id]" required="required" id="Detalle'+newrow+'factura_id"/> <input name="data[Detalle]['+newrow+'][costo]" class="form-control" required="required" renglon='+newrow+' min="0" step="any" type="hidden" id="Detalle'+newrow+'Costo"/> <td><div class="input text"><input class="form-control" name="data[Detalle]['+newrow+'][nombre]" required="required" renglon='+newrow+' maxlength="300" type="text" id="Detalle'+newrow+'Nombre"/></div></td><td><div class="form-group"><input  class="form-control inputcantidad" name="data[Detalle]['+newrow+'][cantidad]" required="required" renglon='+newrow+' min="0" type="number" id="Detalle'+newrow+'Cantidad"/></div></td><td><div class="form-group"><input name="data[Detalle]['+newrow+'][precio]" class="form-control inputprecio" required="required" renglon='+newrow+' min="0" step="any" type="number" id="Detalle'+newrow+'Precio"/></div></td>'+'<td><button type="button" onClick="DeleteRow('+newrow+')"><span class="glyphicon glyphicon-remove"></span></button></td>'+"</tr>");

}

function AddNewline(){
	 var newrow = renglones;
	 renglones = renglones+1;
	 Addrow(newrow);
}

var options = {

    url: '<?php echo $this->Html->url(array("controller" => "productos", "action" => "listjsonfacturas" ));?>',

    getValue: function(element) {
        return element.codigo+'-'+element.nombre;
    },
    adjustWidth: false,
    

    list: {
    	match: {
            enabled: true
        },
        maxNumberOfElements: 6,
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
			$('#Detalle'+newrow+'Precio').val( $("#inputOne").getSelectedItemData().precio);
			categoriaid = $("#inputOne").getSelectedItemData().categoria_id;
			$('#Detalle'+newrow+'Cantidad').attr('categoria',categoriaid);
            $('#Detalle'+newrow+'Cantidad' ).focus();

            
            //categoriapadrelista
        },
        onHideListEvent: function() {
           $("#inputOne").val("").trigger("change");
    	}
    }
};

$("#inputOne").easyAutocomplete(options);

function DeleteRow(row){
	var deletevalue = $('#renglon'+row+' .inputcantidad').val();
	var categoria= $('#renglon'+row+' .inputcantidad').attr('categoria');
	actualizarCategoria(deletevalue,0,categoria);
	$('#renglon'+row).remove();
	actualizarTotal();
}

// si se modifica la cantidad actualizo arreglos

function actualizarTotal(){
	var i;
	var total=0;
	for (i = 0; i < renglones; i++) { 
		cantidad = $('#renglon'+i+' .inputcantidad').val();
		precio =  $('#renglon'+i+' .inputprecio').val();
		
		if (cantidad !=undefined ){
			total += parseInt(cantidad) *parseFloat(precio);
		}
	    
	}
	
	$('.jq_totalfact').html(total.toFixed(2));
}

function actualizarCategoria(oldvalue,newvalue,categoria){

	if (categoriahijopadrelista[categoria] != undefined){

    	categoria = categoriahijopadrelista[categoria];
    }
    //console.log(categoria);
    categoriapadrelista[categoria]=parseInt(categoriapadrelista[categoria])-parseInt(oldvalue)+parseInt(newvalue);


	var labelcat="";
	$.each( categoriapadrelista, function( i, val ) {
  		if (val >0){
  			console.log(i);
  			console.log(categoriapadrenombre);
    		labelcat=labelcat+categoriapadrenombre[i]+" : "+val+" </br>";
    	}
	});

    $("#detallecategoriafinal").html(labelcat);
    


}



$('body').on('focusin','.inputcantidad', function(){
    $(this).data('valold', $(this).val());
});

$('body').on('change','.inputcantidad', function(){
    var oldvalue = $(this).data('valold');
    var newvalue = $(this).val();
    var categoria= $(this).attr('categoria');
    var renglon = $(this).attr('renglon');
    actualizarCategoria(oldvalue,newvalue,categoria);
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
            actualizarCategoria(deletevalue,0,categoria);
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
