<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $components = array('Auth', 
	   'Core.PCAuth'/* => array(
	       'authorize' => array('Controller'),
	       'loginAction' => array('plugin' => '', 'controller' => 'adminAuth', 'action' => 'login'),
	       'loginRedirect' => array('plugin' => '', 'controller' => 'admin', 'action' => 'index'),
	       'logoutRedirect' => '/',
	       'authError' => 'You must log in to access this page'
	   )*/, 'Core.PCAdmin', /*'Table.PCTableGrid',*/ 'Article.PCArticle');
	public $layout = 'admin';
	public $uses = array('Article.Article', 'Media.Media');
	public $helpers = array('Paginator', 'Form', 'Html', 'Table.PHTableGrid', 'Table.PHTableInput', 'Table.PHTableForm');

	//protected $scaffoldModel = ''; // for autimatic custom scaffold for model's CRUD
	public $paginate;
	public $aNavBar, $currMenu;

	public function beforeFilter() {
        $this->aNavBar = array(
            'content' => array('label' => __('Content'), 'submenu' => array(
                array('label' => __('Static pages'), 'href' => '/admin/'),
                array('label' => __('News'), 'href' => '/admin/'),
                array('label' => __('Articles'), 'href' => '/admin/'),
            )),
            'categories' => array('label' => __('Categories'), 'href' => '/admin/'),
            'products' => array('label' => __('Products'), 'href' => '/admin/'),
            'settings' => array('label' => __('Settings'), 'href' => '/admin/')
        );
	}

	public function index() {
		/*
		$this->paginate = array(
			'fields' => array('id', 'created', 'title', 'teaser', 'published'),
		);
		$this->PCTableGrid->paginate('Article');
		*/
		$this->PCArticle->index();
	}

	public function edit($id = 0) {
	    /*
        App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();		// $this->Media = new MediaHelper(new View());
		fdebug($this->PHMedia->getSizeInfo('230x100'));
        */
	    fdebug($this->currMenu);
		$this->currMenu = 'content';
	    // $this->set('mediaData', $this->Media->getList(array('object_type' => 'Article', 'object_id' => $id)));
		$this->PCArticle->edit($id, &$lSaved);
		if ($lSaved) {
			$this->redirect(array($id));
		}
		// $row = $this->Article->findById($id);
		/*
		$data = $this->TableEdit->edit($this->scaffoldModel, $id, $lSaved);
		if ($lSaved) {
			$this->Loader->loadHelper('TableGrid');
			$this->redirect($this->TableGrid->actionURL('index'));
		}
		*/
	}

/*
	public function view($id) {
		$data = $this->TableEdit->view($this->scaffoldModel, $id);
	}
*/
	public function delete($id) {
		$this->autoRender = false;

		$model = $this->request->query('model');
		if ($model) {
			$this->loadModel($model);
			list($plugin, $model) = explode('.',$model);
			if (!$model) {
			    $model = $plugin;
			}
			$this->{$model}->delete($id);
		}
		if ($backURL = $this->request->query('backURL')) {
			$this->redirect($backURL);
			return;
		}
		$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
	}
}
