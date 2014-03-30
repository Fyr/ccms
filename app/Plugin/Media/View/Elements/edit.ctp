<?
/**
 * Renders Media Widget
 * @param str $object_type
 * @param int $object_id
 */
	$this->Html->css(array('jquery.fileupload-ui', '/Table/css/grid', '/Icons/css/icons', '/Media/css/thumbs'), array('inline' => false));
	$this->Html->script(array(
	   'vendor/jquery/jquery.iframe-transport', 
	   'vendor/jquery/jquery.fileupload',
	   'vendor/tmpl.min',
	   '/Table/js/grid', 
	   '/Table/js/format', 
	   '/Core/js/json_handler',
	   '/Media/js/media_grid'
	), array('inline' => false));
?>
<style type="text/css">
.grid {width: 96%}
</style>
	<table style="width:96%; margin: 0 2%">
	<tr>
		<td width="20%" valign="middle">
            <span class="btn btn-primary fileinput-button">
    	        <i class="icon-plus icon-white"></i>
    	        <span><?=__('Upload files...');?></span>
    	        <!-- The file input field used as target for the file upload widget -->
    	        <input id="fileupload" type="file" name="files[]" multiple>
    	    </span>
		</td>
		<td width="80%" align="center" valign="middle">
			<div id="progress" class="progress progress-success progress-striped" style="margin-bottom: 0;">
                <div class="bar"></div>
            </div>
		</td>
	</tr>
	</table>
	<br/>
<?
	// $baseURL = $this->ObjectType->getBaseURL($object_type);
	$deleteURL = $this->Html->url(array('plugin' => '', 'controller' => 'admin', 'action' => 'delete'))
		.'/{%=o.id%}?model=Media.Media&backURL={%=escape(window.location.href)%}';
?>
	<table class="media-grid" style="width:96%; margin: 0 2%">
	<tr>
		<td class="media-thumbs" width="65%" style="border-right: 1px solid #ddd; vertical-align: top;padding-right: 10px"></td>
		<td class="media-info" width="35%" style="padding-left: 10px; vertical-align: top;">
			<script type="text/x-tmpl" id="media-info">
				<button type="button" class="btn btn-success" onclick="mediaGrid.actionSetMain({%=o.id%})"><i class="icon-white icon-ok"></i> <?=__('Set as main')?></button>
				<button type="button" class="btn btn-danger" onclick="if (confirm('<?=__('Are your sure to delete this record?')?>')) { mediaGrid.actionDelete({%=o.id%}); }"><i class="icon-white icon-trash"></i> <?=__('Delete')?></button>
				<br/><br/>
				<b>Original image</b><br/>
				Uploaded: {%=o.created%}<br/>
				File size: {%=Format.fileSize(o.file_size)%}<br/>
				<!--button type="button" class="btn btn-mini" onclick="media_enlarge({%=o.id%})"><i class="icon-search"></i> <?=__('Enlarge')?></button-->
			</script>
		</td>
	</tr>
	</table>
<script>
var mediaGrid = null, object_type = '<?=$object_type?>', object_id = <?=$object_id?>;
var mediaURL = {
	upload: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'upload'))?>',
	move: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'move'))?>.json',
	list: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'getList', $object_type, $object_id))?>.json',
	delete: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'delete', $object_type, $object_id))?>/{$id}.json',
	setMain: '<?=$this->Html->url(array('plugin' => 'media', 'controller' => 'ajax', 'action' => 'setMain', $object_type, $object_id))?>/{$id}.json'
};
$(function () {
    'use strict';
	$.get(mediaURL.list, null, function(response){
	    if (checkJson(response)) {
    	    var config = {
    	        container: '.media-grid',
    	        data: response.data,
    	        actions: mediaURL
    	    }
            mediaGrid = new MediaGrid(config);
	    }
	});
    $('#fileupload').fileupload({
        url: mediaURL.upload,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                file.object_type = object_type;
                file.object_id = object_id;
                $.post(mediaURL.move, file, function(response){
                    mediaGrid.setData(response.data);
                    mediaGrid.update();
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