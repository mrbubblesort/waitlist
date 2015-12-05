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