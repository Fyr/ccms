<?php
App::uses('AppHelper', 'View/Helper');
class PHTableGridHelper extends AppHelper {
	public $helpers = array('Paginator', 'Html');
	private $paginate;

	private function _getDefaultActions() {
		$table = array(
			array('class' => 'icon-add', 'label' => __('Add record'), 'href' => $this->Html->url(array('action' => 'edit'))),
			array('class' => 'icon-filter-settings grid-show-filter', 'label' => __('Show filter settings'))
		);
		$row = array(
			array('class' => 'icon-edit', 'label' => __('Edit record'), 'href' => urldecode($this->Html->url(array('action' => 'edit', '{$id}')))),
			array('class' => 'icon-delete', 'label' => __('Delete record'))
		);
		$checked = array(
			array('icon' => 'icon-delete', 'label' => __('Delete checked records'))
		);
		return compact('table', 'row', 'checked');
	}

	public function render($modelName, $actions = array()) {
		$this->Html->css('/Table/css/grid', array('inline' => false));
		$this->Html->script('/Table/js/grid', array('inline' => false));

		$this->paginate = $this->viewVar('_paginate.'.$modelName);
		$container_id = 'grid_'.$modelName;
		$paging = array(
			'curr' => $this->Paginator->counter(array('model' => $modelName, 'format' => '{:page}')),
			'total' => $this->Paginator->counter(array('model' => $modelName, 'format' => '{:pages}')),
			'count' => $this->Paginator->counter(array('model' => $modelName, 'format' => __('Shown {:start}-{:end} of {:count} records'))),
		);
		$defaults = Hash::get($this->paginate, '_defaults');
		$actions = Hash::merge($this->_getDefaultActions(), $actions);
		$html = '
<span id="'.$container_id.'"></span>
<script type="text/javascript">
$(document).ready(function(){
	var config = {
		container: "#'.$container_id.'",
		columns: '.json_encode($this->paginate['_columns']).',
		data: '.json_encode($this->paginate['_rowset']).',
		paging: '.json_encode($paging).',
		settings: {model: "'.$modelName.'", baseURL: "'.$this->Html->url(array('')).'"},
		defaults: '.json_encode($defaults).',
		actions: '.json_encode($actions).'
	};
	var '.$container_id.' = new Grid(config);
});
</script>
';
		return $html;
	}
}