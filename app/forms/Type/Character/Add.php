<?php

namespace Eve\Form\Type\Character;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Add extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $character = new Element\Text('name');
        $character->setLabel('Character name');
        $character->setFilters(array('striptags', 'trim'));
		$character->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($character);

        $game_id = new Element\Text('game_id');
        $game_id->setLabel('Character In-Game ID');
        $game_id->setFilters(array('striptags', 'trim'));
		$game_id->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($game_id);

        $submit = new Element\Submit('submit');
        $submit->setLabel('Register');
        $submit->setUserOption('icon', 'user');
        $submit->setAttribute('value', 'Register');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }
}