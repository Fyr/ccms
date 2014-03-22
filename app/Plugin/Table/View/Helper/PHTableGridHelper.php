<?php
App::uses('AppHelper', 'View/Helper');
class PHTableGridHelper extends AppHelper {
    public $helpers = array('Paginator', 'Html');
    private $paginate;
        
    private function _getDefaults($modelName, $options = array()) {
        $defaulOptions = array(
            'baseURL' => $this->Html->url(array('')),
            'actions' => $this->getDefaultActions($modelName)
        );
        return $defaulOptions;
    }

    /**
     * Used to reassign Grid actions.
     *
     * @param str $modelName
     * @return array
     */
	public function getDefaultActions($modelName) {
		$table = array(
			'add' => array('class' => 'icon-color icon-add', 'label' => __('Add record'), 'href' => $this->Html->url(array('action' => 'edit'))),
			'filter' => array('class' => 'icon-color icon-filter-settings grid-show-filter', 'label' => __('Show filter settings'))
		);
		$backURL = $this->Html->url(array('action' => 'index'));
		$editURL = $this->Html->url(array('action' => 'edit', '{$id}'));
		$deleteURL = $this->Html->url(array('action' => 'delete', '{$id}'));
		$deleteURL = urldecode($deleteURL).'?model='.$modelName.'&backURL='.urlencode($backURL);
		$row = array(
			'edit' => array('class' => 'icon-color icon-edit', 'label' => __('Edit record'), 'href' => urldecode($editURL)),
			// array('class' => 'icon-color icon-delete', 'label' => __('Delete record'), 'href' => urldecode($deleteURL).'?model='.$modelName.'&backURL='.urlencode($backURL))
			'delete' => $this->Html->link('', $deleteURL, array('class' => 'icon-color icon-delete'), __('Are you sure to delete this record?'))
		);
		$checked = array(
			array('icon' => 'icon-color icon-delete', 'label' => __('Delete checked records'))
		);
		return compact('table', 'row', 'checked');
	}

	public function render($modelName, $options = array()) {
		$this->Html->css('/Table/css/grid', array('inline' => false));
		$this->Html->script('/Table/js/grid', array('inline' => false));
		$this->Html->css('/Icons/css/icons', array('inline' => false));

		$this->paginate = $this->viewVar('_paginate.'.$modelName);
		$container_id = 'grid_'.$modelName;
		$paging = array(
			'curr' => intval($this->Paginator->counter(array('model' => $modelName, 'format' => '{:page}'))),
			'total' => intval($this->Paginator->counter(array('model' => $modelName, 'format' => '{:pages}'))),
			'count' => $this->Paginator->counter(array('model' => $modelName, 'format' => __('Shown {:start}-{:end} of {:count} records'))),
		);
		$defaults = Hash::get($this->paginate, '_defaults');
		$options = Hash::merge($this->_getDefaults($modelName), $options);
		
		// Т.к. я добавил ключи в $actions, для JS их надо выкосить
		$actions = $options['actions'];
		foreach($actions as $type => $array) {
            $actions[$type] = array_values($array);
		}
		
		$html = '
<span id="'.$container_id.'"></span>
<script type="text/javascript">
$(document).ready(function(){
	var config = {
		container: "#'.$container_id.'",
		columns: '.json_encode($this->paginate['_columns']).',
		data: '.json_encode($this->paginate['_rowset']).',
		paging: '.json_encode($paging).',
		settings: {model: "'.$modelName.'", baseURL: "'.$options['baseURL'].'"},
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