<?php
//An array of all accessible actions sorted by controller
//Controller names match what you write in the address box, so it's company-feature, not companyFeature.
//Action names match the function name, so it's forgottenPassword, not forgotten-password
//
//	'controller' => array(
//		'action1', 'action2',
//	)
//
// NB: Must reset session after editing resources for the change to take effect
// ie: /flush/cc-session-cache

return array(
	'admin' => array(
		'add', 'index',
	),
	'character' => array(
		'add', 'delete', 'fits',
	),
	'default' => array(
		'flush', 'index', 'login', 'logout',
	),
	'fit' => array(
		'add', 'delete', 'details',
	),
	'mission' => array(
		'add', 'delete', 'index', 'edit', 'list', 'removePlayer', 'toggle',
	),
	'user' => array(
		'add', 'edit', 'index', 'password',
	),
);
