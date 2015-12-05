<?php

namespace Eve\Controller;

use Eve\Form\Type\User as UserForm;
use Eve\Model;
use Library\PaginationMeta as PaginationMeta;
use Library\Base\Auth\Google;
use Library\Base\Auth\Linkedin;
use Library\Base\Controller as BaseController;
use Phalcon\Http\Response;
use Phalcon\Paginator;
use Phalcon\Validation\Message;

class UserController extends BaseController
{
    /**
     * Displays the homepage
     */
    public function indexAction() {

		$user = $this->session->get('auth', null);

        //pull all the relevant data for sorting the results out of the url
        $meta = new PaginationMeta(
            $this->dispatcher,
            array(
                'id' => 'id',
            	'gid' => 'game_id',
                'name' => 'name',
                'date' => 'date_created',
            ),
            array('order_by' => 'id', 'order' => 0, 'limit' => 10)
        );

        //make the paginator
        $paginator = new Paginator\Adapter\Model(array(
            'data'	=> Model\Character::find(array(
                "user_id = :uid:",
                "order" => $meta->query,
                "bind" => array('uid' => $user->id),
            )),
            'limit'	=> $meta->limit,
            'page'	=> $meta->page,
        ));

        //set the data
		$this->view->user 		= $user;
        $this->view->page 		= $paginator->getPaginate();
        $this->view->page->meta = $meta;
 		$this->view->site 		= 'user';
 		$this->view->title 		= 'User Index';

    }

    public function addAction() {

    	$user = new Model\User();
    	$form = new UserForm\Add($user);

		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $user);
			if($form->isValid()) {
            	$pw = $user->password;
				$user->password = password_hash($pw, PASSWORD_BCRYPT);
				$user->save();

				$char = new Model\Character();
				$char->user_id = $user->id;
				$char->name = $user->character;
				$char->game_id = $user->game_id;
				$char->save();

				$role = new Model\Role();
				$role->user_id = $user->id;
				$role->role = 'user';
				$role->save();

				$this->session->set('auth', $user);

				$this->flashSession->success('User Saved');

				$this->response->redirect('user');
			}
		}


    	$this->view->form	= $form;
 		$this->view->site 	= 'user';
 		$this->view->title 	= 'User Add';
    }

    public function editAction() {

    	$user = $this->session->get('auth');
    	$form = new UserForm\Edit($user);

		if($this->request->isPost()) {
			$form->bind($this->request->getPost(), $user);
			if($form->isValid()) {
				$user->save();

				$this->flashSession->success('User Saved');

				$this->response->redirect('user');
			}
		}

    	$this->view->form	= $form;
 		$this->view->site 	= 'user';
 		$this->view->title 	= 'Profile';
    }


    public function passwordAction() {

    	$user = $this->session->get('auth');
    	$form = new UserForm\Password();

		if($this->request->isPost()) {

			$model = new \stdClass();
            $form->bind($this->request->getPost(), $model);

			if($form->isValid()) {
            	$pw = $model->password;
				$user->password = password_hash($pw, PASSWORD_BCRYPT);
				$user->save();

				$this->flashSession->success('Password Changed');

				$this->response->redirect('user');
			}

		}

    	$this->view->form	= $form;
 		$this->view->site 	= 'user';
 		$this->view->title 	= 'Edit Password';
    }

}
