<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Categorias','shorturl'=>'Lista de Categorias')); ?>



<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Lista de Categorias</h2>
	</header>
	<div class="col-xs-12 col-md-4 " style="margin-top:10px; margin-bottom:10px;">
		<div action="#" class="search nav-form ">
	        <div class="input-group input-search">
	          <?php echo $this->Form->input('searchprod',array('label'=>false, 'class'=>"form-control" ,'placeholder'=>'Buscar Categoria')); ?>
	          
	          <span class="input-group-btn">
	          	<?php echo $this->Form->button('<i class="fa fa-search"></i>',array('id'=>'ajaxbuscar', 'class'=>"btn btn-default", 'type'=>'button'), array('escape'=>false)); ?>
	           
	          </span>
	        </div>
	     </div>
    </div>
	<div id='ajaxlistaprod'>
		<div class="panel-body">
			<section  class="col-md-12">
				<div class="table-responsive">
					<table class="table table-hover">

						<tr>

							<th><?php echo 'Nro.'; ?></th>
							<th><?php echo 'Título'; ?></th>
							<th><?php echo 'Subcategoria'; ?></th>
							
							<th class="actions" tyle="text-align:center;"><?php echo __('Editar'); ?></th>
							<th class="actions" tyle="text-align:center;"><?php echo __('Eliminar'); ?></th>
								
						</tr> 
						<?php foreach ($categorias as  $id=>$categoria): ?>
								<tr>
									<td><?php echo h($id); ?>&nbsp;</td>
									<td><?php
									
										if (strrpos($categoria,'_') === false){
											 echo $categoria;
										}
										?> &nbsp;</td>
									<td> 
										<?php 
										if (strrpos($categoria,'_') >=-1){
											 echo $categoria;
										}
										?>
									</td>
									<td class="actions">
										<?php echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array('action' => 'edit', $id),array('escape'=>false)); ?>
									</td>
									<td class="actions">
										<?php echo $this->Form->postLink('<span class="glyphicon glyphicon-remove"></span>', array('action' => 'delete', $id), array('escape'=>false), __('¿Estás seguro que deseas eliminar %s?', $categoria)); ?>
									</td>
								</tr>
						<?php endforeach; ?>
					</table>
						
				</div>
			</section>

			
		</div>
	</div>
	
</section>
<script type="text/javascript">
$("#searchprod").keypress(function(e) {
       if(e.which == 13) {
            var buscar=$('#searchprod').val();
			if (buscar.length ==0 ){
				alert('Campo de Busqueda Vacio');
			}else{
				$.ajax({
	  				method: "POST",
	 			    url: '<?php echo $this->Html->url(array(
	   								"controller" => "categorias",
	    							"action" => "ajaxsearchcategoria" ));?>',
	  				data: { busqueda: buscar },
	  				dataType: "html",
					
	  				success:  function (response) {
		        	
		        	 $('#ajaxlistaprod').html(response)
		        	
		       		}
	  		    });

			}
       }
});

</script>