$(document).ready(function(){
	
	//IMPORTANTEEEE!!! AGREGAR SIEMPRE ESTA LINEA EN EL LAYOUT PARA PODER OBTENER LA URL BASE DE LA WEB

	/*var baseUrlnuevoitem = '<?php echo $this->Html->url(array(
    "controller" => "facturas",
    "action" => "sumar_carro" ));?>'; y baserURLdeleteitem!!*/


	
	$(document).on('click', '.jq_sumar_item_carro', function(){
		
		var id = $(this).attr('item-id');
		var cantidad = $("#cantidad_nro").val();
		

		$.ajax({
	        data: {id: id,cantidad:cantidad},
	        url:   baseUrlnuevoitem,
	        type:  'post',
	        async: false,
	        success:  function (response2) {
	        	var response = JSON.parse(response2);
	        	
	        	if (response.mensaje=='OK'){
	        		$("#jq_addok").toggle();
	        		$("#jq_Cartcant").html(response.cantidad);
	        		$('#css_cartcant').css('color','orange');
					$('css_cartcant').css('font-weight','bold');

	        	}
	        	else if(response.mensaje=='EXISTE'){
	        		$("#jq_addok").toggle();
	        	}
	        	else{
	        		$("#jq_adderror").toggle();
	        		
	        	}
	        }
		});
	});

	
});