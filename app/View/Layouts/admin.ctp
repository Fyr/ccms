<!DOCTYPE html>
<html>
<head>
	<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
	<?=$this->Html->charset(); ?>
	<title><?=$title_for_layout; ?></title>
<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css(array('bootstrap.min', 'bootstrap-responsive.min', 'jquery-ui-1.10.3.custom', 'admin'));
	$aScripts = array(
		'vendor/jquery/jquery-1.10.2.min',
		'vendor/jquery/jquery.cookie',
		'vendor/jquery/jquery-ui-1.10.3.custom.min',
		'vendor/bootstrap.min',
		'vendor/meiomask',
		'admin',
	);
	echo $this->Html->script($aScripts);

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
?>
</head>
<body class="admin">
<div class="container-fluid">
<header>
	<nav class="navbar nav-pills navbar-fixed-top">
		<div class="navbar-inner">
			<?=$this->element('/UI/admin_menu')?>
			<?=$this->element('/UI/admin_curruser')?>
			<?=$this->element('/UI/admin_shortcuts')?>
		</div>
	</nav>
</header>
<main>
	<!--aside>
		<?=$this->element('/UI/admin_sb')?>
	</aside-->
	<section class="table-column container-fluid">
		<div class="row-fluid">
			<div class="span12">
				<?=$this->Session->flash()?>
    			<?=$this->fetch('content')?>
    		</div>
    	</div>
    </section>
</main>
<footer class="text-center">
	<?=$this->element('/UI/admin_footer')?>
</footer>
</div>
<?// $this->element('sql_dump'); ?>
</body>
</html>
