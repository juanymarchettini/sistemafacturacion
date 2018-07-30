<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Ingreso de Dinero','shorturl'=>'Ingreso de Dinero')); ?>
<?php
    echo $this->Form->create('Factura', array(
    'type'=>'file',
    'action'=>'ingresoplataadd',
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


<section class="panel panel-danger">
	<header class='panel-heading'>
		<h2 class="panel-title"><?php echo 'Ingreso Dinero'; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Datos del Ingreso'); ?></legend>
				<div class="row">
				<?php
					echo $this->Form->hidden('id', array('class'=>'col-md-6'));
					echo $this->Form->hidden('cliente_id',array('value'=>$userid));
					echo $this->Form->hidden('user_id',array('value'=>$userid));
					echo $this->Form->input('nombre',array('label'=>'Nombre ','div'=>'col-md-4'));
					echo $this->Form->input('apellido',array('label'=>'Apellido ','separator'=>'','type'=>'date','div'=>'col-md-4','dateFormat'=>'DMY','monthNames' => false,'maxYear' => date('Y')+1,'minYear' => date('Y')-1 ));
					cho $this->Form->input('message',array('label'=>'Nota:','separator'=>'','type'=>'date','div'=>'col-md-12','maxYear' => date('Y')+1,'minYear' => date('Y')-1 ));
					
					echo $this->Form->hidden('entregado',array('label'=>'Nota','value'=>1,'div'=>'col-md-5'));
					echo $this->Form->hidden('facturado',array('label'=>'Nota','value'=>1,'div'=>'col-md-5'));
					echo $this->Form->hidden('statuspago',array('label'=>'Nota','value'=>'Pagado','div'=>'col-md-5'));
					
					
					

				?>
				</div>
				<div class="row" style="margin-top:30px;">
					<legend><?php echo __('Detalle Factura'); ?></legend>
					<div class="row" style="margin-top:20px; margin-bottom:20px;">
						
						<?php echo $this->Form->button('Agregar Linea Vacia', array('class'=>'mb-xs mt-xs mr-xs btn btn-success col-md-2 col-xs-12', 'type'=>'button', 'onclick'=>"AddNewline()"));?>
					</div>
					<div class="rangoprecios">
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
									
									foreach ($this->request->data['Detalle'] as $value) : ?>
										
										<tr class=<?php echo  'renglon'.$i; ?> >
											<?php
												echo $this->Form->hidden('Detalle.'.$i.'.proveedorfactura_id',array('label'=>false,'required'));
												echo $this->Form->hidden('Detalle.'.$i.'.id',array('label'=>false,'required'));
												echo '<td>'.$this->Form->hidden('Detalle.'.$i.'.producto_id',array('label'=>false,'required', 'renglon'=>$i)).'</td>';
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.codigo',array('label'=>false,'required', 'renglon'=>$i,'type'=>"text")).'</td>';
											 	echo '<td>'.$this->Form->input('Detalle.'.$i.'.nombre',array('label'=>false,'required', 'renglon'=>$i)).'</td>';
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.cantidad',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'min'=>0)).'</td>';
												echo '<td>'.$this->Form->input('Detalle.'.$i.'.precio',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'step'=>"any", 'min'=>0)).'</td>';
												echo '<td>'.$this->Form->button('<span class="glyphicon glyphicon-remove"></span>',array('label'=>false, 'type'=>"button", 'onClick'=>'DeleteRow('.$i.')','escape'=>false )).'</td>';
											?>
										</tr>
									 	
								<?php $i++; endforeach; 
								
								} /* FIN DEL IF PRECIOSPRODUCTO */
								
								?>
						
						</table>
						
						</div>
						

					</div>
			<div class="step-one">
				<legend>Detalle Final</legend>
			</div>
			<table class="table table-condensed total-result">
				<tr>
					<td>Compra Sub Total</td>
					<td><span>$ </span><span class="jq_totalfact"> <?php  echo '0'; ?></span>.-</td>
				</tr>
			    <tr class="shipping-cost">
					<td>Gasto de Envio</td>
					<td>Consultar</td>										
				</tr>
				<tr>
					<td>Total</td>
					<?php echo $this->Form->hidden('total', array('value'=>0)); ?>
					<td><span>$ </span><span class="jq_totalfact"><?php  echo '0' ; ?></span>.-</td>
				</tr>
			</table>
			<?php
			echo $this->Form->submit(__('Guardar Factura'),array('class'=>'mb-xs mt-xs mr-xs btn btn-primary'));
			echo $this->Form->end();
			?>
			 </div>
			</fieldset>
		</section>
	</div>
</section>
<script type="text/javascript">
var renglones = <?php echo (isset($this->request->data['Categoria']['Productosprecio']))? count($this->request->data['Categoria']['Productosprecio']): '0'; ?>


function DeleteRow(row){

	$('.renglon'+row).remove();
}

function Addrow(newrow){
    
	$('#tableprice > tbody').append("<tr class='renglon"+newrow+"'>"+'<td><div class="form-group"><input  class="form-control" name="data[Proveedordetalle]['+newrow+'][codigo]" required="required" renglon='+newrow+' step="any" id="Proveedordetalle'+newrow+'Codigo"/></div><input type="hidden" name="data[Proveedordetalle]['+newrow+'][producto_id]" required="required" id="Proveedordetalle'+newrow+'ProductoId"/><input type="hidden" name="data[Proveedordetalle]['+newrow+'][proveedorfactura_id]" required="required" id="Proveedordetalle'+newrow+'Proveedorfactura_id"/><td><div class="input text"><input class="form-control" name="data[Proveedordetalle]['+newrow+'][nombre]" required="required" renglon='+newrow+' maxlength="300" type="text" id="Proveedordetalle'+newrow+'Nombre"/></div></td><td><div class="form-group"><input  class="form-control" name="data[Proveedordetalle]['+newrow+'][cantidad]" required="required" renglon='+newrow+' min="0" type="number" id="Proveedordetalle'+newrow+'Cantidad"/></div></td><td><div class="form-group"><input name="data[Proveedordetalle]['+newrow+'][precio]" class="form-control" required="required" renglon='+newrow+' min="0" step="any" type="number" id="Proveedordetalle'+newrow+'Precio"/></div></td>'+'<td><button type="button" onClick="DeleteRow('+newrow+')"><span class="glyphicon glyphicon-remove"></span></button></td>'+"</tr>");

}

function AddNewline(){
	 var newrow = renglones;
	 renglones = renglones+1;
	 Addrow(newrow);
}

var options = {

    url: '<?php echo $this->Html->url(array("controller" => "proveedorfacturas", "action" => "listjson" ));?>',

    getValue: function(element) {
        return element.nombre;
    },

    list: {
        onChooseEvent: function() {
            
            var selectedItemValue ='';
            console.log($("#inputOne").getSelectedItemData().id);
            var newrow = renglones;
			renglones = renglones+1;
			

			Addrow(newrow);
			
			$('#Proveedordetalle'+newrow+'ProductoId').val( $("#inputOne").getSelectedItemData().id);
			$('#Proveedordetalle'+newrow+'Codigo').val( $("#inputOne").getSelectedItemData().codigo);
			$('#Proveedordetalle'+newrow+'Precio').val(0);
			$('#Proveedordetalle'+newrow+'Nombre').val( $("#inputOne").getSelectedItemData().nombre);
			$('#Proveedordetalle'+newrow+'Cantidad').val(1);
            
        },
        onHideListEvent: function() {
        	$("#inputOne").val("").trigger("change");
    	}
    }
};

$("#inputOne").easyAutocomplete(options);

// SUma Totales 
$('body').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
</script>
<style type="text/css">
.easy-autocomplete input{
	float: left;
}
#ProveedorfacturaFechaMonth, #ProveedorfacturaFechaDay, #ProveedorfacturaFechaYear{
	width: 32%;
	float:left;
}
label[for="ProveedorfacturaFechaDay"]{
	display: block;
}
</style>