<?php
namespace Library\Base;

use Phalcon;

abstract class ChoiceList implements ChoiceListInterface, \Iterator
{

    public $translator = null;
    protected $_choices;

    public function __construct($user_options = array()) {
        //in the rare instance where you might need to always display msgs in one lang, add 'translator' => $lang to the $userOpts array
        if(isset($user_options['translator']) && in_array($user_options['translator'], array('en', 'ja'))) {
            $this->translator = Phalcon\DI::getDefault()->get('translator_' . $user_options['translator']);
        }
        else if(Phalcon\Di::getDefault()->has('translator')) {
            $this->translator = Phalcon\DI::getDefault()->get('translator');
        }

        $this->_choices = $this->getChoices();
    }

    public function rewind() {
        reset($this->_choices);
    }

    public function current() {
        return array('key' => key($this->_choices), 'value' => current($this->_choices));
    }

    public function key() {
        return key($this->_choices);
    }

    public function next() {
        return next($this->_choices);
    }

    public function valid() {
        return false !== current($this->_choices);
    }

    /**
     * Flatten a multidimensional array and preserve the keys
     *
     * @param array $array
     * @param array $result
     */
    public function flattenArray($array, &$new_array = array()) {
        foreach($array as $key => $child) {
            if(is_array($child)) {
                $new_array = $this->flattenArray($child, $new_array);
            }
            else {
                $new_array[$key] = $child;
            }
        }
        return $new_array;
    }

    /**
     * Phalcon's validator doesn't extend Injectable, so use this to get the DI instead.
     * Made it static function instead of setting it up in the construtor because not every validator will need it
     */
    public function getDi() {
        return Phalcon\DI::getDefault();
    }
}