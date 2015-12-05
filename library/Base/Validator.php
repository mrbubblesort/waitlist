<?php
namespace Library\Base;

use Phalcon;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator as PhalconValidator;
use Phalcon\Validation\ValidatorInterface;

abstract class Validator extends PhalconValidator implements ValidatorInterface
{

    /**
     * Phalcon's validator doesn't extend Injectable, so use this to get the DI instead.
     * Made it static function instead of setting it up in the construtor because not every validator will need it
     */
    public static function getDi() {
        return Phalcon\DI::getDefault();
    }

}