<?php

return new \Phalcon\Config(array(
    'database' => array(
        'db' => array(
            'adapter' => 'Mysql',
            'host' => 'db.eve-project.com',
            'port' => 3306,
            'username' => 'eve',
            'password' => 'password',
            'dbname' => 'eve'
        ),
	),
    'application' => array(
        'controllersDir' => APPLICATION_PATH . '/controllers/',
        'modelsDir' => APPLICATION_PATH . '/models/',
        'formsDir' => APPLICATION_PATH . '/forms/',
        'viewsDir' => APPLICATION_PATH . '/views/scripts/',
        'layoutsDir' => APPLICATION_PATH . '/views/layouts/',
        'cacheDir' => APPLICATION_PATH . '/../data/cache/',
        'compiledDir' => APPLICATION_PATH . '/../data/volt/',
        'compileAlways' => 0,
        'baseUri' 		=> 'https://www.eve-project.com/',	//this will get the lang appended on it in the controller
        'staticBaseUri' => 'https://www.eve-project.com/',	//this always stays the same
    ),
	
));