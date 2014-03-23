<div class="span8 offset2">
<?
    $id = $this->request->data('Article.id');
    $object_type = $this->request->data('Article.object_type');
    $pageTitle = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', $object_type);
    echo $this->element('admin_title', array('title' => $pageTitle));
    echo $this->PHForm->create('Article');
    $aTabs = array(
        'General' => $this->element('/AdminContent/admin_edit_'.$object_type),
		'Text' => $this->element('Article.edit_body')
    );
    if ($id) {
        $aTabs['Media'] = $this->element('Media.edit', array('object_type' => 'Article', 'object_id' => $id));
    }
	echo $this->element('admin_tabs', compact('aTabs'));
	echo $this->element('Article.edit_hidden');
	echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL($object_type)));
    echo $this->PHForm->end();
?>
</div>