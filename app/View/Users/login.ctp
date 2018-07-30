<!DOCTYPE html>
<html class="fixed" lang="en">
  <head>
	<title>
		<?php echo "Tienda Overall"; ?>
	</title>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
    // VENDOR CSS
    echo $this->Html->css(array('vendor/bootstrap/css/bootstrap','vendor/font-awesome/css/font-awesome','vendor/magnific-popup/magnific-popup.css','vendor/bootstrap-datepicker/css/datepicker3.css'));
    // Specific Page Vendor CSS 
    echo $this->Html->css(array("vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom","vendor/bootstrap-multiselect/bootstrap-multiselect","vendor/morris/morris" ));

    // Theme CSS
    echo $this->Html->css(array("theme/theme" ));
     // Skin CSS
    echo $this->Html->css(array("theme/skins/default" ));
    //   Theme Custom CSS
    echo $this->Html->css(array("theme/theme-custom" ));

    echo $this->Html->script(array('vendor/modernizr/modernizr'));

    echo $this->Html->script(array('vendor/jquery/jquery','vendor/jquery-browser-mobile/jquery.browser.mobile','vendor/bootstrap/js/bootstrap','vendor/nanoscroller/nanoscroller','vendor/bootstrap-datepicker/js/bootstrap-datepicker','vendor/magnific-popup/magnific-popup','vendor/jquery-placeholder/jquery.placeholder'));
    

	?>
 
  </head>

  <body>
    <section class="body">

        
    	<section class="body-sign">
			<div class="center-sign">
				<a href="#" class="logo pull-left">
					<?php echo $this->Html->image('logo.png',array('height'=>'60px', 'alt'=>'Porto Admin')); ?>
				</a>

				<div class="panel panel-sign">
					<div class="panel-title-sign mt-xl text-right">
						<h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
					</div>
					<div class="panel-body">
						<b style="text-align:center;"><?php echo $this->Session->flash(); ?></b>
						<?php echo $this->Form->create('User'); ?>
							
							<div class="form-group mb-lg">
								<label>Username</label>
								<div class="input-group input-group-icon">
									<?php 
						    			echo $this->Form->input('username', array('label'=>false, 'placeholder'=>"Username", 'div'=>false,'class'=>'form-control input-lg', 'required'=>true));  
						    		?>

									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="form-group mb-lg">
								<div class="clearfix">
									<label class="pull-left">Password</label>
									
								</div>
								<div class="input-group input-group-icon">
									<?php 
									    echo $this->Form->input('password', array('label'=>false, 'placeholder'=>"Password", 'div'=>false,'class'=>'form-control input-lg','required'=>true));
					            	?>
									
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-8">
									
								</div>
								<div class="col-sm-4 text-right">
									<?php echo $this->Form->Submit(__('Sign In'), array("class"=>"btn btn-primary hidden-xs")); ?>
									<?php echo $this->Form->Submit(__('Sign In'), array("class"=>"btn-primary btn-block btn-lg visible-xs mt-lg")); ?>
									
								</div>
							</div>

							

						<?php echo $this->Form->end(); ?>
					</div>
				</div>

				<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All Rights Reserved Overall.</p>
			</div>
		</section>
    </section>

    <!-- Vendor -->
    
  
    
    <!-- Theme Base, Components and Settings -->
   
    <?php
       echo $this->Html->script(array('theme/theme'));
    ?>
    <!-- Theme Custom -->
    <?php
       echo $this->Html->script(array('theme/theme.custom'));
    ?>
    <!-- Theme Initialization Files -->
     <?php
       echo $this->Html->script(array('theme/theme.init'));
    ?>

    <script type="text/javascript">
      // ESTA FUNCION DESHABILITA LA FUNCION BACKSPACE RETURN
      $(document).unbind('keydown').bind('keydown', function (event) {
          var doPrevent = false;
          if (event.keyCode === 8) {
              var d = event.srcElement || event.target;
              if ((d.tagName.toUpperCase() === 'INPUT' && 
                   (
                       d.type.toUpperCase() === 'TEXT' ||
                       d.type.toUpperCase() === 'PASSWORD' || 
                       d.type.toUpperCase() === 'FILE' || 
                       d.type.toUpperCase() === 'EMAIL' || 
                       d.type.toUpperCase() === 'SEARCH' || 
                       d.type.toUpperCase() === 'DATE' )
                   ) || 
                   d.tagName.toUpperCase() === 'TEXTAREA') {
                  doPrevent = d.readOnly || d.disabled;
              }
              else {
                  doPrevent = true;
              }
          }

          if (doPrevent) {
              event.preventDefault();
          }
      });
    
    </script>
  </body>
</html>