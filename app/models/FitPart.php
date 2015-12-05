<?php

namespace Eve\Model;

use Library\Base\Model as BaseModel;
use Phalcon\Mvc\Model\Behavior\Timestampable;

class FitPart extends BaseModel {

	public function getSource() {
		return 'fit_parts';
	}

	public function initialize() {

		parent::initialize();

		$this->hasOne('fit_id', 'Eve\Model\Fit', 'id', array('alias'=>'fit'));
		$this->hasOne('type_id', 'Eve\Model\Type', 'id', array('alias'=>'type'));

		$this->skipAttributesOnUpdate(array(
			'id',
			'type_id',
			'date_created',
		));

    }

}