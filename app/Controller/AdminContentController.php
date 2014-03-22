<?php
App::uses('AdminController', 'Controller');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Article.Article', 'Media.Media');
    public $helpers = array('ObjectType');
    
    public function index($object_type) {
        $this->paginate = array(
            'conditions' => array('Article.object_type' => $object_type),
            'fields' => array('title', 'slug')
        );
        if ($object_type == 'News') {
            $this->paginate['fields'] = array('id', 'created', 'title', 'slug', 'teaser', 'published');
        }
        $this->PCArticle->index();
        $this->set('object_type', $object_type);
    }
    
    public function edit($id = 0, $object_type = '') {
        if (!$id && $object_type) {
            $this->request->data('Article.object_type', $object_type);
        }
        $this->PCArticle->edit(&$id, &$lSaved);
        if ($lSaved) {
            $baseRoute = array('action' => 'index', $this->request->data('Article.object_type'));
            return $this->redirect(($this->request->data('apply')) ? $baseRoute : array($id));
        }
    }
}
