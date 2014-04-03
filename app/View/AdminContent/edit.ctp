<div class="span8 offset2">
<?
    $id = $this->request->data('Article.id');
    $objectType = $this->request->data('Article.object_type');
    $pageTitle = $this->ObjectType->getTitle(($id) ? 'edit' : 'create', $objectType);
    echo $this->element('admin_title', array('title' => $pageTitle));
    echo $this->PHForm->create('Article');
    $aTabs = array(
        'General' => $this->element('/AdminContent/admin_edit_'.$objectType),
		'Text' => $this->element('Article.edit_body')
    );
    if ($id) {
        $aTabs['Media'] = $this->element('Media.edit', array('object_type' => $objectType, 'object_id' => $id));
    }
	echo $this->element('admin_tabs', compact('aTabs'));
	echo $this->element('Form.form_actions', array('backURL' => $this->ObjectType->getBaseURL($objectType)));
    echo $this->PHForm->end();
?>
</div>