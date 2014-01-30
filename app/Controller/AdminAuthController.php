<?php
App::uses('AdminController', 'Controller');

class AdminAuthController extends AdminController {
	public $name = 'AdminAuth';
	public $layout = 'login';

	public function login() {
		if ($this->request->is('post')) {
			fdebug('1!');
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(AUTH_ERROR, null, null, 'auth');
			}
		}
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}
