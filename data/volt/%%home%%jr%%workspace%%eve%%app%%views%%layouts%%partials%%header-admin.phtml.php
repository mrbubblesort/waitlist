<header class="header hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="logo">
                    <a href="<?php echo $this->url->get('') ?>">
                    	<img src="/images/icons/logo.png" />
                    </a>
                    <p>Admin page</p>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="text-right action clearfix">
                    <?php

if($this->session->get('auth') === NULL) {
	echo $this->tag->linkTo(array(
		'login',
		'Login',
		'class' => 'btn btn-lg btn-primary',
		'role' => 'button',
	));
	
	echo $this->tag->linkTo(array(
		'user/add',
		'Register',
		'class' => 'btn btn-lg btn-success pull-right margin-left-sm',
		'role' => 'button',
	));
}
else {
	echo $this->tag->linkTo(array(
		'logout',
		'Logout',
		'class' => 'btn btn-lg btn-default',
		'role' => 'button',
	));	
}
?>
                </div>
            </div>
        </div>
    </div>
</header>