<?php
App::uses('Controller', 'Controller');

class AppController extends Controller {
    
    public function __construct($request = null, $response = null) {
	    $this->_beforeInit();
	    parent::__construct($request, $response);
	    $this->_afterInit();
	}
	
	protected function _beforeInit() {
	    // Add here components, models, helpers etc that will be also loaded while extending child class
	}
	
	protected function _afterInit() {
	    // Add here components, models, helpers etc that will be also loaded while extending child class
	}

    public function isAuthorized($user) {
	    fdebug("App:isAuthorized!\r\n");
		return true;
	}
}
