<div class="span8 offset2">
<h3 class="text-center">Edit form</h3>
		<form class="form-horizontal table">
		<table class="table table-bordered">
		<tbody>
		<tr>
			<td>
				<?=$this->Input->text('Article.title')?>
				<?=$this->Input->select('Article.object_type', array('1' => 'yes', '2' => 'no'))?>
				<?=$this->Input->checkbox('Article.published')?>
				<?=$this->Input->checkboxGroup(array('Article.published', 'Article.active'), array('label' => 'Status'))?>
				<?=$this->Input->editor('Article.body')?>
				<?=$this->Input->buttonGroup(array('Save' => array('type' => 'submit', 'class' => 'btn-primary'), 'Cancel'))?>
			</td>
		</tr>
		</tbody>
		</table>
		</form>
</div>