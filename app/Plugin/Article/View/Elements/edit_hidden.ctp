<?
    echo $this->PHForm->hidden('Article.object_type', array('value' => $this->request->data('Article.object_type')));
	echo $this->PHForm->hidden('Article.object_id', array('value' => $this->request->data('Article.object_id')));
	echo $this->PHForm->hidden('Media.object_type', array('value' => 'Article'));
	echo $this->PHForm->hidden('Media.object_id', array('value' => $this->request->data('Article.id')));
	$url = $this->Html->url(array('plugin' => '', 'controller' => 'admin', 'action' => 'delete')).'/{$id}?model=Media.Media&backURL='.urlencode($this->Html->url(array())).'#tab-Media';
	echo $this->PHForm->hidden('Media.backURL', array('value' => $url));