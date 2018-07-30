<header class="page-header">
	<h2><?php echo $titleheader; ?></h2>

	<div class="right-wrapper pull-right">
		<ol class="breadcrumbs">
			<li>
				<?php echo $this->Html->link('<i class="fa fa-home"></i>', array('controller'=>'Users','action'=>'dashboard'),array('escape'=>false));?>
				
			</li>
			<li><span><?php echo $shorturl; ?></span></li>
		</ol>

		<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
	</div>
</header>