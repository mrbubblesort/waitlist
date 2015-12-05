<?php
	//header('Transfer-Encoding: chunked;'); - ML - Breaking iOS safari download of the site
	header('Content-Type: text/html; charset=utf-8;');
	header('Content-Language: en');

	// Prevent document caching
	header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time()));
	header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
	header('Cache-Control: must-revalidate');

    //Prevent other sites from loading us in an iframe
	header('X-Frame-Options: DENY');

    $this->tag->setDoctype(\Phalcon\Tag::HTML5);
    echo $this->tag->getDoctype();
?>
<html lang="en" prefix="og: http://ogp.me/ns#">
    <head>
        <meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="expires" content="<?php echo  gmdate('D, d M Y H:i:s \G\M\T', time()); ?>" >
<meta http-equiv="pragma" content="no-cache" >
<meta http-equiv="Cache-Control" content="no-cache" >
<?php

	$this->assetsManager
//
		//These are local resources that must be filtered
		->addCss(APPLICATION_PATH . '/../public/css/eve-bootstrap.css')
		->addCss(APPLICATION_PATH . '/../public/vendor/selectize/dist/css/selectize.bootstrap3.css')
		->addCss(APPLICATION_PATH . '/../public/vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css');

    // Output the CSS
    echo $this->assetsManager->outputCss();
    
?>
<link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">


        <title><?php echo $title; ?></title>
        
        
        <style type="text/css" media="all">
            
        </style>
    </head>

    <body class="<?php echo $site; ?>" id="page-top">

        
        <div id="site-wrapper">
            
            <div id="site-canvas">
                
                    <?php if ($site == 'admin') { ?>
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
                    <?php } else { ?>
                        <header class="header hidden-xs margin-top-md">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <div class="logo">
                    <a href="<?php echo $this->url->get('') ?>">
                    	<img src="/images/icons/logo.png" />
                    </a>
                    <p>Page name and some logo here</p>
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
                    <?php } ?>
                

                
                    <?php if ($site == 'admin') { ?>
                        
                    <?php } else { ?>
                        
                    <?php } ?>
                


                <div class="container">
                    
                        <?php $this->flash->output(); ?>
                    
                    <?php
                        // Output an error message for invalid phalcon forms
                        if(isset($form) && $form instanceof Phalcon\Forms\Form && count($form->getMessages())) {
                            echo '<div class="alert alert-danger">Please check the form for errors</div>';
                        }
                    ?>
                    
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            
	<?php
	if(
		$this->session->get('auth') &&
		$this->session->get('auth')->role->role == 'admin'
	) {
		?><div class="side-menu">
	<div class="nav-header side-menu-pad">
    	Admin Tools
    </div>
    <ul class="nav nav-list">
		<li>
			<?php
				echo $this->tag->linkTo(array(
					'mission',
					'Missions'
				));
			?>
		</li>
	</ul>
</div><?php
	}
?>

<div class="side-menu">
	<div class="nav-header side-menu-pad">
    	Menu
    </div>
    <ul class="nav nav-list">
		<li>
			<?php
				echo $this->tag->linkTo(array(
					'',
					'Home',
				));
			?>
		</li>
		<?php
			if($this->session->get('auth')) {
				?>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user',
								'My Overview'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'mission/list',
								'Active Missions / Wait List'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user/edit',
								'Edit Profile'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'user/password',
								'Edit Password'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'character/add',
								'Add Character'
							));
						?>
					</li>
					<li>
						<?php
							echo $this->tag->linkTo(array(
								'fit/add',
								'Add Fit'
							));
						?>
					</li>
				<?php
			}
		?>
	</ul>
</div>

                        </div>
                        <div class="col-sm-9 col-md-9">
                            
	<h2><?php echo $title; ?></h2>

	<?php
		echo $this->tag->linkTo(array(
			'mission/add',
			'<i class="fa fa-plus"></i> Create New Mission',
			'class' => 'btn btn-success pull-left',
		));

		if($page->items) echo $this->pagination->getRow($page, 'Fits', $this->url->get($page->meta->baseLink . $page->meta->pageLink));
	?>
	<div class="table-responsive">
		<table class="table table-condensed table-hover">
			<tr class="background-gray">
				<th><?php echo $this->pagination->sortByLink($page->meta, $page->meta->baseLink, 'ID', 'mid'); ?></th>
				<th><?php echo $this->pagination->sortByLink($page->meta, $page->meta->baseLink, 'Name', 'name'); ?></th>
				<th><?php echo $this->pagination->sortByLink($page->meta, $page->meta->baseLink, 'Active', 'active'); ?></th>
				<th><?php echo $this->pagination->sortByLink($page->meta, $page->meta->baseLink, 'Date Created', 'date'); ?></th>
                <th></th>
                <th></th>
            </tr>
	        <?php
	            if($page->items) {
	                foreach($page->items as $mission) {
						?>
							<tr class="<?php echo ($mission->active == 1) ? 'success' : ''; ?>">
								<td><?php echo $mission->id; ?></td>
								<td><?php echo $mission->name; ?></td>
								<td><?php echo ($mission->active == 1) ? 'Yes' : 'No'; ?></td>
								<td><?php echo $mission->date_created; ?></td>
								<td>
									<?php
										if((bool)$mission->active) {
											echo $this->tag->linkTo(array(
												'mission/toggle/' . $mission->id,
												'<i class="fa fa-power-off"></i> Deactivate',
												'class' => 'btn btn-danger btn-sm pull-left margin-right-xs',
											));
										}
										else {
											echo $this->tag->linkTo(array(
												'mission/toggle/' . $mission->id,
												'<i class="fa fa-plug"></i> Activate',
												'class' => 'btn btn-success btn-sm pull-left margin-right-xs',
											));
										}

									?>
								</td>
								<td>
									<?php
										echo $this->tag->linkTo(array(
											'mission/delete/' . $mission->id,
											'<i class="fa fa-trash-o"></i> Delete',
											'class' => 'btn btn-danger btn-sm pull-left margin-right-xs',
										));
									?>
								</td>
							</tr>
						<?php
	                }
	            }
			?>
		</table>
	</div>

                        </div>
                    </div>
                </div>

                
                    <?php if ($site == 'admin') { ?>
                        <footer class="footer padding-bottom-footer-screen-xs">
	<div class="container">
        <div class="row">
    		<div class="col-sm-12 col-md-12">
    			copyright or something
    		</div>		
		</div>
	</div>
</footer>
                    <?php } else { ?>
                        <footer class="footer padding-bottom-footer-screen-xs">
	<div class="container">
        <div class="row">
    		<div class="col-sm-12 col-md-12">
    			copyright or something
    		</div>		
		</div>
	</div>
</footer>
                    <?php } ?>
                
            </div>
        </div>

        <?php echo $this->tag->javascriptInclude('//code.jquery.com/jquery-2.1.4.min.js', false); ?>
<?php
    $this->assetsManager

		//These are local resources that must be filtered
		->addJs(APPLICATION_PATH . '/../public/vendor/bootstrap/dist/js/bootstrap.min.js')
		->addJs(APPLICATION_PATH . '/../public/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')
		->addJs(APPLICATION_PATH . '/../public/vendor/bootstrap-overflow-navs/bootstrap-overflow-navs.js')
		->addJs(APPLICATION_PATH . '/../public/vendor/jquery.cookie/jquery.cookie.js')
		->addJs(APPLICATION_PATH . '/../public/vendor/selectize/dist/js/standalone/selectize.min.js')
	    //Put general JS that needs to be run on document ready in application.js
//    ->addJs(APPLICATION_PATH . '/../public/js/application.js')
    ;

    // Join all the resources in a single file
//    ->join(true)

    // Use the built-in Jsmin filter
//    ->addFilter(new Phalcon\Assets\Filters\Jsmin());

    // Output the JS
    echo $this->assetsManager->outputJs();

?>

<script type="text/javascript">
	$(document).ready(function() {
	    $('select.selectize').selectize();
	});
</script>
        
        <script type="text/javascript">
            $(document).ready(function() {
                
            });
        </script>
    </body>
</html>
