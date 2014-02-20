<?php
App::uses('AppController', 'Controller');

class AdminController extends AppController {
	public $name = 'Admin';
	public $components = array('Auth');
	public $layout = 'admin';
	public $uses = array('Article');

	public $paginate = array(
		'order' => 'id',
		'limit' => 1
	);

	protected $scaffoldModel = ''; // for autimatic custom scaffold for model's CRUD

	public function beforeFilter() {
		// Overload auth settings for admin area
		// $this->Loader->loadComponent('Auth');

		// $this->Auth->authenticate = array('Form' => array('userModel' => 'User', 'fields' => array('username' => 'username')));
		$this->Auth->authorize = array('Controller');
		$this->Auth->loginAction = array('controller' => 'AdminAuth', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'Admin', 'action' => 'index');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __('You can\'t access that page');

		// fix default order for pagination
		if ($this->scaffoldModel && isset($this->paginate['order']) && $this->paginate['order'] == 'id') {
			$this->paginate['order'] = $this->scaffoldModel.'.id';
		}
/*
		$this->aNavBar = array(
			'AdminDashboard' => array('title' => 'Dashboard', 'url' => Router::url(array('controller' => 'AdminDashboard'))),
			'AdminSys' => array('title' => 'System', 'url' => '#', 'submenu' => array(
				'AdminSysLocations' => array('title' => 'Locations', 'url' => Router::url(array('controller' => '/AdminSysLocations'))),
				'AdminSysPerms' => array('title' => 'Permissions', 'url' => Router::url(array('controller' => '/AdminSysPerms'))),
				'AdminSysRoles' => array('title' => 'Roles', 'url' => Router::url(array('controller' => '/AdminSysRoles'))),
				'AdminSysUsers' => array('title' => 'Users', 'url' => Router::url(array('controller' => '/AdminSysUsers'))),
				'AdminSysInspections' => array('title' => 'Inspections', 'url' => Router::url(array('controller' => '/AdminSysInspections'))),
				'AdminSysResourceTypes' => array('title' => 'Resource Types', 'url' => Router::url(array('controller' => '/AdminSysResourceTypes'))),
				'',
				'AdminLogs' => array('title' => 'Logs', 'url' => Router::url(array('controller' => '/AdminLogs')))
			)),
			'AdminApp' => array('title' => 'Units', 'url' => '#', 'submenu' => array(
				'AdminUnits' => array('title' => 'Organizations', 'url' => Router::url(array('controller' => '/AdminUnits'))),
				'AdminUnitResourceTypes' => array('title' => 'Resource Types', 'url' => Router::url(array('controller' => '/AdminUnitResourceTypes'))),
				'',
				'AdminUnitItems' => array('title' => 'Items', 'url' => Router::url(array('controller' => '/AdminUnitItems'))),
				'AdminUnitSettings' => array('title' => 'Settings', 'url' => Router::url(array('controller' => '/AdminUnitSettings'))),
				'AdminUnitInspections' => array('title' => 'Inspections', 'url' => Router::url(array('controller' => '/AdminUnitInspections'))),
				'AdminUnitLocations' => array('title' => 'Locations', 'url' => Router::url(array('controller' => '/AdminUnitLocations'))),
				'AdminUnitRoles' => array('title' => 'Roles', 'url' => Router::url(array('controller' => '/AdminUnitRoles'))),
				'AdminUnitUsers' => array('title' => 'Unit Users', 'url' => Router::url(array('controller' => '/AdminUnitUsers'))),
				'AdminUnitResources' => array('title' => 'Resources', 'url' => Router::url(array('controller' => '/AdminUnitResources'))),
				'AdminUnitLogs' => array('title' => 'Logs', 'url' => Router::url(array('controller' => '/AdminUnitLogs'))),
			)),
			'AdminAppUsers' => array('title' => 'Users', 'url' => Router::url(array('controller' => '/AdminAppUsers'))),
			'AdminEvents' => array('title' => 'Events', 'url' => Router::url(array('controller' => '/AdminEvents'))),
			'AdminPayments' => array('title' => 'Payments?', 'url' => Router::url(array('controller' => '/AdminPayments'))),
			'AdminAlerts' => array('title' => 'Alerts?', 'url' => Router::url(array('controller' => '/AdminAlerts'))),
			'AdminPages' => array('title' => 'Pages', 'url' => Router::url(array('controller' => '/AdminPages'))),
			'AdminNews' => array('title' => 'News', 'url' => Router::url(array('controller' => '/AdminNews')))
		);

		$this->currMenu = $this->initCurrMenu();
		*/
	}

	protected function initCurrMenu() {
		$curr_menu = $this->request->controller; // By default curr.menu is the same as controller name
		foreach($this->aNavBar as $currMenu => $item) {
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
		parent::beforeRender();
		$this->set('scaffoldModel', $this->scaffoldModel);
	}

	public function isAuthorized($user) {
		// CakeLog::write('alert', print_r($user));
		return true;
	}

	public function index() {
		// $aArticles = $this->Article->find('all', array('conditions' => array('id >' => 80), 'order' => array('id'), 'limit' => 10));
		$this->paginate = array('limit' => 10);
		$aArticles = $this->paginate('Article');
		$this->set('aArticles', $aArticles);
	}

	public function edit($id = false) {
		$data = $this->TableEdit->edit($this->scaffoldModel, $id, $lSaved);
		if ($lSaved) {
			$this->Loader->loadHelper('TableGrid');
			$this->redirect($this->TableGrid->actionURL('index'));
		}
		return $data;
	}

	public function delete($id) {
		$this->TableEdit->delete($this->scaffoldModel, $id);

		$this->Loader->loadHelper('TableGrid');
		$this->redirect($this->TableGrid->actionURL('index'));
	}

	public function view($id) {
		$data = $this->TableEdit->view($this->scaffoldModel, $id);
	}

}
