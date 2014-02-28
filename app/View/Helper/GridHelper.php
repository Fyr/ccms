<?php
App::uses('AppHelper', 'View/Helper');
class GridHelper extends AppHelper {
	public $helpers = array('Paginator', 'Html', 'A');
	private $paginate;

	/*
	public function __construct(View $view, $settings = array()) {
		fdebug($view, 'view.log');
        parent::__construct($view, $settings);


    }
    */

	public function render($modelName) {
		$this->paginate = $this->_View->viewVars['_paginate'][$modelName];
		fdebug($this->paginate, 'helper.log');
	}
}