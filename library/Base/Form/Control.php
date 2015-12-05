<?php

namespace Library\Base\Form;

use Library\Base\ChoiceList;
use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

abstract class Control extends BaseForm {

    public function initialize($entity = null, $user_options = null) {

        //no need for it
        $this->setCsrf(false);

        //delete button
        $delete = new Element\Submit('submit_delete');
        $delete->setLabel('delete');
        $delete->setUserOption('icon', 'trash');
        $delete->setAttributes(array(
            'value' => 'Delete',
            'class' => 'btn btn-danger btn-xs pull-left margin-right-xs',
        ));
        $this->add($delete);

    }


    public function renderSelectBtnGroup($element, array $options = array()) {
        $element = $this->get($element);
        if(!($element instanceof Element\Select)) return null;

        $base_url = (isset($options['base_url'])) ? $options['base_url'] : $this->url->get();
        $div_class = (isset($options['div_class'])) ? $options['div_class'] : '';
        $pls_select_txt = (isset($options['please_select_txt'])) ? $options['please_select_txt'] : 'please select';

        $options = $element->getOptions();

        //if options are a choicelist, flatten it
        if($options instanceof ChoiceList) {
            $new_opts = array();
            foreach($options as $k => $v) {
                $new_opts[$v['key']] = $v['value'];
            }
            $options = $new_opts;
        }

        //gotta loop through opts since getValue() might return null, but $options[0] = 'the please select txt'
        $display_txt = $pls_select_txt;
        foreach($options as $k => $v) {
            if($k == $element->getValue()) { $display_txt = $v; break; }
        }

        $html = ''
            . '<div class="btn-group btn-group-xs '.$div_class.'" role="group">'
                . '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
                    . $display_txt . ' '
                    . '<span class="caret"></span>'
                . '</button>'
                . '<ul class="dropdown-menu" role="menu">';
                    foreach($options as $k => $v) {
                        $html .= '<li>' . $this->tag->linkTo($base_url . $k, $v) . '</li>';
                    }
        $html .= ''
                . '</ul>'
            . '</div>';


        return $html;
    }
}