<?php
/**
 * Wrapper for standart Form helper
 * Customizes HTML inputs for filters and uses the same parameters for Form helper methods
 */
App::uses('AppHelper', 'View/Helper');
class PHTableInputHelper extends AppHelper {
	var $helpers = array('Form', 'Html');

	/**
	 * Renders a input with decoration for form
	 *
	 * @param string $label
	 * @param string $field
	 * @param string $error
	 * @return string
	 */
	protected function render($label, $field, $error = false) {
		return '<div class="control-group">'.$label.'<div class="controls">'.$field.'</div></div>';
	}

	protected function getModelField($name) {
		$key = explode('.', $name);
		if (count($key) <= 1) {
			$key[1] = $key[0];
			$key[0] = '';
		}
		return array('model' => $key[0], 'field' => $key[1]);
	}

	/**
	 * Generates ID for filter inputs
	 *
	 * @param str $name - name of filter
	 * @return str
	 */
	protected function getID($name) {
		return str_replace('.', '_', $name);
	}

	/**
	 * Generates label for input
	 *
	 * @param str $id
	 * @param str $text
	 * @return str
	 */
	protected function label($id, $text) {
		return $this->Form->label($id, $text, array('class' => 'control-label'));
	}

	protected function getLabel($name) {
		$key = $this->getModelField($name);
		return __(ucfirst($key['field']));
	}

	protected function getName($name) {
		return 'data['.str_replace('.', '][', $name).']';
	}

	protected function getValue($name) {
		return '';
	}

	protected function getClass($name) {
		return 'autocompleteOff';
	}

	protected function getDefaultOptions($name) {
		$defaultOptions = array(
			'label' => $this->getLabel($name),
			'name' => $this->getName($name),
			'class' => $this->getClass($name),
			'required' => false,
			'id' => $this->getID($name),
			'value' => $this->getValue($name)
		);
		return $defaultOptions;
	}

	/**
	 * Create a text input
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function text($name, $options = array()) {
		$options = array_merge($this->getDefaultOptions($name), $options);
		$label = $this->label($options['id'], $options['label']);
		// unset($options['label']);
		return $this->render($label, $this->Form->text($name, $options));
	}

	/**
	 * Create a select input
	 *
	 * @param string $name - field name
	 * @param array $aValueOptions - options for select
	 * @param array $options - input options
	 * @return string
	 */
	public function select($name, $aValueOptions, $options = array()) {
		$options = array_merge($this->getDefaultOptions($name), $options);
		$label = $this->label($options['id'], $options['label']);
		$options['empty'] = false;
		return $this->render($label, $this->Form->select($name, $aValueOptions, $options));
	}

	/**
	 * Create a checkbox input
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function checkbox($name, $options = array()) {
		$defaults = $this->getDefaultOptions($name);
		$options = array_merge($defaults, $options);
		$label = $this->label($options['id'], $options['label']);
		return $this->render($label, $this->Form->checkbox($name, $options));
	}

	/**
	 * Create a group of checkboxes
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function checkboxGroup(array $_name, $_options = array()) {
		$label = (isset($_options['label']) && $_options['label']) ? $this->label('', $_options['label']) : '';
		$html = '';
		foreach($_name as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
				$options = array();
			}
			$defaults = $this->getDefaultOptions($key);
			$options = array_merge($defaults, $options);
			$html.= '<label class="checkbox">'.$this->Form->checkbox($key, $options).' <span>'.$options['label'].'</span></label>';
		}
		return $this->render($label, $html);
	}

	/**
	 * Create a input with CKEditor
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function editor($name, $options = array()) {
		$this->Html->script('vendor/ckeditor/ckeditor.js', array('inline' => false));
		$options = array_merge($this->getDefaultOptions($name), $options);
		$options['class'].= ' ckeditor';
		$options['cols'] = 80;
		$options['rows'] = 10;
		$label = $this->label($options['id'], $options['label']);
		return '<div class="control-group">'.$label.'<div class="clearfix"></div>'.$this->Form->textarea($name, $options).'</div>';
	}

	/**
	 * Create a date filter
	 *
	 * @param str $name
	 * @param array $options
	 * @return str
	 */

	/*
	public function date($name, $options = array()) {
		$created = $this->viewVar('filterValues', str_replace('.', '\.', $name));
		$id = $this->getID($name);
		$defaultOptions = array(
			'id' => $id,
			'name' => $id,
			'class' => 'autocompleteOff',
			'placeholder' => __('mm.dd.YYYY'),
			'required' => false,
			'value' => $created,
			'style' => 'width: 100px'
		);

		$datepickerOptions = array();
		if (isset($options['datepicker'])) {
			$datepickerOptions = $options['datepicker'];
			unset($options['datepicker']);
		}
		$options = array_merge($defaultOptions, $options);
		$id = $options['id'];
		$options['id'] = 'input_'.$options['id'];
		$options['name'] = 'input_'.$options['name'];
		$created = $options['value'];
		$options['value'] = $this->DateTime->formatDate($options['value'], '%m.%d.%Y', '');

		$label = '';
		if (isset($options['label'])) {
			$label = $this->label($options['id'], $options['label']).' ';
			unset($options['label']);
		}
		$_id = 'filter_'.$id;
		$hidden = $this->Form->hidden($name, array(
			'id' => $_id,
			'name' => 'filter['.$name.']',
			'value' => $created
		));

		$datepickerDefaultOptions = array(
			'dateFormat' => '"mm.dd.yy"',
			'altField' => '"#'.$_id.'"',
			'altFormat' => '"yy-mm-dd"'
		);
		$js = '
<script type="text/javascript">
$(document).ready(function(){
	$("#'.$options['id'].'").datepicker({
		'.$this->A->implode(', ', ': {$value}', array_merge($datepickerDefaultOptions, $datepickerOptions)).'
	});
	$("#'.$options['id'].'").change(function(){
		if (!this.value) {
			$("#'.$_id.'").val("");
		}
	});
});
</script>';
		$html = $label.$this->Form->text($name, $options).$hidden.$js;
		return ($label) ? $this->container($html) : $html;
	}
*/
	/**
	 * Create 2 date filter inputs for dates range
	 *
	 * @param str $name
	 * @param array $options
	 * @param str $name2
	 * @param array $options2
	 * @return str
	 */
	/*
	public function dateRange($name, $options = array(), $name2 = '', $options2 = array()) {
		$name2 = ($name2)? $name2 : $name.'2';
		$id = 'input_'.$this->getID($name);
		$id2 = 'input_'.$this->getID($name2);

		$created = $this->viewVar('filterValues', str_replace('.', '\.', $name));
		$created2 = $this->viewVar('filterValues', str_replace('.', '\.', $name2));

		$defaultOptions = array(
			'datepicker' => array(
				'onClose' => 'function(selectedDate) {
					$("#'.$id2.'").datepicker("option", "minDate", selectedDate);
				}'
			)
		);

		if ($created2) {
			$defaultOptions['datepicker']['maxDate'] = '"'.$this->DateTime->formatDate($created2, '%m.%d.%Y', '').'"';
		}
		$options = array_merge($defaultOptions, $options);
		$label = '';
		if (isset($options['label'])) {
			$label = $this->label($id, $options['label']).' ';
			unset($options['label']);
		}
		$date = $this->date($name, $options);

		$defaultOptions = array(
			'datepicker' => array(
				'onClose' => 'function(selectedDate) {
					$("#'.$id.'").datepicker("option", "maxDate", selectedDate);
				}'
			)
		);
		if ($created) {
			$defaultOptions['datepicker']['minDate'] = '"'.$this->DateTime->formatDate($created, '%m.%d.%Y', '').'"';
		}
		$options2 = array_merge($defaultOptions, $options2);
		$date2 = $this->date($name2, $options2);
		return $this->container($label.$date.__('until').'&nbsp;'.$date2);
	}
	*/

	/**
	 * Create a group of buttons
	 *
	 * @param string $name - field name
	 * @param array $options - input options
	 * @return string
	 */
	public function buttonGroup(array $_name) {
		$html = '';
		foreach($_name as $key => $options) {
			if (is_numeric($key)) {
				$key = $options;
				$options = array();
			}
			$options = array_merge($this->getDefaultOptions($key), $options);
			$options['type'] = (isset($options['type']) && $options['type']) ? $options['type'] : 'button';
			$options['class'] = 'btn '.$options['class'];
			$html.= $this->Form->button($key, $options).' ';
		}
		return '<div class="form-actions">'.$html.'</div>';
	}
}