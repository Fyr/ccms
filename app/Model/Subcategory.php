<?
App::uses('Article', 'Article.Model');
class Subcategory extends Article {
	
	var $hasOne = array(
		'Category' => array(
			'foreignKey' => 'object_id',
			'dependent' => true
		)
	);

	protected $objectType = 'Subcategory';
	
	/*
	public $belongsTo = array(
		'className' => 'Category',
		'foreing'
	);
	*/
}
