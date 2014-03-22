<div class="span8 offset2">
<?
    $id = $this->request->data('Article.id');
    $object_type = $this->request->data('Article.object_type');
    $pageTitle = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', $object_type);
?>
<?=$this->element('admin_title', array('title' => $pageTitle))?>
<?
    echo $this->PHForm->create('Article');
	echo $this->element('admin_tabs', array('aTabs' => array(
		'General' => $this->element('Article.edit'),
		'Text' => $this->element('Article.edit_body'),
		'Media' => $this->element('Media.edit'),
	)));
	echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL($object_type)));
    echo $this->PHForm->end();
?>
</div>