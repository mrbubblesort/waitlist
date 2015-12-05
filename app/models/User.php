<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class User extends BaseModel {

	public function getSource() {
		return 'users';
	}

	public function initialize() {

		parent::initialize();

		$this->hasOne('id', 'Eve\Model\Role', 'user_id', array('alias'=>'role'));
		$this->hasMany('id', 'Eve\Model\Character', 'user_id', array('alias'=>'characters'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));

    }


	public function isOwner($model) {
		return ($model->user_id == $this->id);
	}

}