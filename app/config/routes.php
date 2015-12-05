<?php

//Create the router
//The order of routes in here DOES MATTER.  The list is in reverse, so routes lower in the list have higher precedence.

$router = new Phalcon\Mvc\Router();
$router->removeExtraSlashes(true);


$router->add(
    "[/]{0,1}",
    array(
        'controller' => 'default',
        'action' => 'index'
    )
)->setName('base');


$router->add(
    "/:controller",
    array(
        'controller' => 1,
        'action' => 'index'
    )
)->setName('index-action');
//
//
//$router->add(
//    "/:controller/:action/:params",
//    array(
//        'controller' => 1,
//        'action' => 2,
//        'params' => 3
//    )
//)
//->setName('full')
//->convert('action', function($action) {
//    return lcfirst(Phalcon\Text::camelize($action));
//});


$router->add(
    "/:controller/:action/([\d]+)/:params",
    array(
        'controller' => 1,
        'action' => 2,
        'id' => 3,
        'params' => 4,
    )
)
->setName('controller-action-id')
->convert('action', function($action) {
    return lcfirst(Phalcon\Text::camelize($action));
});


$router->add(
    "/(login|logout)",
    array(
        'controller' => 'default',
        'action' => 1,
    )
)
->setName('default-action')
->convert('action', function($action) {
    return lcfirst(Phalcon\Text::camelize($action));
});


$router->add(
	'/flush[/]?{id}', 
	array(
		'controller' => 'default', 
		'action' => 'flush'
	)
);


return $router;