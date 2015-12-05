<?php

namespace Library\Base;

use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\Model as PhalconModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

abstract class Model extends PhalconModel {
	
 	public function initialize() {

 	    $this->addBehavior(new Timestampable(
 	        array(
 	            'beforeValidationOnCreate' => array(
 	                'field' => 'date_created',
 	                'format' => 'Y-m-d H:i:s',
 	            )
 	        )
 	    ));

 	    $this->addBehavior(new Timestampable(
 	        array(
 	            'beforeValidationOnCreate' => array(
 	                'field' => 'date_updated',
 	                'format' => 'Y-m-d H:i:s',
 	            )
 	        )
 	    ));

 	    $this->addBehavior(new Timestampable(
 	        array(
 	            'beforeValidationOnUpdate' => array(
 	                'field' => 'date_updated',
 	                'format' => 'Y-m-d H:i:s',
 	            )
 	        )
 	    ));

 	}
	
}