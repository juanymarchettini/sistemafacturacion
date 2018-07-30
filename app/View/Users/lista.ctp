
<?php echo $this->Element('backend/headerpage',array('titleheader'=>'Clientes','shorturl'=>'Clientes - Password')); ?>
<section class="panel panel-featured panel-featured-info">
	<header class='panel-heading'>
		<h2 class="panel-title">Clientes - Total: <?php echo $contadorusaurios;?></h2>
	</header>
	<div class="panel-body">
		<?php
			echo $this->Form->create('User', array());
		?>
	    <div class="col-xs-12 col-md-6">
			<label class="col-md-12 control-label">Fecha Registro de Usuario</label>			
			<div class="input-daterange input-group" data-plugin-datepicker>
				<span class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</span>
				<input type="text" class="form-control" name="data[User][start]">
				<span class="input-group-addon">Hasta</span>
				<input type="text" class="form-control" name="data[User][end]">
			</div>
		</div>
		<div class="col-md-6 col-xs-12">
	        <div class="input-group input-search" style="padding-top:30px;">
	           <?php echo $this->Form->input('searchuser',array('label'=>false, 'class'=>"form-control" ,'placeholder'=>'Buscar Cliente')); ?>
	          
	          <span class="input-group-btn">
	          	
	          	<?php echo $this->Form->button('<i class="fa fa-search"></i>',array('id'=>'ajaxbuscar','class'=>"btn btn-default", 'type'=>'button'), array('escape'=>false)); ?>
	           
	          </span>
	        </div>
	    </div>
	    <div class="col-md-12">
	    	<?php echo $this->Form->button('Buscar',array('id'=>'ajaxbuscar','class'=>"btn btn-default", 'type'=>'submit'), array('escape'=>false)); ?>
	    </div>
		<div class="input-group input-search" style="padding-top:10px;">
				         
						
		</div>
		<section  class="col-md-12">
	
			<div class="table-responsive" id='ajaxusuarios'>
				<table class="table table-hover">
					<tr>
							<th><?php echo $this->Paginator->sort('id','Nro Cliente'); ?></th>
							<th><?php echo $this->Paginator->sort('username','Usuario'); ?></th>
							<th><?php echo $this->Paginator->sort('nombre','Nombre.'); ?></th>
							<th><?php echo $this->Paginator->sort('apellido','Apellido'); ?></th>
							<th><?php echo $this->Paginator->sort('telefono','Telefono'); ?></th>
							<th><?php echo $this->Paginator->sort('role','Rol'); ?></th>
							<th class="actions"><?php echo __('Password'); ?></th>
							<th class="actions"><?php echo __('Ver Cuenta'); ?></th>
							
					</tr>
					<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['nombre']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['apellido']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['telefono']); ?>&nbsp;</td>
						<td><?php echo h($user['User']['role']); ?>&nbsp;</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="fa fa-key">Cambiar</span>', array('action' => 'editarpass', $user['User']['id']),array('escape'=>false)); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link('<span class="fa fa-money ">Ver cuenta</span>', array('controller'=>'facturas','action' => 'listaporclientes', $user['User']['id']),array('escape'=>false)); ?>
						</td>
						
					</tr>
					<?php endforeach; ?>
				</table>

				<?php
						
                        echo $this->Paginator->counter(array(
                        'format' => __('Página {:page} de {:pages}')
                        ));
                        ?>  </p>
                        <div class="paging pagination">
                            <?php

                                $this->Paginator->options(array('url' => $this->passedArgs));
                                echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled'));
                                echo $this->Paginator->numbers(array('separator' => ''));
                                echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled'));
                            ?>
                        </div>

			</div>
		</section>
	</div>
</section>

<script>
$('#ajaxbuscarBETA').click(function(){

		var buscar=$('#searchuser').val();

		if (buscar.length ==0 ){
			alert('Campo de Busqueda Vacio');
		}else{

			
			$.ajax({
  				method: "POST",
 			    url: '<?php echo $this->Html->url(array(
   								"controller" => "users",
    							"action" => "ajaxsearchcliente" ));?>',
  				data: { busqueda: buscar },
  				dataType: "html",
				
  				success:  function (response) {
	        	
	        	 $('#ajaxusuarios').html(response)
	        	
	       		}
  		    });

		}


});
</script>