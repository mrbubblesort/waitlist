<?php

defined('APPLICATION_PATH') || define('APPLICATION_PATH', (getenv('APPLICATION_PATH')
    ? getenv('APPLICATION_PATH') : realpath(dirname(__FILE__) . '/../app/')));

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV')
    ? getenv('APPLICATION_ENV') : 'development'));


/**********************
 *      Configs       *
 **********************/
//load production conifg
$config = require APPLICATION_PATH . '/config/config.prod.php';

switch(APPLICATION_ENV) {
    case 'development':
    case 'local_development':
        if(file_exists(APPLICATION_PATH . '/config/config.dev.php')) {
            $dev_config = require APPLICATION_PATH . '/config/config.dev.php';
            $config->merge($dev_config);
            error_reporting(E_ALL);
        }
        break;
}

//add load anything from composer
require APPLICATION_PATH . '/../vendor/autoload.php';

/**********************
 *     AutoLoader     *
 **********************/
$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
	"Library"				=> APPLICATION_PATH . "/../library/",
	"Eve\Controller"		=> APPLICATION_PATH . "/controllers/",
	"Eve\Components" 		=> APPLICATION_PATH . "/components/",
	"Eve\Filter" 			=> APPLICATION_PATH . "/filters/",
	"Eve\Form" 				=> APPLICATION_PATH . "/forms/",
	"Eve\Logger" 			=> APPLICATION_PATH . "/loggers/",
	"Eve\Model" 			=> APPLICATION_PATH . "/models/",
	"Eve\Plugins" 			=> APPLICATION_PATH . "/plugins/",
	"Eve\Validator" 		=> APPLICATION_PATH . "/validators/",
));
$loader->register();


/************************
 * Dependency Injection ($di) *
 ************************/
require APPLICATION_PATH . '/config/di.php';

/************************
 *       Start up       *
 ************************/
try {

	$application = new \Phalcon\Mvc\Application($di);
	echo $application->handle()->getContent();

} catch(\Exception $e) {
	if(APPLICATION_ENV == 'development' || APPLICATION_ENV == 'local_development') {
		echo "Exception<hr>", $e->getMessage() . '<hr>' . $e->getTraceAsString() . '';
	}
}
