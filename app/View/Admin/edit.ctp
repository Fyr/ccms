<div class="span8 offset2">
<?=$this->element('admin_title', array('title' => __('Edit article')))?>
<?
	echo $this->element('admin_tabs', array('aTabs' => array(
		'Article' => $this->element('Article.edit'),
		'Text' => $this->element('Article.edit_body'),
		'Media' => $this->element('Media.edit'),
	)));
?>
</div>
