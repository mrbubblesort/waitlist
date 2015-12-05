<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Role extends BaseModel {
	
	public function getSource() {
		return 'roles';
	}
	
	public function initialize() {
		
		parent::initialize();
		
		$this->hasOne('user_id', 'Eve\Model\User', 'user_id', array('alias'=>'user'));
		
		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));
		
    }
    
}