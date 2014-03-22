<?
	echo $this->PHForm->input('status', array('label' => false, 'multiple' => 'checkbox', 'options' => array('published' => 'Published', 'featured' => 'Featured'), 'class' => 'checkbox inline'));
	echo $this->PHForm->input('title', array('onkeyup' => 'article_onChangeTitle()'));
	echo $this->element('Article.edit_slug');
	echo $this->PHForm->input('teaser');
	echo $this->PHForm->hidden('Media.object_type', array('value' => 'Article'));
	echo $this->PHForm->hidden('Media.object_id', array('value' => $this->request->data('Article.id')));
	$url = $this->Html->url(array('plugin' => '', 'controller' => 'admin', 'action' => 'delete')).'/{$id}?model=Media.Media&backURL='.urlencode($this->Html->url(array())).'#tab-Media';
	echo $this->PHForm->hidden('Media.backURL', array('value' => $url));
