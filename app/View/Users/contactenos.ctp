<section>
	<div class="container">
		<div class="row">	
			<section id="form" style="margin-top:40px;"><!--form-->
				<div class="panel panel-primary" style="  background-color: #d9edf7; border-color: #d9edf7; border-radius:30px; padding-bottom:30px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-10 col-sm-offset-1">
										<div class="text-center"> 
											<?php echo $this->Session->flash('bad'); ?> 
											<?php echo $this->Session->flash('good'); ?> 
										</div>
							</div>	
							<div class="col-sm-9 col-sm-offset-1">
								<div class="signup-form"><!--sign up form-->
									<h1><span style="color: #146CB3;">Contactenos!</span></h1>
									
									</br>
									<?php
										echo $this->Form->create('User', array('action'=>'contactenos')); 
										    echo $this->Form->input('nombre', array('label'=>'Nombre', 'required'));
										    echo $this->Form->input('apellido', array('label'=>'Apellido', 'required'));
										    echo $this->Form->input('email', array('label'=>'Email', 'required'));
										    echo $this->Form->input('telefono', array('label'=>'Telefono de Contacto'));
										    echo $this->Form->input('localidad', array('label'=>'Localidad'));
										    echo $this->Form->input('direccion', array('label'=>'Dirección'));
										    echo $this->Form->input('consulta', array('label'=>'Consulta', 'type'=>'textarea'));

											echo $this->Form->button('Enviar Consulta!', array('class'=>'btn btn-default')); 
										echo $this->Form->End();

									?>
									
								</div><!--/sign up form-->
							</div>
						</div>
					</div>
				</div>
			</section><!--/form-->
		</div>
	</div>
</section>
<style type="text/css">
#UserConsulta{
  background-color: #fff;
  margin-bottom: 20px;
}
</style>