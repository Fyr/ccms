<?php
App::uses('Helper', 'View');
class AppHelper extends Helper {

	public function getVar($path) {
		return Hash::get($this->_View->viewVars, $path);
	}
}
