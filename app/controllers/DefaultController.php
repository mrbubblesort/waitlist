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

/**
 * The DefaultController contains actions for many general forms and details pages.
 */
class DefaultController extends BaseController
{
    /**
     * Displays the homepage
     */
    public function indexAction() {
 		$this->view->site 	= 'guest';
 		$this->view->title 	= 'Eve';
    }

    public function loginAction() {

    	if($this->session->get('auth')) {
    		return $this->response->redirect('user');
    	}

		$form = new UserForm\Login();
		if($this->request->isPost()) {
            $model = new \stdClass();
            $form->bind($this->request->getPost(), $model);

			if($form->isValid()) {
				$user = Model\User::findFirst(array(
					'username = :name:',
					'bind' => array('name' => $model->username)
				));

				if(password_verify($model->password, $user->password)) {
					$this->session->set('auth', $user);
					return $this->response->redirect('user');
				}

				$this->flashSession->error('Username or password incorrect');
			}
		}

    	$this->view->form 	= $form;
 		$this->view->site 	= 'guest';
 		$this->view->title 	= 'Login';
    }

    public function logoutAction() {
		$this->session->remove('auth');
		return $this->response->redirect();
    }


	public function flushAction() {

		$id = $this->dispatcher->getParam('id');
		switch($id) {
			//holds user sessions and acl
            case 'eve-session-cache':
				session_unset();
				echo 'session flushed';
				break;

            default:
            	echo 'done';
            	break;
		}

	}
}

