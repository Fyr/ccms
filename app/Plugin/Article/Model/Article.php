<?php
App::uses('AppModel', 'Model');
class Article extends AppModel {

	public $validate = array(
		'title' => 'notempty'
	);
}
