<?php
//An array of who can access each action
//Controller & action names match what you write in the address box, so it's company-feature, not companyFeature.
//
//    'role' => array(
//        'controller' => array('action')
//    )
//
// NB: Must reset session after editing permissions for the change to take effect
// ie: /flush/cc-session-cache

return array(
	'guest' => array(
		'default' 	=> '*',
		'user'		=> array('add'),
	),
	'user' => array(
		'character'	=> array('add', 'delete', 'fits'),
		'fit'		=> array('add', 'delete', 'details'),
		'mission'	=> array('list', 'removePlayer'),
		'user' 		=> '*',
	),
	'admin' => array(
		'admin' 	=> '*',
		'character'	=> '*',
		'fit'		=> '*',
		'mission'	=> '*',
		'user'		=> '*',
	),
);
