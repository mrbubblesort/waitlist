<?php

namespace Eve\Form\Type\User;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Add extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {
        // Login details

        $username = new Element\Text('username');
        $username->setLabel('Email');
        $username->setFilters(array('striptags', 'trim'));
        $username->addValidators(array(
            new Validator\Email(array('message' => 'This is not a valid email')),
            new EveValidator\User\Unique(array('message' => 'Email already registered')),
        ));
        $username->setAttributes(array(
            'data-toggle' => 'popover',
            'data-content' => 'Enter an email address',
            'data-title' => 'Help',
        ));
        $this->add($username);

        $username_again = new Element\Text('username_again');
        $username_again->setLabel('Re-enter email');
        $username_again->setFilters(array('striptags', 'trim'));
        $username_again->addValidators(array(
            new Validator\Confirmation(array(
                'message' => 'Emails do not match',
                'with' => 'username'
            )),
        ));
        $this->add($username_again);

        $password = new Element\Password('password');
        $password->setLabel('Password');
        $password->setFilters(array('striptags', 'trim'));
        $password->addValidators(array(
            new Validator\Regex(array(
                'pattern' => '/[A-Za-z\d\W]+/i',
                'message' => 'Password must be greater than 6 characters'
            )),
            new Validator\StringLength(array(
                'max' => 100,
                'min' => 6,
                'messageMaximum' => 'Password is too long',
                'messageMinimum' => 'Password is too short',
            )),
        ));
        $password->setAttributes(array(
            'data-toggle' => 'popover',
            'data-content' => 'Password must be greater than 6 characters',
            'data-title' => 'Help',
        ));
        $this->add($password);

        $password_again = new Element\Password('password_again');
        $password_again->setLabel('Re-enter password');
        $password_again->setFilters(array('striptags', 'trim'));
        $password_again->addValidators(array(
            new Validator\Confirmation(array(
                'message' => 'Passwords do not match',
                'with' => 'password'
            )),
        ));
        $this->add($password_again);

        $name = new Element\Text('name');
        $name->setLabel('Name');
        $name->setFilters(array('striptags', 'trim'));
        $this->add($name);

        $teamspeak = new Element\Text('teamspeak');
        $teamspeak->setLabel('Teamspeak');
        $teamspeak->setFilters(array('striptags', 'trim'));
        $this->add($teamspeak);

        $character = new Element\Text('character');
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