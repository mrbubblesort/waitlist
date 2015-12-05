<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class Type extends BaseModel {

	public function getSource() {
		return 'types';
	}

	public function initialize() {

		parent::initialize();

		$this->skipAttributesOnUpdate(array(
			'id',
			'date_created',
		));

    }

}