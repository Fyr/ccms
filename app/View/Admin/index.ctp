<script type="text/javascript">
var opts = <?=json_encode(array('' => '- any -', '1' => 'yes', '0' => 'no'))?>;
// $(document).ready(function(){
	var data = <?=json_encode($aArticles)?>;
	var columns = [
			{key: 'created', label: 'Created', tooltip: 'Sort field Aaa ascending (0..9, A..Z)', format: 'date'},
			{key: 'title', label: 'Название', tooltip: 'Sort field Aaa ascending (0..9, A..Z)'},
			{key: 'teaser', label: 'Текстовое поле 2', tooltip: 'Order by textfield2', format: 'text', showFilter: false},
			{key: 'published', label: 'Published', tooltip: '', format: 'boolean'},
			{key: 'id', label: 'Numeric', tooltip: '', format: 'integer'}
		];
	/*
	var actions = {
		row: [
			{href: '/admin/edit/{$id}', icon: 'icon-edit', label: 'Действие 1'},
			{href: '/admin/delete/{$id}', icon: 'icon-delete', label: 'Действие 2'}
		],
		checked: [
			{href: '#', icon: 'icon-edit', label: 'Действие 1'},
			{href: '#', icon: 'icon-star', label: 'Действие 2'}
		]
	};
	*/
	var paging = {
		curr: <?=$this->Paginator->counter(array('model' => 'Article', 'format' => '{:page}'))?>,
		total: <?=$this->Paginator->counter(array('model' => 'Article', 'format' => '{:pages}'))?>,
		count: '<?=$this->Paginator->counter(array('model' => 'Article', 'format' => __('Shown {:start}-{:end} of {:count} records')))?>',
	};
	var config = {
		container: '#grid',
		columns: columns,
		data: data,
		paging: paging,
		settings: {model: 'Article', baseURL: '<?=$this->Html->url(array(''))?>', showFilter: true},
	};
// });
</script>
	<div class="span12">
		<h3 class="text-center">Заголовок h1 перед таблицей</h3>
		<?=$this->PHGrid->render('Article')?>
	</div>

