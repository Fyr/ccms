<form class="form-signin" action="" method="post">
	<div align="center">
		<h2 class="form-signin-heading"><?php echo DOMAIN_TITLE?> Admin</h2>
	</div>
<?php
	$error = $this->Session->flash('auth');
	if ($error) {
?>
	<div class="alert alert-error"><?php echo $error?></div>
<?php
	}
	echo $this->Form->input('User.username', array('class' => 'input-block-level', 'placeholder' => __('User name')));
	echo $this->Form->input('User.password', array('class' => 'input-block-level', 'placeholder' => __('Password')));
?>
	<label class="checkbox">
		<input type="checkbox" value="remember-me"> <?php echo __('Remember me');?>
	</label>
	<button class="btn btn-large btn-primary" type="submit"><?php echo __('Login');?></button>
</form>