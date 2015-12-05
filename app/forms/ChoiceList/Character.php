<?php
namespace Eve\Form\ChoiceList;

use Eve\Model;
use Library\Base\ChoiceList;
use Phalcon;

class Character extends ChoiceList {

    protected $data 	= null;
    protected $user 	= null;

    public function __construct(Model\User $user) {
        $this->user = $user;
        return parent::__construct();
    }

    public function getChoices() {

        if(!$this->data) {
            $this->data = array();
            $db = Phalcon\DI::getDefault()->get('db');

            $result = $db->query('
            	SELECT id, name
				FROM characters
				WHERE characters.user_id = :uid
				',
                array('uid' => $this->user->id)
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
