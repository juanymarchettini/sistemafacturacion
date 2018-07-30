<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		
				<meta charset="utf-8">
				<title>Tienda Overall - Distribuidor Oficial Saphirus </title>
				<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				<meta name="language" content="es" />
				<meta name="Title" content="Overall - Distribuidor Oficial Saphirus Bahía Blanca">
				<meta name="Description" content="Tienda Overall  Distribuidor Oficial de productos Saphirus Bahía Blanca: aromatizadores,  pigiflux, difusores de bambu, perfumes, jabones liquidos, para   Bahía Blanca, Rio Negro y le resto del sur argentino" />
				<meta name="Keywords" content="aromatizante, fragancia, repuesto, saphirus, onix, arome fin, luxury, new scent, sweet sensation, aromas, make fresh, urban fresh, mate sabio, mate santo, sommeil, fragancias importadas, nd aromas, fragancias masculinas ,
fragancias femeninas, pilas, energizer, eveready, duracell, autoaroma, pigiflux, bodysplash, distribuidor , mayorista, por mayor, jabon liquido, ap, milano cosmetics,  jabon liquido, termo, sommeil , difusor bambu, aromatizante de ambientes, fragancias, bahía blanca, río negro, ALLEN ,ALPACHIRI,AZUL, BAHÍA BLANCA, BAHIA SAN BLAS, CALETA OLIVIA ,CARMEN DE PATAGONES ,CENTENARIO, CHOELE CHOEL, CINCO SALTOS,  CIPOLLETTI, OMODORO RIVADAVIA, CORONEL DORREGO, CORONEL PRINGLES, CORONEL SUAREZ, CUTRAL-CO ,EDUARDO CASTEX, GRAL ACHA ,GRAL CERRI, GRAL CONESA ,GRAL ENRIQUE GODOY, GRAL LAMADRID, GRAL PICO, GRAL ROCA, HUANGUELEN, JACINTO ARAUZ, LAS HERAS, MENDOZA, LAS HERAS, SANTA CRUZ, MEDANOS, NECOCHEA, NEUQUEN, PICO TRUNCADO ,PIGÜÉ, PLOTTIER, PUERTO DESEADO, PUERTO MADRYN, PUNTA ALTA, RIO COLORADO, SAN ANTONIO OESTE, SAN MARTIN DE LOS ANDES,  SANTA ROSA ,STROEDERTOAY, TRELEW ,TRES ARROYOS, USHUAIA,VIEDMA,VILLA REGINA" />
		<title>
			
			<?php echo $this->fetch('title'); ?>
		</title>
		
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!-- Favicons
	    ================================================== -->
	    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
	    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
	    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
	    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
	    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">
		<?php
			echo $this->Html->meta('icon');
  
			echo $this->Html->css(array('homenuevo/bootstrap','homenuevo/owl.carousel'  ,'homenuevo/owl.theme','homenuevo/style','homenuevo/responsive'));
			echo $this->Html->script(array('homenuevo/modernizr.custom'));

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>

	<body>
		    <!-- Navigation
		    ==========================================-->
		    <nav id="tf-menu" class="navbar navbar-default navbar-fixed-top">
		      <div class="container">
		        <!-- Brand and toggle get grouped for better mobile display -->
		        <div class="navbar-header">
		          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </button>
		         <img class="img-responsive" src="https://www.tiendaoverall.com.ar/img/logo-overall.png" style="max-width: 250px; margin-top: -20px;">
		        </div>

		        <!-- Collect the nav links, forms, and other content for toggling -->
		        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		          <ul class="nav navbar-nav navbar-right">
		            <li><a href="#tf-home" class="page-scroll">Inicio</a></li>
		            <li><a href="#tf-about" class="page-scroll">Nosotros</a></li>
		            <li><a href="#tf-team" class="page-scroll">Productos</a></li>
		            <li><a href="#tf-services" class="page-scroll">Como hago para ser Vendedor?</a></li>
		            <li><?php echo $this->Html->link('Seccion Revendedor', array('controller'=>'users','action'=>'ingreso'),array('rel'=>'nofollow','class'=>'external-link'));  ?></li>
		            <li><a href="#tf-contact" class="page-scroll">Contacto</a></li>
		          </ul>
		        </div><!-- /.navbar-collapse -->
		      </div><!-- /.container-fluid -->
		    </nav>

		    <!-- Home Page
		    ==========================================-->
		    <div id="tf-home" class="text-center">
		        <div class="overlay">
		            <div class="content">
		                <h1>Bienvenidos a <strong><span class="color">Tienda Overall</span></strong></h1>
		                <p class="lead">Somos Distribuidores <strong>Oficial Saphirus</strong> para toda la <strong>Argentina.</strong></p>
		                <a href="#tf-about" class="fa fa-angle-down page-scroll"></a>
		            </div>
		        </div>
		    </div>

		    <!-- About Us Page
		    ==========================================-->
		    <div id="tf-about">
		        <div class="container">
		            <div class="row">
		                <div class="col-md-6">
		                	 <?php echo  $this->Html->image('homenuevo/02.png',array('alt'=>'','class'=>'img-responsive')) ?>
		                    
		                </div>
		                <div class="col-md-6">
		                    <div class="about-text">
		                        <div class="section-title">
		                            <h4>Tienda Overall</h4>
		                            <h2>Acerca de <strong>Nosotros</strong></h2>
		                            <hr>
		                            <div class="clearfix"></div>
		                        </div>
		                        <p class="intro">Overall es una empresa argentina dedica a la distribución y venta de productos Saphirus, fragancias y sistemas que sirven para la aromatización ambiental. </p><p>Está formada por un grupo creativo multidisciplinario que apuestan a un producto atractivo y accesible a todas los sectores. El trabajo en equipo, la búsqueda de nuevos horizontes, las asociaciones de mutuo beneficio son los valores que rigen a esta compañía. Por estas razones, lo invitamos a contactarse con nosotros y conocer más sobre nosotros, nuestros productos y oportunidades de negocios que tenemos a su alcance.</p>
		                        
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>

		    <!-- Team Page
		    ==========================================-->
		    <div id="tf-team" class="text-center">
		        <div class="overlay">
		            <div class="container">
		                <div class="section-title center">
		                    <h2>Alguno de <strong>Nuestros Productos</strong></h2>
		                    <div class="line">
		                        <hr>
		                    </div>
		                </div>

		                <div id="team" class="owl-carousel owl-theme row">
		                    <div class="item">
		                        <div class="thumbnail">
		                            <?php echo  $this->Html->link($this->Html->image('homenuevo/team/01.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            
		                            <div class="caption">
		                                <h3>Saphirus</h3>
		                                <p>Distribuidores Oficiales</p>
		                                <p>Contamos con la distribución de la linea completa de Saphirus</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                             <?php echo  $this->Html->link($this->Html->image('homenuevo/team/02.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Milano Cosmetic</h3>
		                                <p>Distribuidores Oficiales</p>
		                                <p>Linea Completa de la Marca Milano Cosmetic</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                             <?php echo  $this->Html->link($this->Html->image('homenuevo/team/03.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Energizer</h3>
		                                <p>Contamos con gran variedad de Pilas Energizer</p>
		                               
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                             <?php echo  $this->Html->link($this->Html->image('homenuevo/team/04.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Juca</h3>
		                                <p>Distribuidor Oficial</p>
		                                <p>Contamos con la linea completa de Juca Regalos personalizables.</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                             <?php echo  $this->Html->link($this->Html->image('homenuevo/team/05.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Lamparas de Sal</h3>
		                                <p>Distribuidor</p>
		                                <p>Gran variedad de Lamparas de Sal</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                            <?php echo  $this->Html->link($this->Html->image('homenuevo/team/06.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Regalería</h3>
		                                <p>Distribuidor</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                            <?php echo  $this->Html->link($this->Html->image('homenuevo/team/07.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Mate Sabio</h3>
		                                <p>Distribuidor/p>
		                                <p>Distribuidor de toda la linea Mate Sabio</p>
		                            </div>
		                        </div>
		                    </div>

		                    <div class="item">
		                        <div class="thumbnail">
		                             <?php echo  $this->Html->link($this->Html->image('homenuevo/team/08.jpg',array('alt'=>'','class'=>'img-circle team-img')),array('controller'=>'Categorias','action'=>'home'),array('escape'=>false)); ?>
		                            <div class="caption">
		                                <h3>Perfumes Sommeil</h3>
		                                <p>Distribuidor</p>
		                               
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                
		            </div>
		        </div>
		    </div>

		    <!-- Services Section
		    ==========================================-->
		    <div id="tf-services" class="text-center">
		        <div class="container">
		            <div class="section-title center">
		                <h2>Como hago para <strong>ser Vendedor?</strong></h2>
		                <div class="line">
		                    <hr>
		                </div>
		                <div class="clearfix"></div>
		                <spam style="font-size:15px;"><em>Para comercializar  los productos lo único que tenes que hacer es realizar una compra superior a <b> $2000 </b>. Más grande es la inversión mejor precio vas a conseguir en los productos. </br> 
						<p>Para descargar la lista de precios hacer click en el siguiente link:  <strong> <a href=" https://tiendaoverall.com.ar/informes/generarplanillaprecios">Click Para Descargar </a> </strong>
						</p>
						<p>
							Todos los productos podes verlos en nuestro catalogo on line. También Podes compartir el catalogo con tus amigos y clientes para que conozcan todos los productos que tenemos  para  ofrecerles, simplemente enviando la pagina <strong> <a href=" http://www.overshop.com.ar" target="_blank">OVERSHOP.COM.AR </a> </strong> 
						</p>
						<p>
					Podes pagar el pedido por deposito bancario, contrarembolso (cuando lo recibís en tu domicilio) o realizar el pago previamente por con tarjeta de crédito, de este modo se cobra un 6% de recargo sobre el total del pedido
					</p>
					<p>Para realizar el pedido hay que ingresar en <a href="https://www.tiendaoverall.com.ar">www.tiendaoverall.com.ar </a> </br>
					<b> 1)> Sección revendedores</b>
					<b> 2)> Ingresa o registrarte</b>
					<b> 3)> Arma tu pedido on line</b> </br>
					Los precios se ajustan automáticamente a la cantidad pedida y debajo calcula el precio.
					</p>
					<div id="videoyoutube" style="max-width:99%; margin-top:20px;">
					<iframe src="https://www.youtube.com/embed/0aIAjy1zd30" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
					</em></spam>
		            </div>
		            <div class="space"></div>
		            <div>
		            	<h2>Escribenos por <strong>Whatsapp ! </strong></h2>
		            	<div class="clearfix"></div>
		            	<?php echo $this->Html->link($this->Html->image('whatsapp.png',array('class'=>'img-responsive','style'=>'margin:0 auto;')),'https://api.whatsapp.com/send?phone=542916451450',array('escape'=>false,'target'=>'_blank')); ?> 
		            </div>
		        </div>
		    </div>

		    <!-- Clients Section
		    ==========================================-->
		    <div id="tf-clients" class="text-center">
		        <div class="overlay">
		            <div class="container">

		                <div class="section-title center">
		                    <h2>Sumate <strong>y se Revendedor</strong></h2>
		                    <div class="line">
		                        <hr>
		                    </div>
		                </div>
		                <div id="clients" class="owl-carousel owl-theme">
		                    <div class="item">
		                        <?php echo $this->Html->image('homenuevo/cliente/01.png'); ?>
		                       
		                    </div>
		                    <div class="item">
		                       <?php echo $this->Html->image('homenuevo/cliente/02.png'); ?>
		                    </div>
		                    <div class="item">
		                        <?php echo $this->Html->image('homenuevo/cliente/03.png'); ?>
		                    </div>
		                    <div class="item">
		                        <?php echo $this->Html->image('homenuevo/cliente/04.png'); ?>
		                    </div>
		                    <div class="item">
		                        <?php echo $this->Html->image('homenuevo/cliente/05.png'); ?>
		                    </div>
		                   
		                </div>

		            </div>
		        </div>
		    </div>

			<!-- Contact Section
		    ==========================================-->
		    <div id="tf-contact" class="text-center">
		        <div class="container">

		            <div class="row">
		                <div class="col-md-8 col-md-offset-2">

		                    <div class="section-title center">
		                        <h2> No dudes en  <strong>Contactarnos</strong></h2>
		                        <div class="line">
		                            <hr>
		                        </div>
		                        <div class="clearfix"></div>
		                        <small><em>Nuestros Horarios de Anteción son de Lunes a Viernes de 8Hs a 12.30hs y de 14hs a 17hs.</em></br>
								Tel: <b>291 -156451450</b> - Email: <b>overallbb@hotmail.com </b>
								</small>            
		                    </div>

		                    <?php echo $this->Form->create('Categoria', array('action'=>'contactenos')); ?>
		                        <div class="row">
		                            <div class="form-group">
			                        	<?php echo $this->Form->input('nombre',array('label'=>false, 'class'=>"form-control", 'placeholder'=>"Ingrese su nombre", 'maxlength'=>"40", 'required'=>'required')); ?>
			                            
			                        </div>
			                        <div class="form-group">
			                        	<?php echo $this->Form->input('email',array('label'=>false, 'class'=>"form-control", 'placeholder'=>"Ingrese su Email", 'maxlength'=>"60", 'required'=>'required' )); ?>
			                           
			                        </div>
			                        <div class="form-group">
			                        	<?php echo $this->Form->input('localidad',array('label'=>false, 'class'=>"form-control", 'placeholder'=>"Ingrese su Ciudad", 'maxlength'=>"60", 'required'=>'required' )); ?>
			                           
			                        </div>
			                        <div class="form-group">
			                        	<?php echo $this->Form->input('tel',array('label'=>false, 'class'=>"form-control", 'placeholder'=>"Ingrese su Telefono", 'maxlength'=>"60", 'required'=>'required' )); ?>
			                           
			                        </div>
			                        <div class="form-group">
			                        	<?php echo $this->Form->hidden('asunto',array('label'=>false, 'class'=>"form-control", 'value'=>"Consulta desde la Web" )); ?>
			                        	
			                          
			                        </div>
		                        </div>
		                        <div class="form-group">
		                           <?php echo $this->Form->input('mensaje',array('label'=>false,'type'=>'textarea' ,'class'=>"form-control", 'placeholder'=>"Mensaje", 'height'=>"130px;" , 'required'=>'required')); ?>
		                        </div>
		                        
		                        <button type="submit" class="btn tf-btn btn-default">Enviar</button>
		                    </form>

		                </div>
		            </div>

		        </div>
		    </div>

		    <nav id="footer">
		        <div class="container">
		            <div class="pull-left fnav">
		                <p>ALL RIGHTS RESERVED  TIENDA OVERALL. COPYRIGHT © 2018. Deseñada y Programada por <a href="https://www.netzone.com.ar">Netzone.com.ar</a> </p>
		            </div>
		            <div class="pull-right fnav">
		                <ul class="footer-social">
		                    <li><a href="https://www.facebook.com/overallbb/"><i class="fa fa-facebook"></i></a></li>
		                   
		                </ul>
		            </div>
		        </div>
		    </nav>

		
	 
		<script type="text/javascript">
		<?php $mensajes=$this->Session->flash(); if ( (!empty($mensajes))){echo 'alert('.$this->Session->flash().');';}?>
		</script>
		    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<?php 

		echo $this->Html->script(array('homenuevo/jquery.1.11.1','homenuevo/bootstrap','homenuevo/SmoothScroll','homenuevo/jquery.isotope','homenuevo/owl.carousel','homenuevo/main'));
		?>

		<style>
		#videoyoutube iframe{
			width:100%;
			min-height:360px;
		}
		</style>
	</body>
</html>




