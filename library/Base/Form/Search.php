<?php

namespace Library\Base\Form;

use Library\Base\Form as BaseForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Validator;

abstract class Search extends BaseForm {

    public function initialize($entity = null, $user_options = null) {

        //no need for it
        $this->setCsrf(false);

        //keyword
        $keyword = new Element\Text('keyword');
        $keyword->setLabel('keyword');
        $keyword->setFilters(array('striptags', 'trim'));
        $this->add($keyword);

        //search button
        $submit_search = new Element\Submit('submit_search');
        $submit_search->setLabel('search');
        $submit_search->setUserOption('icon', 'search');
        $submit_search->setAttributes(array(
            'value' => $this->translator->_('search'),
            'class' => 'btn btn-primary',
        ));
        $this->add($submit_search);

    }


    /**
     * Makes a select + 'and above' checkbox in a block
     *
     * @param string $element		- name of select element
     * @param string $element_above - name of check element
     * @param array $options
     */
    public function renderSelectAndAboveBlock($element, $element_above, $options = array()) {

        $col_size = (isset($options['col_size'])) ? $options['col_size'] : 'col-sm-4 col-md-4';
        unset($options['col_size']);

        return ""
            . "<div class='$col_size'>"
                . $this->renderSelectAndAbove($element, $element_above, $options)
            . "</div>";
    }


    /**
     * Makes a select + 'and above' checkbox
     *
     * @param string $element		- name of select element
     * @param string $element_above - name of check element
     * @param array $options
     */
    public function renderSelectAndAbove($element, $element_above, $options = array()) {

        $element_class = $this->get($element)->getAttribute('class');
        if(!isset($options['class']) && !$element_class) {
            $options['class'] = 'input-sm';
        }

        if(!isset($options['label_class'])) {
            $options['label_class'] = '';
        }

        $div_class = (isset($options['div_class'])) ? $options['div_class'] : '';
        unset($options['div_class']);

        $ele_opts = isset($options[$element]) ? $options[$element] : array();
        $ele_ab_opts = isset($options[$element_above]) ? $options[$element_above] : array();

        return ''
            . "<div class='$div_class'>"
                . $this->renderLabel($element, $options)
                . "<div class='media no-margin-top'>"
                    . "<div class='pull-left'>"
                        . $this->renderElement($element, $ele_opts)
                    . "</div>"
                    . "<label class='margin-top-xs' for='$element_above'>"
                        . $this->renderElement($element_above, $ele_ab_opts) . ' '
                        . $this->translator->_($this->get($element_above)->getLabel())
                    . "</label>"
                . "</div>"
            . "</div>";

    }

}