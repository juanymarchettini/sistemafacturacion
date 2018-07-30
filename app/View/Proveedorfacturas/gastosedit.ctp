<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Facturas Proveedores','shorturl'=>'Proveedores FAct')); ?>
<?php
    echo $this->Form->create('Proveedorfactura', array(
    'type'=>'file',
    'action'=>'gastosedit',
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
		<h2 class="panel-title"><?php echo 'Sección Gastos'; ?></h2>
	</header>
	<div class="panel-body">
		<section  class="col-md-12">
			<fieldset>
				<legend><?php echo __('Datos Factura'); ?></legend>
				<div class="row">
				<?php
					echo $this->Form->hidden('id', array('class'=>'col-md-6'));
					echo $this->Form->input('proveedore_id',array('label'=>'Nombre del Proveedor','options'=>$listaproveedores,'div'=>'col-md-4','required','empty'=>'Seleccione Proveedor'));
					echo $this->Form->input('nrofact',array('label'=>'Nrofact','div'=>'col-md-4'));
					echo $this->Form->input('fecha',array('label'=>'Fecha Fact.','separator'=>'','type'=>'date','div'=>'col-md-4','dateFormat'=>'DMY','monthNames' => false,'maxYear' => date('Y')+1,'minYear' => date('Y')-1 ));
					echo $this->Form->input('nota',array('label'=>'Nota','div'=>'col-md-5'));
					echo $this->Form->input('archivo',array('label'=>'Adjuntar Archivo','div'=>'col-md-5','type'=>'file'));
					echo $this->Form->hidden('user_id',array('value'=>$userid));
					echo $this->Form->hidden('esgasto',array('value'=>1));
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
								
							    if (isset($this->request->data['Proveedordetalle'])){
									$i=0; 
									
									foreach ($this->request->data['Proveedordetalle'] as $value) : ?>
										
										<tr class=<?php echo  'renglon'.$i; ?> >
											<?php
												echo $this->Form->hidden('Proveedordetalle.'.$i.'.proveedorfactura_id',array('label'=>false,'required'));
												echo $this->Form->hidden('Proveedordetalle.'.$i.'.id',array('label'=>false,'required'));
												echo $this->Form->hidden('Proveedordetalle.'.$i.'.producto_id',array('label'=>false,'required', 'renglon'=>$i));
											 	echo '<td>'.$this->Form->input('Proveedordetalle.'.$i.'.codigo',array('label'=>false,'required', 'renglon'=>$i,'type'=>"text")).'</td>';
											 	echo '<td>'.$this->Form->input('Proveedordetalle.'.$i.'.nombre',array('label'=>false,'required', 'renglon'=>$i)).'</td>';
												echo '<td>'.$this->Form->input('Proveedordetalle.'.$i.'.cantidad',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'min'=>0)).'</td>';
												echo '<td>'.$this->Form->input('Proveedordetalle.'.$i.'.precio',array('label'=>false,'required', 'renglon'=>$i,'type'=>"number", 'step'=>"any", 'min'=>0)).'</td>';
												echo '<td>'.$this->Form->button('<span class="glyphicon glyphicon-remove"></span>',array('label'=>false, 'type'=>"button", 'onClick'=>'DeleteRow('.$i.')','escape'=>false )).'</td>';
											?>
										</tr>
									 	
								<?php $i++; endforeach; 
								
								} /* FIN DEL IF PRECIOSPRODUCTO */
								
								?>
						
						</table>
						
						</div>
						

					</div>
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
var renglones = <?php echo (isset($this->request->data['Proveedordetalle']))? count($this->request->data['Proveedordetalle']): '0'; ?>


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

