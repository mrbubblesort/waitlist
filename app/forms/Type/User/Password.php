<?php

namespace Eve\Form\Type\User;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class Password extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $curr_password = new Element\Password('current_password');
        $curr_password->setLabel('Current Password');
        $curr_password->setFilters(array('striptags', 'trim'));
        $curr_password->addValidators(array(
            new EveValidator\User\PasswordCheck(),
        ));
        $this->add($curr_password);


        $password = new Element\Password('password');
        $password->setLabel('New Password');
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
        $password_again->setLabel('Re-enter New Password');
        $password_again->setFilters(array('striptags', 'trim'));
        $password_again->addValidators(array(
            new Validator\Confirmation(array(
                'message' => 'Passwords do not match',
                'with' => 'password'
            )),
        ));
        $this->add($password_again);


        $submit = new Element\Submit('submit');
        $submit->setLabel('Save');
        $submit->setUserOption('icon', 'user');
        $submit->setAttribute('value', 'Save');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }
}