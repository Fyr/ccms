<?php
App::uses('AppController', 'Controller');
class AdminController extends AppController {
	public $name = 'Admin';
	public $components = array('Core.PCAuth', 'Core.PCAdmin', /*'Table.PCTableGrid',*/ 'Article.PCArticle');
	public $layout = 'admin';
	public $uses = array(); // 'Article.Article', 'Media.Media'
	// public $helpers = array('Paginator', 'Form', 'Html', 'Table.PHTableGrid', 'Table.PHTableInput', 'Table.PHTableForm');

	public function _beforeInit() {
        $this->aNavBar = array(
            'content' => array('label' => __('Content'), 'submenu' => array(
                array('label' => __('Static Pages'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'Page')),
                array('label' => __('News'), 'href' => array('controller' => 'AdminContent', 'action' => 'index', 'News')),
            )),
            'categories' => array('label' => __('Categories'), 'href' => '/admin/'),
            'products' => array('label' => __('Products'), 'href' => '/admin/'),
            'settings' => array('label' => __('Settings'), 'href' => '/admin/')
        );
	}

	public function index() {
	}

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
