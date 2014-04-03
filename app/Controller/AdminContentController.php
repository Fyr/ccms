<?php
App::uses('AdminController', 'Controller');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Media.Media');
    public $helpers = array('ObjectType');
    
    public function index($objectType) {
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
        	)
        );
        
        $data = $this->PCArticle->setModel($objectType)->index();
        $this->set('objectType', $objectType);
    }
    
    public function edit($id = 0, $objectType = '') {
        if (!$id && $objectType) {
            $this->request->data('Article.object_type', $objectType);
        }
        $this->PCArticle->edit(&$id, &$lSaved);
        if ($lSaved) {
            $baseRoute = array('action' => 'index', $this->request->data('Article.object_type'));
            return $this->redirect(($this->request->data('apply')) ? $baseRoute : array($id));
        }
    }
}
