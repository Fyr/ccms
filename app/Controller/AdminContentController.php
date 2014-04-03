<?php
App::uses('AdminController', 'Controller');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Category');
    public $helpers = array('ObjectType');
    
    public function index($objectType, $objectID = '') {
    	// $this->loadModel($objectType);
        $this->paginate = array(
            'Page' => array(
            	'fields' => array('title', 'slug')
            ),
        	'News' => array(
        		'fields' => array('id', 'created', 'title', 'teaser', 'published')
        	),
        	'Category' => array(
        		'fields' => array('id', 'title')
        	),
        	'Subcategory' => array(
        		'conditions' => array('Subcategory.object_id' => $objectID),
        		'fields' => array('id', 'title')
        	)
        );
        
        $data = $this->PCArticle->setModel($objectType)->index();
        $this->set('objectType', $objectType);
        $this->set('objectID', $objectID);
        
        $this->currMenu = $objectType;
        if ($objectType == 'Subcategory' && $objectID) {
        	$this->set('category', $this->Category->findById($objectID));
        	$this->currMenu = 'Cetegory';
        }
        
    }
    
	public function edit($id = 0, $objectType = '', $objectID = '') {
		$this->loadModel('Media.Media');
		
		// Здесь работаем с моделью Article, т.к. если задавать только $id, 
		// непонятно какую модель загружать, чтобы определить $objectType
		$this->loadModel('Article.Article');
		if (!$id) {
			$this->request->data('Article.object_type', $objectType);
			$this->request->data('Article.object_id', $objectID);
		}
		$this->PCArticle->edit(&$id, &$lSaved);
		$objectType = $this->request->data('Article.object_type');
		$objectID = $this->request->data('Article.object_id');
		
		if ($lSaved) {
			$baseRoute = array('action' => 'index', $objectType, $objectID);
			return $this->redirect(($this->request->data('apply')) ? $baseRoute : array($id));
		}
		
		$this->currMenu = $objectType;
		if ($objectType == 'Subcategory' && $objectID) {
        	$this->set('category', $this->Category->findById($objectID));
        	$this->currMenu = 'Cetegory';
        }
	}
}
