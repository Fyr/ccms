<?php
App::uses('Component', 'Controller');
class PCAdminComponent extends Component {
	private $_;

	public function initialize(Controller $controller) {
		$this->_ = $controller;
	}

	public function startup() {
	    $this->_->currMenu = $this->_getCurrMenu();
	}
	
	protected function _getCurrMenu() {
		$curr_menu = str_ireplace('Admin', '', $this->_->request->controller); // By default curr.menu is the same as controller name
		foreach($this->_->aNavBar as $currMenu => $item) {
			if (isset($item['submenu'])) {
				foreach($item['submenu'] as $_currMenu => $_item) {
					if ($_currMenu === $curr_menu) {
						return $currMenu;
					}
				}
			}
		}
		return $curr_menu;
	}

	public function beforeRender() {
		$this->_->set('aNavBar', $this->_->aNavBar);
		$this->_->set('currMenu', $this->_->currMenu);
	}
	
}