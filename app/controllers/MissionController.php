<?php

namespace Eve\Controller;

use Eve\Form\Type\Mission as MissionForm;
use Eve\Model;
use Library\PaginationMeta as PaginationMeta;
use Library\Base\Auth\Google;
use Library\Base\Auth\Linkedin;
use Library\Base\Controller as BaseController;
use Phalcon\Http\Response;
use Phalcon\Paginator;
use Phalcon\Validation\Message;

class MissionController extends BaseController
{

    public function addAction() {

    	$user	 	= $this->session->get('auth');
    	$mission 	= new Model\Mission();
    	$form 		= new MissionForm\Add($mission);

		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $mission);
			if($form->isValid()) {
				$mission->active = ($this->request->hasPost('active') && (bool)$this->request->getPost('active')) ? 1 : 0;
				$mission->save();
				$this->flashSession->success('Mission Saved');
				return $this->response->redirect('mission');
			}
		}

    	$this->view->form	= $form;
 		$this->view->site 	= 'admin';
 		$this->view->title 	= 'Mission Add';
    }


    public function deleteAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

        if($user->role->role != 'admin') {
	    	return $this->response->redirect('user');
    	}

    	$mission = Model\Mission::findFirst(array(
    		'id = :mid:',
    		'bind' => array('mid' => $id),
    	));

    	if($mission) {
    		foreach($mission->lists as $list) $list->delete();
    		$mission->delete();
    		$this->flashSession->success('Mission Deleted');
    	}

		return $this->response->redirect('mission');
    }


    public function toggleAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

        if($user->role->role != 'admin') {
	    	return $this->response->redirect('user');
    	}

		$mission = Model\Mission::findFirst(array(
    		'id = :mid:',
    		'bind' => array('mid' => $id),
    	));

    	if($mission) {
    		if($mission->active) {
    			$mission->active = 0;
    			$this->flashSession->success('Mission Deactivated');
    		}
    		else {
    			$mission->active = 1;
    			$this->flashSession->success('Mission Activated');
    		}
    		$mission->save();
    	}

    	return $this->response->redirect('mission');
    }

    public function indexAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	if($user->role->role != 'admin') {
	    	return $this->response->redirect('user');
    	}

        //pull all the relevant data for sorting the results out of the url
        $meta = new PaginationMeta(
            $this->dispatcher,
            array(
                'mid' => 'id',
                'name' => 'name',
            	'active' => 'active',
                'date' => 'date_created',
            ),
            array('order_by' => 'id', 'order' => 0, 'limit' => 10)
        );

		$builder = $this->modelsManager->createBuilder()
			->from('Eve\Model\Mission')
			->orderBy($meta->query);

        //build the paginator
        $paginator = new Paginator\Adapter\QueryBuilder(array(
            'builder'	=> $builder,
            'limit'		=> $meta->limit,
            'page'		=> $meta->page,
        ));

        //set the data
		$this->view->user 		= $user;
        $this->view->page 		= $paginator->getPaginate();
        $this->view->page->meta = $meta;
 		$this->view->site 		= 'admin';
 		$this->view->title 		= 'Mission List';

    }

    public function listAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');

    	$mission = ($id)
    		? Model\Mission::findFirst(array('id = :mid: AND active = 1', 'bind' => array('mid' => $id)))
    		: Model\Mission::findFirst(array('active = 1'));

    	if(!$mission) {
    		$this->flashSession->error('Sorry, no active missions at this time');
    		return $this->response->redirect('user');
    	}

    	$add_form = new MissionForm\AddToList();

    	$wait_list = new Model\WaitList();
		if($this->request->isPost()) {
			$add_form->bind($this->request->getPost(), $wait_list);
			if($add_form->isValid()) {
				$wait_list->mission_id 		= $mission->id;
				$wait_list->user_id 		= $user->id;
				$wait_list->character_id 	= $wait_list->fit->character->id;
				$wait_list->waiting 		= 1;
				$wait_list->save();
				$this->flashSession->success('You have been added to the list');
				return $this->response->redirect('mission/list/' . $mission->id);

			}
		}
        //pull all the relevant data for sorting the results out of the url
        $meta = new PaginationMeta(
            $this->dispatcher,
            array(
                'cid' => 'character_id',
                'fid' => 'fit_id',
                'date' => 'date_created',
            ),
            array('order_by' => 'date', 'order' => 0, 'limit' => 10)
        );
		$meta->baseLink = ($id)
			? "mission/list/$id"
			: "mission/list";

		$builder = $this->modelsManager->createBuilder()
			->from('Eve\Model\WaitList')
			->where('mission_id = :mid: AND waiting = 1', array('mid' => $mission->id))
			->orderBy($meta->query);

        //build the paginator
        $paginator = new Paginator\Adapter\QueryBuilder(array(
            'builder'	=> $builder,
            'limit'		=> $meta->limit,
            'page'		=> $meta->page,
        ));


		$this->view->title 		= $mission->name;
		$this->view->mission	= $mission;
        $this->view->page 		= $paginator->getPaginate();
        $this->view->page->meta = $meta;
		$this->view->add_form 	= $add_form;
		$this->view->mission_form = new MissionForm\Selector();
    }


    public function removePlayerAction() {

    	$user	= $this->session->get('auth');
    	$id 	= $this->dispatcher->getParam('id');
    	$wait 	= Model\WaitList::findFirst(array(
    		'id = :wid:',
    		'bind' => array('wid' => $id)
    	));

    	if($user->role->role != 'admin' && !$user->isOwner($wait)) {
    		return $this->response->redirect('mission/list');
    	}

    	$wait->waiting = 0;
    	$wait->save();

    	$this->flashSession->success('You have been removed from the list');
    	return $this->response->redirect('mission/list/' . $wait->mission_id);

    }
}
