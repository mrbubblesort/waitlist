<?php

namespace Eve\Plugins;

use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class Security extends Plugin {

    public $di; //handle on the Phalcon $di


    public function __construct($di) {
        $this->di = $di;
    }

    public function getAcl() {

        if(!isset($this->persistent->acl)) {

            try {
                $acl = new Acl\Adapter\Memory();
                $acl->setDefaultAction(Acl::DENY);

                $acl->addRole('guest');             //add guests role
                $acl->addRole('user', 'guest');     //all users and companies get guest permissions
                $acl->addRole('admin', 'user');

                $resources = require APPLICATION_PATH . '/config/acl/resources.php';
                foreach($resources as $controller => $actions) {
                    $acl->addResource($controller, $actions);
                }

                $permissions = require APPLICATION_PATH . '/config/acl/permissions.php';
                foreach($permissions as $role => $rules) {
                    foreach($rules as $controller => $action) {
                        $acl->allow($role, $controller, $action);
                    }
                }

                //give admins everything
                $acl->addRole('admin');
                $acl->allow('admin', '*', '*');

                $this->persistent->acl = $acl;
            }
            catch(\Exception $e) {
                if(APPLICATION_ENV == 'development' || APPLICATION_ENV == 'local_development') {
                    die($e->getMessage()."<hr><pre>" . print_r($e->getTraceAsString(), true) . "</pre>");
                }
            }

        }

        return $this->persistent->acl;
    }

    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
		$user	= $this->session->get('auth');
		$acl    = $this->getAcl();
		$role   = ($user && $user->role->role) ? $user->role->role : 'guest';

        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

		$allowed    = $acl->isAllowed($role, $controller, $action);
		if($allowed != Acl::ALLOW) {
			//Flash feedback message if in dev environment
			if(strpos(APPLICATION_ENV, 'development') !== false) {
				$this->flash->error("Route failing in security plugin - Controller: $controller, Action: $action, Role: $role, Url:" . $this->router->getRewriteUri());
			}

			//stop the event
			$event->stop();

			$this->response->redirect();
            
			return false;
        }
    }
}