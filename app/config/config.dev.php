<?php

return new \Phalcon\Config(array(
    'database' => array(
        'db' => array(
            'host' => 'localhost',
            'username' => 'eve',
            'password' => 'pass1234',
        ),   
	),
    'application' => array(
        'compileAlways' => 1,
        'baseUri' 		=> 'http://alpha.eve-project.com.local/',	//this will get the lang appended on it in the controller
        'staticBaseUri' => 'http://alpha.eve-project.com.local/',	//this always stays the same
    ),
	
));