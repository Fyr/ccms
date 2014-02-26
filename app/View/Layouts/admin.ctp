<!DOCTYPE html>
<html>
<head>
	<?=$this->Html->charset(); ?>
	<title><?=$title_for_layout; ?></title>
<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css(array('bootstrap.min', 'jquery-ui-1.10.3.custom', 'admin', 'table'));
	$aScripts = array(
		'jquery-1.10.2.min',
		'jquery.cookie',
		'jquery-ui-1.10.3.custom.min',
		'bootstrap.min',
		'meiomask',
		'admin',
		'grid'
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
	<nav class="navbar nav-pills">
		<div class="navbar-inner">
			<?=$this->element('admin_menu')?>
			<?=$this->element('admin_curruser')?>
			<?=$this->element('admin_shortcuts')?>
		</div>
	</nav>
</header>
<main>
	<!--aside>
		<?=$this->element('admin_sb')?>
	</aside-->
	<section class="table-column container-fluid">
		<div class="row-fluid">
			<?=$this->Session->flash()?>
    		<?=$this->fetch('content')?>
    	</div>
    </section>
</main>
<footer class="text-center">
	<?=$this->element('admin_footer')?>
</footer>
</div>
<?//=$this->element('sql_dump'); ?>
</body>
</html>
