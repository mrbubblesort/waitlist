<?php

namespace Library\Base;

use \Phalcon\Mvc\Controller as PhalconController;

abstract class Controller extends PhalconController {

    public function initialize() {
        $this->view->site = 'guest';
    }

}
