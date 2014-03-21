<div class="span8 offset2">
<?=$this->element('admin_title', array('title' => $pageTitle))?>
<?
    echo $this->PHForm->create('Article');
	echo $this->element('admin_tabs', array('aTabs' => array(
		'General' => $this->element('Article.edit'),
		'Text' => $this->element('Article.edit_body'),
		'Media' => $this->element('Media.edit'),
	)));
	echo $this->element('Form.form_actions', array('backURL' => $this->Html->url($baseRoute)));
    echo $this->PHForm->end();
?>
</div>