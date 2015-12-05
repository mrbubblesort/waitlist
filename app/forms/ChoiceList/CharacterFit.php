<?php
namespace Eve\Form\ChoiceList;

use Eve\Model;
use Library\Base\ChoiceList;
use Phalcon;

class CharacterFit extends ChoiceList {

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
            	SELECT fits.id as fid, fits.name as fname, characters.name as cname
				FROM fits
				JOIN characters ON fits.character_id = characters.id
				WHERE fits.user_id = :uid
				',
                array('uid' => $this->user->id)
            );
            $result->setFetchMode(Phalcon\Db::FETCH_OBJ); //because FETCH_KEY_PAIR is broken again in phalcon 2.0.5
            $data = $result->fetchAll();
			foreach($data as $item) {
				$this->data[$item->fid] = $item->cname . ' / ' . $item->fname;
			}
        }

        return $this->data;
    }

    public function getValues() {
        return array_keys($this->getChoices());
    }

}
