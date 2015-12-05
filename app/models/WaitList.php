<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class WaitList extends BaseModel {

	public function getSource() {
		return 'wait_lists';
	}

	public function initialize() {

		parent::initialize();

		$this->hasOne('mission_id', 'Eve\Model\Mission', 'id', array('alias'=>'mission'));
		$this->hasOne('character_id', 'Eve\Model\Character', 'id', array('alias'=>'character'));
		$this->hasOne('fit_id', 'Eve\Model\Fit', 'id', array('alias'=>'fit'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));

    }

}