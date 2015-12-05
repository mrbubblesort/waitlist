<?php
namespace Eve\Form\Element;

use Eve\Validator as EveValidator;
use Library\Base\ChoiceList;
use Phalcon\Forms\Element;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Validation\Validator;

class Select extends Element\Select {

    public function __construct($name, $options=null, $attributes=null){

        $empty = (isset($attributes['allowEmpty'])) ? $attributes['allowEmpty'] : false;

        if($options instanceof ChoiceList) {

            $this->addValidator(
                new Validator\InclusionIn(array(
                    'message' => 'invalid value selected',
                    'domain' => $options->getValues(),
                    'allowEmpty' => $empty
                ))
            );

            // if choices are multidimensional, need to send a plain array to phalcon
            $choices = $options->getChoices();
            if(count($choices) != count($choices, COUNT_RECURSIVE) && !isset($attributes['using'])) {
                $options = $options->getChoices();
            }
            else {
                $attributes['using'] = array('key', 'value');
            }
        }
        else if($options instanceof Resultset) {
            $this->addValidator(
                new EveValidator\ModelIn(array(
                    'message' => 'invalid value selected',
                    'domain' => $options,
                    'using' => reset($attributes['using']),  //first item in using
                    'allowEmpty' => $empty
                ))
            );
        }

        return parent::__construct($name, $options, $attributes);

    }

}