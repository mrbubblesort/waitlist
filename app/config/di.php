<?php

use Eve\Components;

$di = new Phalcon\DI\FactoryDefault();

/**
 * Register the global configuration as config
 */
$di->set('config', $config);


/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);
    $url->setStaticBaseUri($config->application->staticBaseUri);
    return $url;
});


/************************
 *      Dispatcher      *
 ************************/
$di->setShared('dispatcher', function() use ($di) {

    //get the events manager
    $eventsManager = $di->getShared('eventsManager');

    //puts any params in the url into an assoc array in the dispatcher
    //for example given this url
    //	/en/employer/profile/edit/id/5/company/6/email/test@test.com
    //then in the controller
    //	$this->dispatcher->getParam('id') = 5
    //	$this->dispatcher->getParam('company') = 6
    //	$this->dispatcher->getParam('email') = test@test.com
    $eventsManager->attach('dispatch', new Eve\Plugins\Params($di));

    //tell it to listen for any dispatch event
    //and run the function in Security() that matches the event name
    //see http://docs.phalconphp.com/en/1.2.6/reference/dispatching.html#dispatch-loop-events
    $eventsManager->attach('dispatch', new Eve\Plugins\Security($di));

    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setDefaultNamespace("Eve\Controller");
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;

});


/************************
 *      Databases       *
 ************************/
foreach($config->database as $db => $db_cfg) {
    $di->set($db, function() use ($db_cfg) {
        // Log all SQL queries on
//        if(APPLICATION_ENV == 'development') {
//            $eventsManager = new EventsManager();
//
//            $logger = new FileLogger(APPLICATION_PATH . "/../data/log/mysql-query.log");
//
//          //Listen all the database events
//            $eventsManager->attach('db', function($event, $connection) use ($logger) {
//                if ($event->getType() == 'beforeQuery') {
//                    $logger->log($connection->getSQLStatement(), Logger::INFO);
//for future reference, this will add the bound variables to the log, but it's REALLY slow
// $logger->log($connection->getRealSqlStatement(), Logger::INFO);
// $logger->log($connection->getSQLVariables(), Logger::INFO);
//                }
//            });
//        }

        $connection = new Phalcon\Db\Adapter\Pdo\Mysql(array(
            "host" => $db_cfg->host,
            "username" => $db_cfg->username,
            "password" => $db_cfg->password,
            "dbname" => $db_cfg->dbname,
            "port" => $db_cfg->port,
            "charset" => (isset($db_cfg->charset)) ? $db_cfg->charset : 'utf8',
        ));

//        // Log all SQL queries on
//        if(APPLICATION_ENV == 'development') {
//            //Assign the eventsManager to the db adapter instance
//            $connection->setEventsManager($eventsManager);
//        }
        return $connection;
    });
}


/************************
*     Flash service     *
*************************/
$di->set('flash', function () {
    return new Phalcon\Flash\Session(array(
        'error' => 'alert alert-danger',
        'success' => 'alert alert-success center',
        'notice' => 'alert alert-info',
        'warning' => 'alert alert-warning'
    ));
});


/************************
 *        Views         *
 ************************/
$di->set('view', function() use ($config) {
    $view = new Phalcon\Mvc\View();

    $view->setViewsDir($config->application->viewsDir);
    $view->setLayoutsDir($config->application->layoutsDir);

    $view->registerEngines(array(
        '.phtml' => function($view, $di) use ($config) {
                        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
                        $volt->setOptions(array(
                            'compiledPath' => $config->application->compiledDir,
                            'stat' => true,
                            'compileAlways' => (bool)$config->application->compileAlways,
                        ));
                        return $volt;
                    }
    ));
    return $view;
});


/************************
 *       Routes         *
 ************************/
$di->set('router', function () {
    return include_once APPLICATION_PATH . '/config/routes.php';
});


/************************
 *       Sessions       *
 ************************/
$di->setShared('session', function() {
    $session = new Phalcon\Session\Adapter\Files();
    $session->start();
    return $session;
});


/************************
 *       Cookies
 * Cookies are encrypted
 * in Phalcon by default,
 * but need to set an
 * encryption key       *
 ************************/
$di->set('crypt', function() {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey('@NNPAN$h0kupanCURRYP@Nb@!k1nMAN');
    return $crypt;
});


/************************
 *     View Cache       *
 ************************/
$di->setShared('viewCache', function() use ($config) {

    //Cache data for one day by default
    $frontCache = new Phalcon\Cache\Frontend\Output(array(
        "lifetime" => 2592000
    ));
    //File backend settings
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" => __DIR__."/../../data/cache/",
        "prefix" => "page_"
    ));
    return $cache;

});


/************************
 *     Asset Manager
 *
 *  Use original class
 *  so we can cache changes
 *  and only update if
 *  files change
 *                      *
 ************************/
$di->setShared('assetsManager', function() use ($config) {
    $assetsManager = new Library\Base\AssetsManager();
    $minify_folder = APPLICATION_PATH . '/../public/production/';
    if(!file_exists($minify_folder)) {
        mkdir($minify_folder, 0777, true);
    }

    $assetsManager->setJsMinifyFolder($minify_folder);
    $assetsManager->setCssMinifyFolder($minify_folder);

    $assetsManager->setJsPathPrefix('/waitlist/public/production');
    $assetsManager->setCssPathPrefix('/waitlist/public/production');
    $assetsManager->addJsFilter(new \Phalcon\Assets\Filters\Jsmin());
    $assetsManager->addCssFilter(new \Phalcon\Assets\Filters\CssMin());
    return $assetsManager;
});


/************************
 *      Components      *
 ************************/
$di->setShared('pagination', function() use ($config) {
    return new Components\Pagination();
});
