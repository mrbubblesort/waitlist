a:25:{i:0;s:1495:"<?php
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


        <title>";s:5:"title";N;i:1;s:26:"</title>
        
        ";s:11:"stylesheets";N;i:2;s:57:"
        <style type="text/css" media="all">
            ";s:9:"inlinecss";N;i:3;s:191:"
        </style>
    </head>

    <body class="<?php echo $site; ?>" id="page-top">

        
        <div id="site-wrapper">
            
            <div id="site-canvas">
                ";s:6:"header";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:35;}i:1;a:6:{s:4:"type";i:300;s:4:"expr";a:5:{s:4:"type";i:272;s:4:"left";a:4:{s:4:"type";i:265;s:5:"value";s:4:"site";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:35;}s:5:"right";a:4:{s:4:"type";i:260;s:5:"value";s:5:"admin";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:35;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:35;}s:15:"true_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:36;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:39:"/../layouts/partials/header-admin.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:36;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:37;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:37;}}s:16:"false_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:38;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:38:"/../layouts/partials/header-user.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:38;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:39;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:39;}}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:40;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:17:"
                ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:40;}}i:4;s:18:"

                ";s:3:"nav";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:43;}i:1;a:6:{s:4:"type";i:300;s:4:"expr";a:5:{s:4:"type";i:272;s:4:"left";a:4:{s:4:"type";i:265;s:5:"value";s:4:"site";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:43;}s:5:"right";a:4:{s:4:"type";i:260;s:5:"value";s:5:"admin";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:43;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:43;}s:15:"true_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:44;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:36:"/../layouts/partials/nav-admin.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:44;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:45;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:45;}}s:16:"false_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:46;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:35:"/../layouts/partials/nav-user.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:46;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:47;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:47;}}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:48;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:17:"
                ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:48;}}i:5;s:63:"


                <div class="container">
                    ";s:8:"messages";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:78:"
                        <?php $this->flash->output(); ?>
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:54;}}i:6;s:393:"
                    <?php
                        // Output an error message for invalid phalcon forms
                        if(isset($form) && $form instanceof Phalcon\Forms\Form && count($form->getMessages())) {
                            echo '<div class="alert alert-danger">Please check the form for errors</div>';
                        }
                    ?>
                    ";s:6:"search";N;i:7;s:123:"
                    <div class="row">
                        <div class="col-sm-3 col-md-3">
                            ";s:4:"menu";N;i:8;s:116:"
                        </div>
                        <div class="col-sm-9 col-md-9">
                            ";s:7:"content";N;i:9;s:99:"
                        </div>
                    </div>
                </div>

                ";s:6:"footer";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:73;}i:1;a:6:{s:4:"type";i:300;s:4:"expr";a:5:{s:4:"type";i:272;s:4:"left";a:4:{s:4:"type";i:265;s:5:"value";s:4:"site";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:73;}s:5:"right";a:4:{s:4:"type";i:260;s:5:"value";s:5:"admin";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:73;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:73;}s:15:"true_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:74;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:39:"/../layouts/partials/footer-admin.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:74;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:75;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:75;}}s:16:"false_statements";a:3:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:25:"
                        ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:76;}i:1;a:4:{s:4:"type";i:313;s:4:"path";a:4:{s:4:"type";i:260;s:5:"value";s:38:"/../layouts/partials/footer-user.phtml";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:76;}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:77;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:21:"
                    ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:77;}}s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:78;}i:2;a:4:{s:4:"type";i:357;s:5:"value";s:17:"
                ";s:4:"file";s:73:"/home/jr/workspace/eve/app/views/scripts/../layouts/two-column-left.phtml";s:4:"line";i:78;}}i:10;s:1189:"
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
        ";s:11:"javascripts";N;i:11;s:100:"
        <script type="text/javascript">
            $(document).ready(function() {
                ";s:12:"jqueryonload";N;i:12;s:55:"
            });
        </script>
    </body>
</html>
";}