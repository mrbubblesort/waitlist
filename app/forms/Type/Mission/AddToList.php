<?php

namespace Eve\Form\Type\Mission;

use Eve\Validator as EveValidator;
use Eve\Form\ChoiceList;
use Eve\Form\Element as EveElement;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

class AddToList extends BaseForm {

    public function initialize($entity = null, $user_options = array()) {

        $fit = new EveElement\Select('fit_id', new ChoiceList\CharacterFit($this->session->get('auth')));
        $fit->setLabel('Character / Fit');
		$fit->addValidator(new Validator\PresenceOf(array('message' => 'This field is required')));
        $this->add($fit);

        $submit = new Element\Submit('list_add_submit');
        $submit->setLabel('Add to List');
        $submit->setUserOption('icon', 'plus');
        $submit->setAttribute('value', 'Add to List');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);

    }

}