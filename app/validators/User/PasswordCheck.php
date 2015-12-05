<?php

namespace Eve\Validator\User;

use Eve\Model;
use Library\Base\Validator as BaseValidator;
use Phalcon\Validation\Message;

class PasswordCheck extends BaseValidator {

	public function validate(\Phalcon\Validation $validator, $attribute) {

		$value 	= $validator->getValue($attribute);
		$di 	= self::getDi();
		$user	= $di->get('session')->get('auth');

		try {
			if(!password_verify($value, $user->password)) {
				$txt = ($this->getOption('message')) ? $this->getOption('message') : 'Incorrect Password';
				$validator->appendMessage(new Message($txt, $attribute));
                    return false;
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