<?
	echo $this->PHTableForm->create('Article', array('id' => 'ArticleEditBodyForm', 'url' => '#tab-Text'));
	echo $this->PHTableForm->editor('body', array('fullwidth' => true));
	echo $this->element('Table.btn_save');
	echo $this->PHTableForm->hidden('Article.id', array('value' => $this->request->data('Article.id')));
	echo $this->PHTableForm->end();
