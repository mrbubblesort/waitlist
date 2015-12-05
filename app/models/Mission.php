<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Mission extends BaseModel {

	public function getSource() {
		return 'missions';
	}

	public function initialize() {

		parent::initialize();

		$this->hasMany('id', 'Eve\Model\WaitList', 'mission_id', array('alias'=>'lists'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));

    }

}