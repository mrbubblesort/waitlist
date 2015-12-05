<?php
namespace Library\Base;

//we don't care how it gets done, just that it does
interface ChoiceListInterface {

    public function getChoices();	//opts in the select
    public function getValues();	//values to validate against

}