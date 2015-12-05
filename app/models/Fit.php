<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Fit extends BaseModel {

	public function getSource() {
		return 'fits';
	}

	public function initialize() {

		parent::initialize();

		$this->hasOne('user_id', 'Eve\Model\User', 'id', array('alias'=>'user'));
		$this->hasOne('character_id', 'Eve\Model\Character', 'id', array('alias'=>'character'));
		$this->hasOne('type_id', 'Eve\Model\Type', 'id', array('alias'=>'type'));
		$this->hasMany('id', 'Eve\Model\FitPart', 'fit_id', array('alias'=>'parts'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'user_id',
			'character_id',
			'date_created',
		));

    }

}