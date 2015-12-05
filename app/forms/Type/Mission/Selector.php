<?php

namespace Eve\Form\Type\Mission;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Selector extends BaseForm\Control {

    public function initialize($entity = null, $user_options = array()) {

        $mission = new EveElement\Select('mission', new ChoiceList\Mission());
        $mission->setLabel('Choose a mission');
		$mission->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($mission);

        $submit = new Element\Submit('mission_submit');
        $submit->setLabel('Go');
        $submit->setUserOption('icon', 'plus');
        $submit->setAttribute('value', 'Go');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }

}