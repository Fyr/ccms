<?=$this->element('admin_title', array('title' => $pageTitle))?>
<?=$this->PHTableGrid->render('Article', array('baseURL' => $this->Html->url($baseRoute)));?>