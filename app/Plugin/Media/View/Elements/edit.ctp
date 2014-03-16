<?
	$this->Html->css(array('jquery.fileupload-ui', '/Table/css/grid'), array('inline' => false));
	$this->Html->script(array('/Table/js/grid', 'vendor/jquery/jquery.iframe-transport', 'vendor/jquery/jquery.fileupload'), array('inline' => false));
?>
<style type="text/css">
.grid {width: 96%}
</style>
	<table style="width:96%; margin: 0 2%">
	<tr>
		<td width="30%">
			<span class="btn btn-primary fileinput-button">
	        <i class="icon-plus icon-white"></i>
	        <span><?=__('Upload files...');?></span>
	        <!-- The file input field used as target for the file upload widget -->
	        <input id="fileupload" type="file" name="files[]" multiple>
	    </span>
		</td>
		<td width="40%" align="center">
			<?=$this->element('ajax_loader')?>
		</td>
		<td width="30%">&nbsp;</td>
	</tr>
	<tr>
	   <td colspan="3">
            <div id="progress" class="progress progress-success progress-striped">
                <div class="bar"></div>
            </div>
	   </td>
	</tr>
	</table>
	<span id="grid"></span>
<script>
var uploadURL = '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'upload'))?>';
var moveURL = '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'move.json'))?>';
var listURL = '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'getList.json'))?>';
var mediaGrid = null, lProcess = false;
var mediaData = null;
$(function () {
    'use strict';
    var config = {
		container: '#grid',
		settings: {showFilter: false, model: 'Media'},
		data: mediaData,
		columns: [
			{key: 'image', showSorting: false, format: 'img', align: 'center'},
			{key: 'image', label: 'URL', showSorting: false}/*,
			{key: 'size', label: 'File size', format: 'filesize'},
			{key: 'main', label: 'Main image', showSorting: false}*/
		],
		actions: {
			table: [],
			row: [
				{class: 'icon-color icon-preview', label: 'Open image'},
				{class: 'icon-color icon-delete', label: 'Delete record', href: '/admin/delete/Media/{$id}'}
			]
		}
	}
	$.get(listURL, null, function(response){
	    config.data = response.data;
        mediaGrid = new Grid(config); 
	});
	// 
    $('#fileupload').fileupload({
        url: uploadURL,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                file.object_type = $('#MediaObjectType').val();
                file.object_id = $('#MediaObjectId').val();
                $.post(moveURL, file, function(response){
                    mediaGrid.setData(response.data);
                    mediaGrid.render();
                }, 'json');
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