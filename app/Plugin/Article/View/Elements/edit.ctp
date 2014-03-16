<?
	$this->Html->script('/Article/js/translit_utf', array('inline' => false));
	$this->Html->css('/Icons/css/icons', array('inline' => false));

	echo $this->PHTableForm->create('Article', array('url' => '#tab-Article'));
	echo $this->PHTableForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => 'Published', 'featured' => 'Featured'), 'class' => 'checkbox inline'));
	echo $this->PHTableForm->input('title', array('onkeyup' => 'article_onChangeTitle()'));
	echo $this->PHTableForm->input('slug', array('onchange' => 'article_onChangeSlug()'));
	echo $this->PHTableForm->input('teaser');
	// echo $this->PHTableForm->editor('body');
	echo $this->element('Table.btn_save');
	echo $this->PHTableForm->hidden('Media.object_type', array('value' => 'Article'));
	echo $this->PHTableForm->hidden('Media.object_id', array('value' => $this->request->data('Article.id')));
	echo $this->PHTableForm->end();
?>
<script type="text/javascript">
var slug_EditMode = <?=(($this->request->data('Article.slug'))) ? 'true' : 'false'?>;
function article_onChangeTitle() {
	if (!slug_EditMode) {
		$('#ArticleSlug').val(translit($('#ArticleTitle').val()));
	}
}

function article_onChangeSlug() {
	slug_EditMode = ($('#ArticleSlug').val() && true);
}

function translit(str) {
	return ru2en.tr_url(str);
}
</script>
