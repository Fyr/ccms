
MediaGrid = function(config) {
	var self = this;

	self.container = config.container;
	$self = $(config.container);

	self.data = [];
	self.settings = {
		model: 'Media',
		primaryKey: 'Media.id',
	};
	
	this.init = function(config) {
		// load template
		tmpl('media-info', null);
		
		self.setData(config.data);
		self.actions = config.actions;
		self.update();
	}
	
	this.update = function() {
		self.render();
		self.bindEvents();
	}
	
	this.setData = function(data) {
	    self.data = data;
	}
	
	this.getModelField = function(col_key) {
		var field = col_key.split('.');
		return {model: field[0], field: field[1]};
	}

	this.getValue = function(column_key, rowData) {
		if (self.settings.model) {
			var col = self.getModelField(column_key);
			return rowData[col.model][col.field];
		}
		return rowData[column_key];
	}
	
	this.getID = function(rowData) {
		return self.getValue(self.settings.primaryKey, rowData);
	}
	
	this.getDataByID = function(id) {
		for(var i = 0; i < self.data.length; i++) {
	        if (self.getID(self.data[i]) == id) {
	        	return self.data[i];
	        }
	    }
	    return null;
	}
	
	this.render = function() {
		$('.media-thumbs', $self).html(self.renderThumbs());
		$('.media-info', $self).html('');
	}
	
	this.renderThumbs = function() {
	    var html = '';
	    for(var i = 0; i < self.data.length; i++) {
	        html+= self.renderThumb(self.data[i]);
	    }
	    return html;
	}
	
	this.renderThumb = function(rowData) {
		var _class = 'img-rounded pull-left thumb';
		if (self.getValue('Media.main', rowData)) {
			_class+= ' main-thumb';
		}
		return Format.tag('div', 
			{class: _class, 'data-thumb': self.getID(rowData)}, 
			Format.tag('img', {src: self.getValue('Media.image', rowData), alt: ''})
		);
	}
	
	this.bindEvents = function() {
	    self.bindSelectImage();
	}
	
	this.bindSelectImage = function() {
		$('.media-thumbs .thumb', $self).click(function(){
			$('.thumb').removeClass('selected');
			$(this).addClass('selected');
			self.showInfo($(this).data('thumb'));
		});
	}
	
	this.showInfo = function(id) {
		var rowData = self.getDataByID(id);
		$('.media-info', $self).html(self.renderInfo(rowData[self.settings.model]));
		self.bindInfo(rowData);
	}
	
	this.renderInfo = function(rowData) {
		return tmpl('media-info', rowData);
	}
	
	this.bindInfo = function(rowData) {
		
	}
	
	this.getActionURL = function(url, id) {
		return url.replace(/\{\$id\}/ig, id);
	}
	
	this.actionDelete = function(id) {
		$.get(self.getActionURL(self.actions.delete, id), null, function(response) {
			if (checkJson(response)) {
	            mediaGrid.setData(response.data);
	            mediaGrid.update();
		    }
		});
	}
	
	this.actionSetMain = function(id) {
		$.get(self.getActionURL(self.actions.setMain, id), null, function(response) {
			if (checkJson(response)) {
	            mediaGrid.setData(response.data);
	            mediaGrid.update();
		    }
		});
	}

	self.init(config);
}