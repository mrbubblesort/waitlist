<?php
namespace Eve\Form\ChoiceList;

use Eve\Model;
use Library\Base\ChoiceList;
use Phalcon;

class Mission extends ChoiceList {

    protected $data 	= null;
    protected $active 	= true;

    public function __construct($act = true) {
        $this->active = $act;
        return parent::__construct();
    }

    public function getChoices() {

        if(!$this->data) {
            $this->data = array();
            $db = Phalcon\DI::getDefault()->get('db');

            $where_str = ($this->active) ? 'WHERE active = 1' : '';
            $result = $db->query("
            	SELECT id, name
				FROM missions
				$where_str
				"
            );
            $result->setFetchMode(Phalcon\Db::FETCH_OBJ); //because FETCH_KEY_PAIR is broken again in phalcon 2.0.5
            $data = $result->fetchAll();
			foreach($data as $item) {
				$this->data[$item->id] = $item->name;
			}
        }

        return $this->data;
    }

    public function getValues() {
        return array_keys($this->getChoices());
    }

}
