<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $components = array('Auth', /*'Table.PCTableGrid',*/ 'Article.PCArticle');
	public $layout = 'admin';
	public $uses = array('Article.Article', 'Media.Media');
	public $helpers = array('Paginator', 'Form', 'Html', 'Table.PHTableGrid', 'Table.PHTableInput', 'Table.PHTableForm');

	//protected $scaffoldModel = ''; // for autimatic custom scaffold for model's CRUD
	public $paginate;
	private $aNavBar, $currMenu;

	public function beforeFilter() {
		$this->Auth->authorize = array('Controller');
		$this->Auth->loginAction = array('controller' => 'AdminAuth', 'action' => 'login');
		$this->Auth->loginRedirect = array('controller' => 'Admin', 'action' => 'index');
		$this->Auth->logoutRedirect = '/';
		$this->Auth->authError = __('You can\'t access that page');

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

	protected function getCurrMenu() {
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
		$this->set('aMenu', $this->aNavBar);
		$this->set('currMenu', $this->currMenu);
	}

	public function isAuthorized($user) {
		return true;
	}

	public function index() {
		/*
		$this->paginate = array(
			'fields' => array('id', 'created', 'title', 'teaser', 'published'),
		);
		$this->PCTableGrid->paginate('Article');
		*/
		$this->currMenu = 'content';
		$this->PCArticle->index();
	}

	public function edit($id = 0) {
	    /*
        App::uses('MediaPath', 'Media.Vendor');
		$this->PHMedia = new MediaPath();		// $this->Media = new MediaHelper(new View());
		fdebug($this->PHMedia->getSizeInfo('230x100'));
        */
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

	public function delete($id) {
		$this->autoRender = false;

		$model = $this->request->query('model');
		if ($model) {
			$this->loadModel($model);
			$this->{$model}->delete($id);
		}
		if ($backURL = $this->request->query('backURL')) {
			$this->redirect($backURL);
			return;
		}
		/*
		$this->TableEdit->delete($this->scaffoldModel, $id);

		$this->Loader->loadHelper('TableGrid');
		$this->redirect($this->TableGrid->actionURL('index'));
		*/
		$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
	}
/*
	public function view($id) {
		$data = $this->TableEdit->view($this->scaffoldModel, $id);
	}
*/
	/*
	public function upload() {
		$this->autoRender = false;

		App::uses('UploadHandler', 'Vendor');
		$upload_handler = new UploadHandler();

	}
	*/
}
