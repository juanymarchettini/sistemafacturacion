
<div class="col-sm-12">
	 <?php echo $this->Form->create('Producto',array('action'=>'contacto','id'=>'contact-form'));?>
		<span>
	        <label>Nombre:</label>
	        	<?php echo $this->Form->hidden('idproducto',array('value'=>$producto['Producto']['id']));?>
	            <?php echo $this->Form->input('nombre',array('label'=>false,'div'=>false,'size'=>'30', 'required'));?>
	    </span> 
	    </br>    
	    <span>
		              
	        <label>Email:</label>
	       
	            <?php echo $this->Form->input('email',array('label'=>false,'div'=>false,'size'=>'30', 'required'));?>
	        
		</span>
		 </br>
		 <span>
	    	 <label>Asunto:</label>
	         
	            <?php echo $this->Form->input('asunto',array('label'=>false,'div'=>false,'readonly'=>'readonly','value'=>$producto['Producto']['codigo'].'-'.$producto['Producto']['nombre']));?>
	         
	     </span>
			 </br>
	    <label>Mensaje:</label>
	    <p>
	        <?php echo $this->Form->input('mensaje',array('label'=>false,'div'=>false,'type'=>'textarea', 'required'));?>
	    </p>
	    
	        <?php echo $this->Form->submit('Enviar',array('class'=>'btn btn-default pull-right','label'=>false,'div'=>false,'id'=>'submit'));?>
	 <?php echo $this->Form->end();?>
  
</div>