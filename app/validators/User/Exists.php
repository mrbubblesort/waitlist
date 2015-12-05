<?php

namespace Eve\Validator\User;

use Eve\Model;
use Library\Base\Validator as BaseValidator;
use Phalcon\Validation\Message;

class Exists extends BaseValidator {

	public function validate(\Phalcon\Validation $validator, $attribute) {

		$value 	= $validator->getValue($attribute);
		$di 	= self::getDi();

		try {
			$exists = Model\User::count(array('username = :name:', 'bind' => array('name' => $value)));

			if(!$exists) {
				$txt = ($this->getOption('message')) ? $this->getOption('message') : 'User not found';
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