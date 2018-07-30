<?php echo $this->Element('backend/headerpage',array('titleheader'=>$titulo,'shorturl'=>'Lista de Pedidos')); ?>
<div id="ajaxlistafactpaginate">
	<section class="panel panel-featured panel-featured-info">
		<header class='panel-heading'>
			<h2 class="panel-title"><?php echo $titulo; ?></h2>
		</header>
		<div class="col-xs-12 col-md-4 " style="margin-top:10px; margin-bottom:10px;">
			<div action="#" class="search nav-form ">
		        <div class="input-group input-search">
		          <?php echo $this->Form->input('searchfact',array('label'=>false, 'class'=>"form-control" ,'placeholder'=>'Buscar factura')); ?>
		          
		          <span class="input-group-btn">
		          	<?php echo $this->Form->button('<i class="fa fa-search"></i>',array('id'=>'ajaxbuscar', 'class'=>"btn btn-default", 'type'=>'button'), array('escape'=>false)); ?>
		           
		          </span>
		        </div>
		     </div>
	    </div>
	    <div id='ajaxlistafact'>
			<?php echo $this->element('backend/facturas/lista'); ?>
		</div>
	</section>
</div>

<script>
$("#searchfact").keypress(function(e) {
       if(e.which == 13) {
            var buscar=$('#searchfact').val();
			if (buscar.length ==0 ){
				alert('Campo de Busqueda Vacio');
			}else{
				$.ajax({
	  				method: "POST",
	 			    url: '<?php echo $this->Html->url(array(
	   								"controller" => "facturas",
	    							"action" => "ajaxsearchpedido" ));?>',
	  				data: { busqueda: buscar },
	  				dataType: "html",
					
	  				success:  function (response) {
		        	
		        	 $('#ajaxlistafact').html(response)
		        	
		       		}
	  		    });

			}
       }
});


$('#ajaxbuscar').click(function(){

		var buscar=$('#searchfact').val();

		if (buscar.length ==0 ){
			alert('Campo de Busqueda Vacio');
		}else{

			
			$.ajax({
  				method: "POST",
 			    url: '<?php echo $this->Html->url(array(
   								"controller" => "facturas",
    							"action" => "ajaxsearchpedido" ));?>',
  				data: { busqueda: buscar },
  				dataType: "html",
				
  				success:  function (response) {
	        	
	        	 $('#ajaxlistafact').html(response)
	        	
	       		}
  		    });

		}


});

$('body').on('click','.paging a' , function(event){
 event.preventDefault();
 var link= $(this).attr('href');
 $.ajax({
		method: "POST",
    	url: link,
		dataType: "html",
		success:  function (response) {
 		$('#ajaxlistafact').html(response)

		}
 });


});
</script>

<style type="text/css">
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
</style>
