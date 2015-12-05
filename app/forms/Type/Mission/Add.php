<?php

namespace Eve\Form\Type\Mission;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Add extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $name = new Element\Text('name');
        $name->setLabel('Name');
        $name->setFilters(array('striptags', 'trim'));
        $name->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($name);

		$active = new Element\Check('active');
		$active->setLabel('Activate Now?');
		$this->add($active);

        $submit = new Element\Submit('submit');
        $submit->setLabel('Save');
        $submit->setUserOption('icon', 'floppy-o');
        $submit->setAttribute('value', 'Save');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }

}