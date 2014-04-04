<?php
App::uses('AdminController', 'Controller');
class AdminProductsController extends AdminController {
    public $name = 'AdminProducts';
    public $components = array('Table.PCTableGrid', 'Article.PCArticle');
    public $uses = array('Category', 'Subcategory', 'Product');
    public $helpers = array('ObjectType');
    
    public function beforeRender() {
    	parent::beforeRender();
    	$this->set('objectType', $this->Product->objectType);
    }
    
    public function index() {
        $this->paginate = array(
           	'fields' => array('id', 'created', 'title', 'teaser', 'published')
        );
        $this->PCTableGrid->paginate('Product');
    }
    
	public function edit($id = 0) {
		$this->loadModel('Media.Media');
		
		$this->set('aCategories', $this->Category->getOptions('Category'));
		$this->set('aSubcategories', $this->Subcategory->find('all', array(
			'fields' => array('id', 'object_id', 'title', 'Category.id', 'Category.title'),
			'order' => 'object_id'
		)));
		
		if (!$id) {
			$this->request->data('Product.object_type', $this->Product->objectType);
		}
		$this->PCArticle->setModel('Product')->edit(&$id, &$lSaved);
		if ($lSaved) {
			$baseRoute = array('action' => 'index');
			return $this->redirect(($this->request->data('apply')) ? $baseRoute : array($id));
		}
	}
}
