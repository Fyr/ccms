<?php
/**
 * Wrapper for standart Form helper
 * Customizes HTML inputs for filters and uses the same parameters for Form helper methods
 */
App::uses('FormHelper', 'View/Helper');
class InputHelper extends FormHelper {
	// var $helpers = array('Form', 'Html');
	public function create($model, $options = array()) {
		$options['class'] = (isset($options['class']) && $options['class']) ? $options['class'] : 'form-horizontal';
		$options['inputDefaults'] = (isset($options['inputDefaults']) && $options['inputDefaults']) ? $options['inputDefaults'] : array(
			'div' => 'control-group',
			'label' => array('class' => 'control-label'),
			'between' => '<div class="controls">',
			'after' => '</div>'
		);
		return parent::create($model, $options);
	}

	public function input($fieldName, $options = array()) {
		$this->setEntity($fieldName);
		$options = $this->_parseOptions($options);
		if ($options['type'] == 'checkbox') {
			$options['format'] = array('before', 'label', 'between', 'input', 'after', 'error');
		}
		return parent::input($fieldName, $options);
	}

	public function submit($fieldName = 'Save', $options = array()) {
		$options = array_merge(array('class' => 'btn btn-primary', 'div' => 'form-actions'), $options);
		return parent::submit($fieldName, $options);
	}

	/**
	 * Create a input with CKEditor
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function editor($fieldName, $options = array()) {
		$this->Html->script('vendor/ckeditor/ckeditor.js', array('inline' => false));
		$options = array_merge(array('class' => 'ckeditor'), $options);
		// $options['class'] = 'ckeditor '.$options['class'];
		/*
		$label = $this->label($options['id'], $options['label']);
		return '<div class="control-group">'.$label.'<div class="clearfix"></div>'.$this->Form->textarea($name, $options).'</div>';
		*/
		return parent::input($fieldName, $options);
	}
}