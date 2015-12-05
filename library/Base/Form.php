<?php

namespace Library\Base;

use Phalcon\Forms\Form as PhalconForm;
use Phalcon\Forms\Element;
use Phalcon\Validation\Message;

abstract class Form extends PhalconForm {

    protected $use_csrf = true;

    //phalcon will call these functions before and after $form->isValid();
    //added here so that and form using them can call parent::bV()/aV() safely
    //(technical note: it's not part of their events manager, it's actually hard coded into their form class)
    public function beforeValidation() {}
    public function afterValidation() {}

    public function setCsrf($val) {
        $this->use_csrf = (bool)$val;
        return $this;
    }

    public function isValid($data=null, $entity=null) {
    	if(!$this->security->checkToken()) return false;
        return parent::isValid($data, $entity);
    }


    /**
     * Adds csrf to the form and return its html
     *
     * @return string
     */
    public function renderCsrf() {
    	return '<input type="hidden" name="' . $this->security->getTokenKey() . '" value="' . $this->security->getToken() . '"/>';
    }


    /**
     * Makes a form row
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderRow($element, array $options = array()) {

        $options = array_merge(
            array(
                'required' => false,
            ),
            (array)$this->get($element)->getUserOptions(),
            $options
        );

        $errors 		= trim($this->renderMessages($element));

        $has_errors_class = ($errors) ? ' has-error has-feedback' : '';

        $row_class = (isset($options['row_class'])) ? $options['row_class'] : '';
        unset($options['row_class']);

        $element_container_id = (isset($options['element_container_id'])) ? "id='{$options['element_container_id']}'" : '';
        unset($options['element_container_id']);

        // print row
        $row = "<div class='form-group $row_class $has_errors_class'>";
        // Different label position for check box
        if($this->get($element) instanceof Element\Check) {
            $div_class = (isset($options['div_class'])) ? $options['div_class'] : 'col-sm-offset-3 col-sm-9';
            unset($options['div_class']);

            $row .= "<div class='$div_class'><div class='checkbox'><label>"
                 .      $this->renderElement($element, $options)
                 .      '&nbsp;'
                 .      $this->get($element)->getLabel()
                 .      (($errors) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                 .      $errors
                 .  "</label></div></div>";
        }
        else {
            $div_class = (isset($options['div_class'])) ? $options['div_class'] : 'col-sm-9 col-md-9';
            unset($options['div_class']);

            $row .= ''
                 . $this->renderLabel($element, $options)
                 .  "<div class='$div_class' $element_container_id>"
                 .      $this->renderElement($element, $options)
                 .      (($errors) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                 .      $errors
                 .  "</div>";
        }
        $row .= "</div>";
        return $row;
    }


    /**
     * Makes a search form row
     *
     * @param array $elements
     * @param array $options
     * @return string
     */
    public function renderSearchRow(array $elements, array $options = array()) {
        $row_class = isset($options['row_class']) ? $options['row_class'] : '';

        $row = "<div class='row $row_class'>";
        foreach($elements as $element) {
            if(is_array($element)) {
                $i = 1;
                $row .= '<div class="col-sm-4 col-md-4"><div class="form-group">';
                foreach($element as $sub_element) {
                    $ele_options = isset($options[$sub_element]) ? $options[$sub_element] : array();

                    // Output the label for the group
                    if(isset($options[$sub_element]) && isset($options[$sub_element]['form_group_label'])) {
                        $row .= "<label for='$sub_element'>{$options[$sub_element]['form_group_label']}</label>";
                    }
                    else if($i == 1) {
                        $row .= "<label for='$sub_element'>{$this->get($sub_element)->getLabel()}</label>";
                    }

                    // Output wrapper div open
                    if($i == 1) {
                        $row .= '<div class="media no-margin-top">';
                    }
                    $row .= $this->renderSearchGroup($sub_element, $ele_options);
                    $i++;
                }
                $row .= '</div></div></div>';
            }
            else {
                $ele_options = isset($options[$element]) ? $options[$element] : array();
                $row .= $this->renderSearchBlock($element, $ele_options);
            }
        }
        $row .= '</div>';

        return $row;
    }


    /**
     * Makes a search form block
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderSearchBlock($element, array $options = array()) {

        $options = array_merge(
            array(
                'required' => false,
            ),
            (array)$this->get($element)->getUserOptions(),
            $options
        );

        $errors 		= trim($this->renderMessages($element));
        $required_class	= ($options['required']) ? 'required' : '';
        unset($options['required']);

        $has_errors_class = ($errors) ? ' has-error has-feedback' : '';

        $block_class = (isset($options['block_class'])) ? $options['block_class'] : '';
        unset($options['block_class']);

        $element_container_id = (isset($options['element_container_id'])) ? "id='{$options['element_container_id']}'" : '';
        unset($options['element_container_id']);

        $col_size = isset($options['col_size']) ? $options['col_size'] : 'col-sm-4 col-md-4';

        // print block
        $block = "<div class='$col_size $block_class $has_errors_class'>";

        $block .= "<label class='$required_class' for='$element'>"
             .      $this->get($element)->getLabel()
             .  "</label>"
             .  "<div $element_container_id>";

        if(isset($options['multiple'])) {
            $block .= $this->renderMultiselect($element, $options);
        }
        else {
            $block .= $this->renderElement($element, $options);
        }

        $block .= (($errors) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
             .      $errors
             .  "</div>";

        $block .= "</div>";
        return $block;
    }


    /**
     * Makes a search form group
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderSearchGroup($element, array $options = array()) {
        // Allow html to be passed in as well as form elements for complex designs
        if($this->has($element)) {
            $options = array_merge(
                array(
                    'required' => false,
                ),
                (array)$this->get($element)->getUserOptions(),
                $options
            );

            $errors 		= trim($this->renderMessages($element));
            $required_class	= ($options['required']) ? 'required' : '';
            unset($options['required']);

            $has_errors_class = ($errors) ? ' has-error has-feedback' : '';

            $block_class = (isset($options['block_class'])) ? $options['block_class'] : '';
            unset($options['block_class']);

            $element_container_id = (isset($options['element_container_id'])) ? "id='{$options['element_container_id']}'" : '';
            unset($options['element_container_id']);

            // print block
            $block = "<span class='$block_class $has_errors_class'>";

            // Different label position for check box
            if($this->get($element) instanceof Element\Check) {
                $block .= "<label class='margin-top-xs'>"
                     .      $this->renderElement($element, $options)
                     .      '&nbsp;'
                     .      $this->get($element)->getLabel()
                     .      (($errors) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                     .      $errors
                     .  "</label>";
            }
            else {
                $block .= $this->renderElement($element, $options)
                     .      (($errors) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                     .      $errors;
            }

            $block .= "</span>";
        }
        else {
            $block = $element;
        }

        return $block;
    }


    /**
     * Base render function.  Just prints the element, nothing else.
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderElement($element, $options = array()) {

        //'name' attrib needs to be overridden like so
        if(isset($options['name']) && $options['name']) {
            $this->get($element)->setAttribute('name', $options['name']);
        }

        if($this->get($element) instanceof Element\Select && !isset($options['please_select_no'])) {
            if(isset($options['please_select_txt'])) {
                $key = $options['please_select_txt'];
                unset($options['please_select_txt']);
            }
            else {
                $key = 'Please select';
            }
            $options['useEmpty'] = true;
            $options['emptyText'] = $key;
            $options['emptyValue'] = null;
        }

        $options = array_merge(
            (array)$this->get($element)->getAttributes(),
            (array)$this->get($element)->getUserOptions(),
            (array)$options
        );

        // Unset values that shouldn't be rendered in the element itself
        unset($options['required']);

        return (string)$this->get($element)->render($options);
    }


    /**
     * Base render function for messages/errors.
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderMessages($element, $options = array()) {

        $options = array_merge(
            array(
                'wrapper_tag' => 'ul',
                'wrapper_tag_attribs' => array('id' => "error_list_$element", 'class' => 'error_list'),
                'item_tag' => 'li',
                'item_tag_attribs' => array(),
            ),
            $options
        );

        $messages 		= $this->getMessagesFor($element);
        $messages->appendMessages($this->get($element)->getMessages());

        $wrapper_start 	= null;
        $wrapper_end 	= null;
        $items 		= null;

        if(count($messages)) {

            if($options['wrapper_tag']) {
                $wrapper_start = '<' . $options['wrapper_tag'];
                foreach($options['wrapper_tag_attribs'] as $k => $v) {
                    $wrapper_start .= " $k='$v'";
                }
                $wrapper_start .= ' >';
                $wrapper_end 	= '</' . $options['wrapper_tag'] . '>';
            }

            foreach($messages as $message) {
                $item_start = null;
                $item_end = null;
                if($options['item_tag']) {
                    $item_start = '<' . $options['item_tag'];
                    foreach($options['item_tag_attribs'] as $k => $v) {
                        $item_start .= " $k='$v'";
                    }
                    $item_start .= ' >';
                    $item_end = '</' . $options['item_tag'] . '>';
                }

                $items .= $item_start . (string)$message . $item_end;
            }

        }
        return $wrapper_start . $items . $wrapper_end;
    }


    /**
     * Makes a button out of an element
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderButton($element, $options = array()) {

        $options = array_merge(
            array(
                'type' => 'submit',
                'name' => $element,
                'class' => 'btn btn-default',
                'icon' => null,
            ),
            $this->get($element)->getAttributes(),
            (array)$this->get($element)->getUserOptions(),
            $options
        );

        $lbl_txt 	= $this->get($element)->getLabel();
        $icon_txt 	= ($options['icon']) ? "<i class='fa fa-{$options['icon']}'></i> " : '';
        unset($options['icon']);

        $attr_txt = '';
        foreach($options as $k => $v) {
            $attr_txt .= " $k='$v'";
        }

        return ''
            . "<button $attr_txt >"
                . $icon_txt
                . $lbl_txt
            . "</button>";
    }


    /**
     * Makes a row of buttons
     *
     * @param string|array $elements
     * @param array $options
     * @return string
     */
    public function renderButtonRow($elements, $options = array()) {

        $btn_html = '';
        foreach((array)$elements as $element) {
            $btn_html .= $this->renderButton($element, (isset($options[$element]) ? $options[$element] : $options)) . '&nbsp;&nbsp;';
        }

        return ''
            . "<div class='form-group'>"
                . "<div class='col-sm-offset-3 col-md-offset-3 col-sm-9 col-md-9'>"
                    . $btn_html
                . "</div>"
            . "</div>";
    }


    /**
     * Makes a row with a javascript character counter
     * NB: Requires jquery.charcount.js
     */
    public function renderCounterRow($element, $options = array()) {

        $row_class 			= (isset($options['row-class'])) ? " {$options['row-class']}" : '';
        $errors 			= trim($this->renderMessages($element, $options));
        $has_errors_class 	= ($errors) ? ' has-error has-feedback' : '';
        $required 			= (isset($options['required'])) ? ' required' : '';
        $label 				= (isset($options['label'])) ? $options['label'] : $this->get($element)->getLabel();

        return '<div class="form-group' . $row_class . $has_errors_class . '">'
                . '<label for="' . $element . '" class="col-sm-3 col-md-3 control-label' . $required . '">' . $label . '</label>'
                . '<div class="col-sm-9 col-md-9">'
                    . $this->renderCounter($element, $options)
                . '</div>'
            . '</div>';
    }


    /**
     * Makes a row with a javascript character counter
     * NB: Requires jquery.charcount.js
     */
    public function renderCounter($element, $options = array()) {

        $errors = trim($this->renderMessages($element, $options));
        $used = (isset($options['used'])) ? $options['used'] : 0;
        $target = (isset($options['data-target'])) ? $options['data-target'] : '#';
        $length = (isset($options['data-length'])) ? $options['data-length'] : '300';
        $class = (isset($options['class'])) ? $options['class'] : null;
        $placeholder = (isset($options['placeholder'])) ? $options['placeholder'] : null;
        $hide_txt = (isset($options['hide_txt'])) ? $options['hide_txt'] : null;

        $counter = $this->render($element, array(
                'class' => 'margin-bottom-xs data-counter ' . $class,
                'data-length' => $length,
                'maxlength' => $length,
                'data-target' => $target,
                'placeholder' => $placeholder,
            ));
        if($hide_txt) {
            $counter .= '<span id="' . substr($target, 1) . '" class="title-counter">' . $used . ' / ' . $length . '</span> ';
        }
        else {
            $counter .= '<span id="' . substr($target, 1) . '" class="pull-left">' . $used . ' / ' . $length . '</span> characters';
        }
        $counter .= $errors;

        return $counter;
    }

    /**
     * Makes a row with a javascript selected counter and deselect
     *
     * @param string|array $elements
     * @param array $options
     * @return string
     */
    public function renderMultiselectRow($element, $options = array())
    {

        $row_class = null;
        if(isset($options['row-class'])) {
            $row_class = " {$options['row-class']}";
            unset($options['row-class']);
        }

        $errors = trim($this->renderMessages($element, $options));
        $has_errors_class = ($errors) ? ' has-error has-feedback' : '';
        $required = (isset($options['required'])) ? ' required' : '';

        $label = $this->get($element)->getLabel();
        if(isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        }

        return
            '<div class="form-group' . $row_class . $has_errors_class . '">'
                . '<label for="' . $element . '" class="col-sm-3 col-md-3 control-label' . $required . '">' . $label . '</label>'
                . '<div class="col-sm-9 col-md-9">'
                    . $this->renderMultiselect($element, $options)
                    . $errors
                . '</div>'
            . '</div>';
    }

    /**
     * Makes a row with a javascript selected counter and deselect
     *
     * @param string|array $elements
     * @param array $options
     * @return string
     */
    public function renderMultiselect($element, $options = array())
    {
        $selected = array();
        if((isset($options['selected']))) {
            $selected = $options['selected'];
            unset($options['selected']);
        }

        $counter = null;
        $options['id'] = preg_replace("/[^A-Za-z0-9_]/", '', $element);
        if(isset($options['data-counter'])) {
            $counter = $options['data-counter'];
        }
        else {
            $counter = $options['id'] . '_counter';
            $options['data-counter'] = '#' . $counter;
        }

        return $this->renderElement($element, $options)
            . '<div class="checklist_tools">'
                . '<a class="deselect" data-target="#' . $options['id'] . '" href="#">'
                    . 'Uncheck all'
                . '</a>'
                . '<span class="checklist_total">'
                    . '<span id="' . $counter . '" class="checklist_total_num">'
                        . count((array)$selected)
                    . '</span>'
                        . ' selected'
                . '</span>'
            . '</div>';
    }


    /**
     * Makes a set of radios in their own form group.
     * Works for checkboxes too.
     *
     * @param string|array $elements
     * @param array $options
     * @return string
     */
    public function renderRadioSet($elements, $options = array()) {
        $btn_html = '';

        //there should only be one message if the radio is required but not set
        $group_messages = (isset($options['group_messages']))
            ? $options['group_messages']
            : null;
        unset($options['group_messages']);

        $group_label_req = (isset($options['group_label_required']))
            ? 'required'
            : '';
        $group_label = (isset($options['group_label']))
            ? "<label class='col-sm-3 col-md-3 control-label $group_label_req'>" . $options['group_label'] . '</label>'
            : "";
        unset($options['group_label']);


        foreach((array)$elements as $element) {
            $btn_html .= ''
                . '<label>'
                    . $this->renderElement($element, (isset($options[$element]) ? $options[$element] : $options)) . ' '
                    . $this->get($element)->getLabel()
                    . $this->renderMessages($element, $options)
                . '</label><br />';
        }

        return ''
            . '<div class="form-group">'
                . $group_label
                . "<div class='col-sm-9 col-md-9'>"
                    . '<div class="radio">'
                        . $btn_html
                        . (($group_messages) ? $this->renderMessages($group_messages) : '')
                    . '</div>'
                . '</div>'
            . '</div>';
    }


    /**
     * Special renderer for dual form elements
     * i.e. first_name_en & first_name_ja
     *
     * @param string $element_left
     * @param string $element_right
     * @param array $options
     * @return string
     */
    public function renderEitherOr($element_left, $element_right, $options = array()) {

        $required 	= (isset($options['required'])) ? 'required' : '';
        unset($options['required']);

        $label 		= (isset($options['label'])) ? $options['label'] : $this->get($element_left)->getLabel();
        $separator  = (isset($options['separator'])) ? $options['separator'] : '';


        $errors_left = trim($this->renderMessages($element_left));
        $errors_right = trim($this->renderMessages($element_right));
        $has_errors_class = ($errors_left || $errors_right) ? ' has-error has-feedback' : '';

        $row_class = (isset($options['row_class'])) ? $options['row_class'] : '';
        unset($options['row_class']);

        $element_container_id = (isset($options['element_container_id'])) ? "id='{$options['element_container_id']}'" : '';
        unset($options['element_container_id']);

        $options_left 	= (isset($options[$element_left])) ? $options[$element_left] : array();
        $options_right 	= (isset($options[$element_right])) ? $options[$element_right]: array();
        unset($options[$element_left], $options[$element_right]);

        //print row
        $row = "<div class='form-group $row_class $has_errors_class'>"
                . "<label class='col-sm-3 col-md-3 control-label $required' for='$element_left'>"
                    . $label
                . "</label>"
                . "<div class='col-sm-9 col-md-9' $element_container_id>"
                    . "<div class='row $separator'>"
                        . "<div class='col-sm-6 col-md-6 margin-bottom-sm-mobile'>"
                            . $this->renderElement($element_left, $options_left)
                            . (($errors_left) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                            . $errors_left
                        . "</div>"

                        . "<div class='col-sm-6 col-md-6'>";
        // Different label position for check box
        if($this->get($element_right) instanceof Element\Check) {
            $row .=             $this->renderElement($element_right, $options_right)
                 .              '&nbsp;'
                 .              $this->get($element_right)->getLabel();
        }
        else {
            $row .= $this->renderElement($element_right, $options_right);
        }
        $row .=               (($errors_right) ? '<span class="fa fa-times form-control-feedback"></span>' : '')
                            . $errors_right
                        . "</div>"
                    . "</div>"
                . "</div>"
               . "</div>";

        return $row;
    }


    /**
     * Special renderer for dual form key
     * i.e. first_name_en & first_name_ja
     *
     * @param string $element_left
     * @param string $element_right
     * @param array $options
     * @return string
     */
    public function renderEitherOrKey($title_left, $title_right, $options = array()) {
        $row_class = (isset($options['row_class'])) ? $options['row_class'] : '';

        //print row
        return "<div class='form-group $row_class'>"
                . "<label class='col-sm-3 col-md-3 control-label'></label>"
                . "<div class='col-sm-9 col-md-9'>"
                    . "<div class='row'>"
                        . "<div class='col-sm-6 col-md-6 margin-bottom-sm-mobile'>"
                            . $title_left
                        . "</div>"
                        . "<div class='col-sm-6 col-md-6'>"
                            . $title_right
                        . "</div>"
                    . "</div>"
                . "</div>"
               . "</div>";
    }


    /**
     * Makes an upload button row
     *
     * @param string|array $elements
     * @param array $options
     * @return string
     */
    public function renderUploadRow($element, $options = array()) {

        $required 	= (isset($options['required'])) ? 'required' : '';
        $label 		= (isset($options['label'])) ? $options['label'] : $this->get($element)->getLabel();
        $show_preview = (isset($options['show_preview']) && $options['show_preview'])
            ? '<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100%; height: auto; line-height: 150px"> Preview </div>'
            : '';
           unset($options['show_preview']);

        $errors = trim($this->renderMessages($element, $options));
        $has_errors_class = ($errors) ? ' has-error has-feedback' : '';
        $row_class = (isset($options['row_class'])) ? $options['row_class'] : '';
        $div_class = (isset($options['div_class'])) ? $options['div_class'] : 'col-sm-offset-3 col-md-offset-3 col-sm-9 col-md-9';

        return ''
            . "<div class='form-group $row_class $has_errors_class '>"
                . "<div class='$div_class'>"
                    . "<div class='no-margin-bottom fileinput fileinput-new input-full' data-provides='fileinput'>"
                        . $show_preview
                        . "<div class='no-margin-bottom input-group margin-top-sm'>"
                            . "<span class='input-group-addon btn btn-default btn-file'>"
                                . "<span class='fileinput-new'>"
                                    .'<i class="fa fa-paperclip margin-right-xs"></i>'
                                    . $label
                                . "</span>"
                                . "<span class='fileinput-exists'>"
                                    .'<i class="fa fa-pencil-square-o margin-right-xs"></i>'
                                    . 'Change'
                                . "</span>"
                                . $this->renderElement($element, $options)
                            . "</span>"
                            . "<a href='#' class='input-group-addon btn btn-default fileinput-exists' data-dismiss='fileinput'>"
                                .'<i class="fa fa-times margin-right-xs"></i>'
                                . 'Remove'
                            . "</a>"
                            . "<div class='form-control' data-trigger='fileinput'>"
                                . "<i class='fa fa-paperclip fileinput-exists'></i> <span class='fileinput-filename'></span>"
                            . "</div>"
                        . "</div>"
                    . "</div>"
                    . $errors
                . "</div>"
            . "</div>";
    }

    /**
     * Makes a basic label for an element
     *
     * @param string $element
     * @param array $options
     * @return string
     */
    public function renderLabel($element, $options = array()) {
        $options = array_merge(
            array(
                'required' => false,
            ),
            (array)$this->get($element)->getUserOptions(),
            $options
        );

        $label_key = (isset($options['label'])) ? $options['label'] : $this->get($element)->getLabel();
        $label = $label_key;

        $class = (isset($options['label_class'])) ? $options['label_class'] : 'col-sm-3 col-md-3 control-label';
        $class .= (isset($options['required']) && $options['required']) ? ' required' : '';

        return "<label class='$class' for='$element'>$label</label>";
    }
}
