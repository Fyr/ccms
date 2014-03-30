<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	
	public function __construct($id = false, $table = null, $ds = null) {
		$this->_beforeInit();
	    parent::__construct($id, $table, $ds);
	    $this->_afterInit();
	}
	
	protected function _beforeInit() {
	    // Add here behaviours, models etc that will be also loaded while extending child class
	}

	protected function _afterInit() {
	    // after construct actions here
	}
}
