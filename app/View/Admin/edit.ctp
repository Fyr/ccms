<?
	$this->Html->css('jquery.fileupload-ui', array('inline' => false));
	$this->Html->script(array('vendor/jquery/jquery.iframe-transport', 'vendor/jquery/jquery.fileupload'), array('inline' => false));
?>
<div class="span8 offset2">
<?=$this->element('admin_title', array('title' => __('Edit title')))?>
	<span class="btn btn-success fileinput-button">
        <i class="icon-plus icon-white"></i>
        <span>Select files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress progress-success progress-striped">
        <div class="bar"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>


		<ul class="nav nav-tabs">
			<li class="active"><a href="#">Главная</a></li>
			<li><a href="#">Профиль</a></li>
			<li><a href="#">Сообщения</a></li>
		</ul>
<?
	echo $this->element('admin_content');
	// fdebug($this->request->data);
	echo $this->PHTableForm->create('Article');
	echo $this->PHTableForm->input('published');
	echo $this->PHTableForm->editor('body');
	echo $this->PHTableForm->submit();
	echo $this->PHTableForm->end();
	echo $this->element('admin_content_end');

	echo $this->element('admin_tabs', array('aTabs' => array('Content' => '!!!', 'Media' => '###')));
?>

		<table class="table table-bordered table-form shadow">
		<tbody>
		<tr>
			<td>
				<form class="form-horizontal" action="" method="post">
				<?=$this->PHTableInput->text('Article.title')?>
				<?=$this->PHTableInput->select('Article.object_type', array('1' => 'yes', '2' => 'no'))?>
				<?//$this->PHTableInput->checkbox('Article.published')?>
				<?//$this->PHTableInput->checkboxGroup(array('Article.published', 'Article.active'), array('label' => 'Status'))?>
				<?=$this->PHTableInput->editor('Article.body')?>
				<?=$this->PHTableInput->buttonGroup(array('Save' => array('type' => 'submit', 'class' => 'btn-primary'), 'Cancel'))?>
				</form>
			</td>
		</tr>
		</tbody>
		</table>

</div>
<script>
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/Admin/upload'; // 'http://test/loader/server/php/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
console.log(data);
            $.each(data.result.files, function (index, file) {
                $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>