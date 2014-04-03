<?php
App::uses('AppHelper', 'View/Helper');
class ObjectTypeHelper extends AppHelper {
    public $helpers = array('Html');
    
    private function _getTitles() {
        $Titles = array(
            'index' => array(
                'Article' => __('Articles'),
                'Page' => __('Static pages'),
                'News' => __('News'),
                'Category' => __('Categories')
            ), 
            'create' => array(
                'Article' => __('Create Article'),
                'Page' => __('Create Static page'),
                'News' => __('Create News article'),
                'Category' => __('Create Category')
            ),
            'edit' => array(
                'Article' => __('Edit Article'),
                'Page' => __('Edit Static page'),
                'News' => __('Edit News article'),
                'Category' => __('Edit Category')
            )
        );
        return $Titles;
    }
    
    public function getTitle($action, $object_type) {
        $aTitles = $this->_getTitles();
        return (isset($aTitles[$action][$object_type])) ? $aTitles[$action][$object_type] : $aTitles[$action]['Article'];
    }
    
    public function getBaseURL($object_type) {
        return $this->Html->url(array('action' => 'index', $object_type));
    }
}