<?
App::uses('Article', 'Article.Model');
class Product extends Article {
	/*
	var $hasOne = array(
		'Category' => array(
			'foreignKey' => 'object_id',
			'dependent' => true
		)
	);
*/
	protected $objectType = 'Product';
	
	/*
	public $belongsTo = array(
		'className' => 'Category',
		'foreing'
	);
	*/
}
