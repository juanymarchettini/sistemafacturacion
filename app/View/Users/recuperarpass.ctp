<section>
	<div class="container">
		<div class="row">
			<div class="panel panel-primary" style="  background-color: #d9edf7; border-color: #d9edf7; border-radius:30px; padding-bottom:30px;">
				<div class="row">	
					<div class="col-sm-12 text-center">
						<?php echo $this->Html->link($this->Html->image('logo.png', array('width'=>'450px;','alt'=>'')), array('controller'=>'categorias', 'action'=>'home'), array('escape'=>false)); ?>
					</div>
				</div>
				<section id="form"><!--form-->

						<div class="container">
							<div class="row">
								<div class="col-sm-10 col-sm-offset-1">
									<div class="text-center"> 
										<?php echo $this->Session->flash('bad'); ?> 
										<?php echo $this->Session->flash('good'); ?> 
									</div>
								</div>	
								<div class="col-sm-8 col-sm-offset-2">
									<div class="login-form"><!--login form-->
												
										<h2 style="font-size: 24px;  font-weight: bold;  color: #146CB3; font-style: italic;">Recupere su Contraseña</h2>
										<p style="font-style: italic;"> Ingrese su nombre de usuario (email) y recibirá su nueva contraseña. </p>
										</br>
										<?php
											echo $this->Form->create('User', array('action'=>'recuperarpass')); 
										    echo $this->Form->input('email', array('label'=>false, 'placeholder'=>'Ingrese Su nombre de Usuario (Email)'));
											echo $this->Form->button('Enviar', array('type'=>'submit','class'=>'btn btn-default')); 
											echo $this->Form->end();



										?>
											
									</div><!--/login form-->
								</div>
								
							</div>
						</div>
				</section><!--/form-->
			</div>
		</div>
	</div>
</section>