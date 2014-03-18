<?php
App::uses('AppController', 'Controller');
class AjaxController extends AppController {
	public $name = 'Ajax';
	public $components = array('Auth', 'RequestHandler');
	// public $layout = 'ajax';
	public $uses = array('Media.Media');
	// public $helpers = array('Html');

	public function beforeFilter() {
		$this->Auth->authorize = array('Controller');
		$this->Auth->loginAction = array('controller' => 'AdminAuth', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'Admin', 'action' => 'index');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __('You can\'t access that page');
	}

	public function isAuthorized($user) {
		// CakeLog::write('alert', print_r($user));
		return true;
	}

	public function upload() {
		$this->autoRender = false;
		App::uses('UploadHandler', 'Media.Vendor');
		$upload_handler = new UploadHandler();
		// $this->set('_serialize', '');
	}

	public function move() {
		$tmp_name = PATH_FILES_UPLOAD.$this->request->data('name');
		list($media_type) = explode('/', $this->request->data('type'));
		if (!in_array($media_type, $this->Media->types)) {
		    $media_type = 'bin_file';
		}
		$object_type = $this->request->data('object_type');
		$object_id = $this->request->data('object_id');
		$path = pathinfo($tmp_name);
		$file = $media_type; // $path['filename'];
		$ext = '.'.$path['extension'];
		
		$data = compact('media_type', 'object_type', 'object_id', 'tmp_name', 'file', 'ext');
		$this->Media->uploadMedia($data);
		
		$this->getList();
	}
	
	public function getList() {
	    $aMedia = $this->Media->getList();
	    $this->set('response', array('status' => 'OK', 'data' => $aMedia));
	    $this->set('_serialize', 'response');
	}
	
	public function delete($id) {
	    
	}
}
