<?php

namespace Eve\Form\Type\User;

use Eve\Validator as EveValidator;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

/**
 *
 * Login to Eve
 *
 */
class Login extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        // Login details
        $username = new Element\Text('username');
        $username->setLabel('Username');
        $username->setFilters(array('striptags', 'trim', 'string', 'lower'));
        $username->addValidators(array(
            new Validator\PresenceOf(array('message' => 'Username is required')),
            new EveValidator\User\Exists(array('message' => 'Username or password incorrect')),
        ));
        $this->add($username);

        $password = new Element\Password('password');
        $password->setLabel('Password');
        $password->setFilters(array('striptags', 'trim'));
        $password->addValidators(array(
            new Validator\PresenceOf(array('message' => 'Username or password incorrect')),
        ));
        $this->add($password);

        $redirect = new Element\Hidden('redirect');
        $redirect->setFilters(array('striptags', 'trim'));
        $this->add($redirect);

        $submit = new Element\Submit('submit');
        $submit->setLabel('Login');
        $submit->setUserOption('icon', 'user');
        $submit->setAttribute('value', 'Login');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }
}