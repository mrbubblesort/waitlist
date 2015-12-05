<?php

namespace Eve\Form\Type\User;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Edit extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $name = new Element\Text('name');
        $name->setLabel('Name');
        $name->setFilters(array('striptags', 'trim'));
        $this->add($name);

        $teamspeak = new Element\Text('teamspeak');
        $teamspeak->setLabel('Teamspeak');
        $teamspeak->setFilters(array('striptags', 'trim'));
        $this->add($teamspeak);

        $submit = new Element\Submit('submit');
        $submit->setLabel('Save');
        $submit->setUserOption('icon', 'user');
        $submit->setAttribute('value', 'Save');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }
}