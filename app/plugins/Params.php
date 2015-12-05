<?php

namespace Eve\Plugins;

use Phalcon\Acl;
use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class Params extends Plugin {

    public $di; //handle on the Phalcon $di


    public function __construct($di) {
        $this->di = $di;
    }

    /**
     * puts any params in the url into an assoc array in the dispatcher
     * for example given this url
     *		/en/employer/profile/edit/id/5/company/6/email/test@test.com
     * then in the controller
     *		$this->dispatcher->getParam('id') = 5
     *		$this->dispatcher->getParam('company') = 6
     *		$this->dispatcher->getParam('email') = test@test.com
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {

        $key_params = array();
        $params = $dispatcher->getParams();

        foreach ($params as $number => $value) {
            if ($number & 1) {
                $key_params[$params[$number - 1]] = $value;
            }
        }

        //loop again so we don't overwrite any params named in the route (like 'lang')
        foreach($key_params as $param => $value) {
            if($dispatcher->getParam($param) === null) {
                $dispatcher->setParam($param, $value);
            }
        }

    }
}