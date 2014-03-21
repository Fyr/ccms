<?
	$this->Html->script('/Article/js/translit_utf', array('inline' => false));

	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => 'Published', 'featured' => 'Featured'), 'class' => 'checkbox inline'));
	echo $this->PHForm->input('title', array('onkeyup' => 'article_onChangeTitle()'));
	echo $this->PHForm->input('slug', array('onchange' => 'article_onChangeSlug()'));
	echo $this->PHForm->input('teaser');
	// echo $this->PHForm->editor('body');
	echo $this->PHForm->hidden('Media.object_type', array('value' => 'Article'));
	echo $this->PHForm->hidden('Media.object_id', array('value' => $this->request->data('Article.id')));
	$url = $this->Html->url(array('plugin' => '', 'controller' => 'admin', 'action' => 'delete')).'/{$id}?model=Media.Media&backURL='.urlencode($this->Html->url(array())).'#tab-Media';
	echo $this->PHForm->hidden('Media.backURL', array('value' => $url));
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
