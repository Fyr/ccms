<?php
App::uses('AdminController', 'Controller');
class AdminContentController extends AdminController {
    public $name = 'AdminContent';
    public $components = array('Article.PCArticle');
    public $uses = array('Article.Article', 'Media.Media');
    
    private function _getBaseRoute($object_type) {
        return array('action' => 'index', $object_type);
    }
    
    public function index($object_type) {
        $this->paginate = array(
            'conditions' => array('Article.object_type' => $object_type),
            'fields' => array('id', 'created', 'title', 'slug')
        );
        if ($object_type == 'News') {
            $this->paginate['fields'] = array('id', 'created', 'title', 'slug', 'teaser', 'published');
        }
        $this->PCArticle->index();
        $this->set('baseRoute', $this->_getBaseRoute($object_type));
        $aTitles = array(
            'Page' => __('Static pages'),
            'News' => __('News')
        );
        $pageTitle = (isset($aTitles[$object_type])) ? $aTitles[$object_type] : 'Articles';
        $this->set('pageTitle', $pageTitle);
    }
    
    public function edit($id = 0, $object_type = '') {
        $this->PCArticle->edit(&$id, &$lSaved);
        $baseRoute = $this->_getBaseRoute(($id) ? $this->request->data('Article.object_type') : $object_type);
        if ($lSaved) {
            return $this->redirect(($this->request->data('apply')) ? $baseRoute : array($id));
        }
        $this->set('baseRoute', $baseRoute);
        if ($id) {
            $pageTitle = __('Edit Article');
            $aTitles = array(
                'Page' => __('Edit Static page'),
                'News' => __('Edit News article')
            );
        } else {
            $pageTitle = __('Create Article');
            $aTitles = array(
                'Page' => __('Create Static page'),
                'News' => __('Create News article')
            );
        }
        $pageTitle = (isset($aTitles[$object_type])) ? $aTitles[$object_type] : $pageTitle;
        $this->set('pageTitle', $pageTitle);
    }
}
