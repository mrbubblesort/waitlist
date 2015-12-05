<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Character extends BaseModel {

	public function getSource() {
		return 'characters';
	}

	public function initialize() {

		parent::initialize();

		$this->hasOne('user_id', 'Eve\Model\User', 'id', array('alias'=>'user'));
		$this->hasMany('id', 'Eve\Model\Fit', 'character_id', array('alias'=>'fits'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));

    }

}