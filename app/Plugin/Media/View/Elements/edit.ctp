<?
/**
 * Renders Media Widget
 * @param str $object_type
 * @param int $object_id
 */
	$this->Html->css(array('jquery.fileupload-ui', '/Table/css/grid', '/Icons/css/icons', '/Media/css/media'), array('inline' => false));
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
	<table width="100%">
	<tr>
		<td width="20%" valign="middle">
            <span class="btn btn-primary fileinput-button">
    	        <i class="icon-plus icon-white"></i>
    	        <span><?=__('Upload files...');?></span>
    	        <input id="fileupload" type="file" name="files[]" multiple>
    	    </span>
		</td>
		<td width="80%" align="center" valign="middle">
			<div id="progress" class="progress progress-primary progress-striped" style="margin-bottom: 0;">
                <div class="bar"></div>
            </div>
		</td>
	</tr>
	</table>
	<br/>
	<table class="media-grid" width="100%">
	<tr>
		<td class="media-thumbs" width="65%">
			<!-- thumbs content here -->
		</td>
		<td class="media-info" width="35%">
			<script type="text/x-tmpl" id="media-info">
				<button type="button" class="btn btn-success" onclick="mediaGrid.actionSetMain({%=o.id%})"><i class="icon-white icon-ok"></i> <?=__('Set as main')?></button>
				<button type="button" class="btn btn-danger" onclick="if (confirm('<?=__('Are your sure to delete this record?')?>')) { mediaGrid.actionDelete({%=o.id%}); }"><i class="icon-white icon-trash"></i> <?=__('Delete')?></button>
				<br/>
				<h5><?=__('Original image')?></h5>
				<?=__('Uploaded')?>: {%=o.created%}<br/>
				<?=__('File size')?>: {%=Format.fileSize(o.file_size)%}<br/>
				<!--button type="button" class="btn btn-mini" onclick="media_enlarge({%=o.id%})"><i class="icon-search"></i> <?=__('Enlarge')?></button-->
				<h5><?=__('Links')?></h5>
				<?=__('Original size')?>:<br/>
				<input type="text" id="media-url-orig" value="/media/router/index/{%=o.object_type%}/{%=o.id%}/noresize/{%=o.file%}{%=o.ext%}" readonly="readonly" onfocus="this.select()" />
				<?=__('For editor')?>:<br/>
				<input type="text" id="media-url-orig" value="/media/router/index/{%=o.object_type%}/{%=o.id%}/400x/{%=o.file%}{%=o.ext%}" readonly="readonly" onfocus="this.select()" />
				<h5><?=__('Resize')?></h5>
				<div>
					<?=__('Width')?> x <?=__('Height')?>: <input type="text" id="media-w" name="" value="" onfocus="this.select()" onchange="mediaGrid.updateImageURL({%=o.id%})" /> x
					<input type="text" id="media-h" value="" onfocus="this.select()" onchange="mediaGrid.updateImageURL({%=o.id%})" />
					<button type="button" class="btn"><i class="icon icon-refresh"></i></button>
				</div>
				<?=__('Media URL')?>: <input type="text" id="media-url" value="" readonly="readonly" onfocus="this.select()" />
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