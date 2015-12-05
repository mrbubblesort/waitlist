<?php

namespace Eve\Controller;

use Eve\Form\Type\Character as CharacterForm;
use Eve\Model;
use Library\PaginationMeta as PaginationMeta;
use Library\Base\Auth\Google;
use Library\Base\Auth\Linkedin;
use Library\Base\Controller as BaseController;
use Phalcon\Http\Response;
use Phalcon\Paginator;
use Phalcon\Validation\Message;

class CharacterController extends BaseController
{

    public function addAction() {

    	$user	= $this->session->get('auth');
    	$char 	= new Model\Character();
    	$form 	= new CharacterForm\Add($char);

		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $char);
			if($form->isValid()) {

				$char->user_id = $user->id;
				$char->save();

				$this->flashSession->success('Character Saved');

				return $this->response->redirect('user');
			}
		}


    	$this->view->form	= $form;
 		$this->view->site 	= 'user';
 		$this->view->title 	= 'Character Add';
    }


    public function deleteAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	$char = Model\Character::findFirst(array(
    		'id = :cid:',
    		'bind' => array('cid' => $id),
    	));

    	if($char && $user->isOwner($char)) {
    		foreach($char->fits as $fit) $fit->delete();
    		$char->delete();
    		$this->flashSession->success('Character Deleted');
    	}

		return $this->response->redirect('user');
    }


    public function fitsAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	$char = Model\Character::findFirst(array(
    		'id = :cid:',
    		'bind' => array('cid' => $id),
    	));

        //pull all the relevant data for sorting the results out of the url
        $meta = new PaginationMeta(
            $this->dispatcher,
            array(
                'fid' => 'id',
            	'type' => 'type_id',
                'name' => 'name',
                'date' => 'date_created',
            ),
            array('order_by' => 'id', 'order' => 0, 'limit' => 10)
        );
        $meta->baseLink = "character/fits/$id";

        //make the paginator
        $paginator = new Paginator\Adapter\Model(array(
            'data'	=> Model\Fit::find(array(
                "character_id = :cid:",
                "order" => $meta->query,
                "bind" => array('cid' => $char->id),
            )),
            'limit'	=> $meta->limit,
            'page'	=> $meta->page,
        ));

        //set the data
		$this->view->user 		= $user;
		$this->view->char		= $char;
        $this->view->page 		= $paginator->getPaginate();
        $this->view->page->meta = $meta;
 		$this->view->site 		= 'user';
 		$this->view->title 		= $char->name . "'s Fits";

    }
}
