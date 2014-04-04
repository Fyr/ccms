<?php
App::uses('Model', 'Model');
class AppModel extends Model {
	
	protected $objectType = '';
	
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
	
	/**
	 * Auto-add object type in find conditions
	 *
	 * @param array $query
	 * @return array
	 */
	public function beforeFind($query) {
		if ($this->objectType) {
			$query['conditions'][$this->objectType.'.object_type'] = $this->objectType;
		}
		return $query;
	}
	
	public function getOptions($objectType = '', $objectID = '') {
		$conditions = array();
		if ($objectType) {
			$conditions[$this->alias.'.object_type'] = $objectType;
		}
		if ($objectID) {
			$conditions[$this->alias.'.object_id'] = $objectID;
		}
		return $this->find('list', compact('conditions'));
	}
}
