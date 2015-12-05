<?php

namespace Eve\Controller;

use Eve\Form\Type\Fit as FitForm;
use Eve\Model;
use Library\PaginationMeta as PaginationMeta;
use Library\Base\Auth\Google;
use Library\Base\Auth\Linkedin;
use Library\Base\Controller as BaseController;
use Phalcon\Http\Response;
use Phalcon\Paginator;
use Phalcon\Validation\Message;

class FitController extends BaseController
{

    public function addAction() {

    	$user	= $this->session->get('auth');
    	$fit 	= new Model\Fit();
    	$form 	= new FitForm\Add($fit);

		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $fit);
			if($form->isValid()) {

				//parse the data string
				$matches = array();
				//http://stackoverflow.com/questions/1454913/regular-expression-to-find-a-string-included-between-two-characters-while-exclu
				preg_match('/(?<=\<)(.*?)(?=>)/', $fit->data_string, $matches);
				$data = explode(':', $matches[0]);


				$fit->user_id 	= $user->id;
				$fit->name 		= strip_tags($fit->data_string);
				$fit->type_id 	= $data[1];

				unset($data[0], $data[1]); //remove the 'url=fitting' and the ship type
				$data = array_filter($data);
				$parts = array();
				foreach($data as $item) {
					$part = new Model\FitPart();
					if(strpos($item, ';')) {
						$item_data = explode(';', $item);
						$part->type_id 	= $item_data[0];
						$part->quantity = $item_data[1];
					}
					else {
						$part->type_id 	= $item;
						$part->quantity = 0;
					}
					$parts[] = $part;
				}

				$fit->parts = $parts;
				$fit->save();

				foreach($fit->getMessages() as $msg) {
					echo "$msg<hr>";
				}

				$this->flashSession->success('Fit Saved');

				return $this->response->redirect('character/fits/' . $fit->character_id);
			}
		}


    	$this->view->form	= $form;
 		$this->view->site 	= 'user';
 		$this->view->title 	= 'Add Fit';
    }


    public function detailsAction() {
    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	$fit = Model\Fit::findFirst(array(
    		'id = :fid: AND user_id = :uid:',
    		'bind' => array('fid' => $id, 'uid' => $user->id),
    	));

    	if(!$fit) return $this->response->redirect('character/fits');

        //pull all the relevant data for sorting the results out of the url
        $meta = new PaginationMeta(
            $this->dispatcher,
            array(
                'fid' => 'id',
            	'type' => 'type_id',
                'quantity' => 'quantity',
                'date' => 'date_created',
            ),
            array('order_by' => 'id', 'order' => 0, 'limit' => 10)
        );
        $meta->baseLink = "fit/details/$id";

        //make the paginator
        $paginator = new Paginator\Adapter\Model(array(
            'data'	=> Model\FitPart::find(array(
                "fit_id = :fid:",
                "order" => $meta->query,
                "bind" => array('fid' => $fit->id),
            )),
            'limit'	=> $meta->limit,
            'page'	=> $meta->page,
        ));

        //set the data
		$this->view->fit		= $fit;
        $this->view->page 		= $paginator->getPaginate();
        $this->view->page->meta = $meta;
 		$this->view->site 		= 'user';
 		$this->view->title 		= $fit->name . "'s Parts";
    }


    public function deleteAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	$fit = Model\Fit::findFirst(array(
    		'id = :fid:',
    		'bind' => array('fid' => $id),
    	));
    	$cid = $fit->character_id;

    	if($fit && $user->isOwner($fit)) {
    		foreach($fit->parts as $part) $part->delete();
    		$fit->delete();
    		$this->flashSession->success('Fit Deleted');
    	}

		return $this->response->redirect("character/fits/$cid");
    }
}
