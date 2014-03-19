<?php
App::uses('AppController', 'Controller');
App::uses('PAjaxController', 'Core.Controller');
class AjaxController extends PAjaxController {
	public $name = 'Ajax';
	public $components = array('Core.PCAuth');
	public $uses = array('Media.Media');
	
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
	    $this->setResponse($this->Media->getList());
	}
	
	/*
	public function delete($id = 0) {
	    $this->PCAdmin->delete($id);
	    // $this->setResponse(true);
	}
	*/
}
