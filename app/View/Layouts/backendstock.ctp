<!DOCTYPE html>
<html class="fixed sidebar-left-collapsed" lang="en">
  <head>
	<title>
		<?php echo 'Despositos Bancarios'; ?>
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

    echo $this->Html->script(array('vendor/jquery/jquery','vendor/jquery-browser-mobile/jquery.browser.mobile','vendor/bootstrap/js/bootstrap','vendor/nanoscroller/nanoscroller','vendor/bootstrap-datepicker/js/bootstrap-datepicker','vendor/magnific-popup/magnific-popup','vendor/jquery-placeholder/jquery.placeholder','vendor/jquery-ui/js/jquery-ui-1.10.4.custom', 'vendor/flot1/jquery.flot.min','vendor/flot1/jquery.flot.categories.min'));
    

	?>
 
  </head>

  <body>
	
	<section class="body">
	
		<?php //echo $this->Element('navigation'); ?>
              
        <!-- start: header -->
          <?php echo $this->Element('backend/headertransporte'); ?>
        <!-- end: header -->
      


        <div class="inner-wrapper">
          <!-- start sidebar -->
          <?php echo $this->Element('backend/menustock'); ?>
          <!-- end: sidebar -->

    			
          
          <!-- start content -->
          <section role="main" class="content-body">
            <?php echo $this->Session->flash(); ?>
            <?php 	
	
			
	?>
    		  	<?php echo $this->fetch('content'); ?>
    	  </section>
    	    
        </div>
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
