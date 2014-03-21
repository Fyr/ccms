<?php
App::uses('Component', 'Controller');
class PCArticleComponent extends Component {
	private $_;

	public function initialize(Controller $controller) {
		$this->_ = $controller;
	}

	public function index() {
		$this->PCTableGrid = $this->_->Components->load('Table.PCTableGrid');
		$this->PCTableGrid->initialize($this->_);
		if (!isset($this->_->paginate)) {
    		$this->_->paginate = array(
    			'fields' => array('id', 'created', 'title', 'teaser', 'slug', 'published')
    		);
		}
		$this->PCTableGrid->paginate('Article');
	}

	public function edit($id = 0, $lSaved = false) {
		$aFlags = array('published', 'featured');
		if ($this->_->request->is('post') || $this->_->request->is('put')) {
			if ($id && !$this->_->request->data('Article.id')) {
				// auto add ID for update a record
				$this->_->request->data('Article.id', $id);
			}
			if (is_array($this->_->request->data('Article.status'))) {
				foreach($aFlags as $field) {
					$this->_->request->data('Article.'.$field, in_array($field, $this->_->request->data('Article.status')));
				}
			}
			if ($this->_->Article->save($this->_->request->data)) {
				$id = $this->_->Article->id;
				$lSaved = true;
			}
		} elseif ($id) {
			$article = $this->_->Article->findById($id);

			// Set up flags
			foreach($aFlags as $field) {
				if ($article['Article'][$field]) {
					$article['Article']['status'][] = $field;
				}
			}
			$this->_->request->data = array_merge($this->_->request->data, $article);
		}
	}
}