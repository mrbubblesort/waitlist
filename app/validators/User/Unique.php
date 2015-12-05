<?php

namespace Eve\Validator\User;

use Eve\Model;
use Library\Base\Validator as BaseValidator;
use Phalcon\Validation\Message;

/**
 * Make sure a new username is unique
 */

class Unique extends BaseValidator {

	public function validate(\Phalcon\Validation $validator, $attribute) {

        $value 	= $validator->getValue($attribute);
        $di 	= self::getDi();
        $web_user = $di->get('session')->get('auth', null);
        try {
            // Only verifiy if guest or same username not submited
            if(
                !$web_user
                || $web_user->role == \Library\Base\Auth::ROLE_GUEST
                || $web_user->username != $value
            ) {
                $exists = Model\User::count(array('username = :name:', 'bind' => array('name' => $value)));

                if($exists) {
                    $txt = ($this->getOption('message')) ? $this->getOption('message') : 'Email already registered';

                    $validator->appendMessage(new Message($txt, $attribute));
                    return false;
                }
            }
            return true;

        }
        catch (\Exception $e) {
        	die($e->getMessage());
            $validator->appendMessage(new Message('General form error', $attribute));
            return false;
        }

        return true;
    }


}