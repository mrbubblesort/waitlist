<?php

namespace Eve\Form\Type\Fit;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Add extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $character = new EveElement\Select('character_id', new ChoiceList\Character($this->session->get('auth')));
        $character->setLabel('Character name');
		$character->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($character);

        $data_string = new Element\Text('data_string');
        $data_string->setLabel('Fit Data');
		$data_string->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($data_string);

        $submit = new Element\Submit('submit');
        $submit->setLabel('Save');
        $submit->setUserOption('icon', 'floppy-o');
        $submit->setAttribute('value', 'Save');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }

    public function getValue($name) {

		$cid = $this->dispatcher->getParam('character', null);
		if($cid && $name == 'character_id') {
			return $cid;
		}


    	return parent::getValue($name);
    }
}