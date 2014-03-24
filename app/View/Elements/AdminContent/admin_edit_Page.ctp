<?
	echo $this->PHForm->input('title', array('onkeyup' => 'article_onChangeTitle()'));
	echo $this->element('Article.edit_slug');
