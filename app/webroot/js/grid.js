/* TODO:
- filter values
- events and callbacks
- handle filters
- handle pagination (icons, page, limit)
- refactor $('self.container + ' .someclass') => $('.someclass', $self)
- refactor self.settings.pagination => self.paging
- refactor all code into modules
*/
Grid = function(container, columns, data, settings, actions) {
	var self = this;

	// self.container = ;
	$self = $(container);

	self.columns = [];
	self.data = [];
	self.model = 'Article';
	self.settings = {
		primaryKey: 'id',
		baseURL: window.location.href,
		checkRecords: true,
		showActions: true,
		perPageList: [5, 10, 20, 50, 100, 1000],
		pagination: {curr: 0, total: 0, count: ''}
	};
	self.actions = {
		table: [
			{icon: 'icon-add', label: 'Add records'},
			{icon: 'icon-filter-settings', class: 'grid-show-filter', label: 'Show filter settings'}
		],
		row: [
			{icon: 'icon-edit', label: 'Default Действие 1'},
			{icon: 'icon-delete', label: 'Default Действие 2'}
		],
		checked: [
			{icon: 'icon-edit', label: 'Default Действие 1'},
			{icon: 'icon-star', label: 'Default Действие 2'}
		]
	};

	this.init = function(container, columns, data, settings, actions) {
		self.initColumns(columns);
		self.initSettings(settings);
		self.initActions(actions);
		self.setData(data);
		self.render();
		self.bindCheckAll();
		self.bindCheckboxes();
		self.bindFilter();
		self.bindPagination();
	}

	this.initColumns = function(columns) {
		self.columns = columns;
		for(var i = 0; i < self.columns.length; i++) {
			var col = self.columns[i];
			if (typeof(col.format) != 'undefined') {
				if (col.format == 'bool' || col.format == 'date' || col.format == 'datetime') {
					self.columns[i].align = 'center';
				} else if (col.format == 'num')  {
					self.columns[i].align = 'right';
				}
			} else {
				self.columns[i].format = 'string';
			}
			if (typeof(col.align) == 'undefined') {
				self.columns[i].align = 'left';
			}
		}
	}

	this.initSettings = function(settings) {
		self.settings  = $.extend(self.settings, settings);
	}

	this.setData = function(data) {
		self.data = data;
	}

	this.render = function() {
		var html = '<table class="grid table-bordered">';
		html+= self.renderTableHeader();
		html+= '<tbody>';
		html+= self.renderBody();
		html+= self.renderTableFooter();
		html+= '</tbody></table>';
		$self.html(html);
	}

	this.renderTableHeader = function() {
		var html = '<thead>';
		html+= this.renderTableColumns();
		html+= this.renderTableFilter();
		html+= '</thead>';
		return html;
	}

	this.renderTableColumns = function() {
		var html = '<tr class="first table-gradient">';
		html+= '<th><input type="checkbox" rel="tooltip" title="Check All" class="grid-chbx-checkAll"></th>';
		html+= self.renderTableActions();
		html+= self.renderColumns();
		html+= '</tr>';
		return html;
	}

	this.initActions = function(actions) {
		self.actions = $.extend(self.actions, actions);
		for(var i in self.actions) {
			for(var j = 0; j < self.actions[i].length; j++) {
				if (typeof(self.actions[i][j].href) == 'undefined') {
					self.actions[i][j].href = 'javascript:void(0)';
				}
				if (typeof(self.actions[i][j].class) == 'undefined') {
					self.actions[i][j].class = '';
				}
			}
		}
	}

	this.renderTableActions = function() {
		var html = '<th class="nowrap">';
		html+= self.renderActions();
		html+= '</th>';
		return html;
	}

	this.renderActions = function() {
		var html = '';
		for(var i = 0; i < self.actions.table.length; i++) {
			var action = self.actions.table[i];
			html+= '<a class="' + action.class + '" href="' + action.href + '" rel="tooltip" title="' + action.label + '"><i class="' + action.icon + '"></i></a>';
		}
		return html;
	}

	this.renderColumns = function() {
		var html = '';
		for(var i = 0; i < self.columns.length; i++) {
			html+= self.renderColumn(self.columns[i]);
		}
		return html;
	}

	this.renderColumn = function(col) {
		var html = '<th class="nowrap"><a href="#" class="' + col.sort + '">' + col.label + '</a></th>';
		return html;
	}

	this.renderTableFilter = function() {
		var html= '<tr class="grid-filter hide">';
		html+= '<th></th>';
		html+= '<th>';
		html+= '<a class="icon-in-bg icon-accept-filter" href="#" rel="tooltip" title="Apply filter setting"></a>';
		html+= '<a class="icon-in-bg icon-clear-filter" href="#" rel="tooltip" title="Clear filter setting"></a>';
		html+= '</th>';
		for(var i = 0; i < self.columns.length; i++) {
			html+= self.renderTableFilterCell(self.columns[i]);
		}
		html+= '</tr>';
		return html;
	}

	this.renderTableFilterCell = function(col) {
		var html = '<th>';
		if (col.format == 'bool') {
			html+= self.renderFilterBool(col);
		} else if (col.format == 'date') {
			html+= self.renderFilterDate(col);
		} else {
			html+= self.renderFilterString(col);
		}
		html+= '</th>';
		return html;
	}

	this.renderFilterBool = function(col) {
		options = {'': '- any -', '1': 'yes', '0': 'no'};
		return self.renderFilterSelect(col.key, options);
	}

	this.renderFilterDate = function(col) {
		return '<input type="text" class="grid-filter-input grid-filter-date">';
	}

	this.renderFilterString = function(col) {
		return '<input type="text" class="big-input grid-filter-input" rel="tooltip" title="" data-original-title="Enter title mask (* - any char)">';
	}

	this.renderFilterSelect = function(name, options) {
		var html = '<select class="input-small grid-filter-input" name="gridFilter[' + name + ']">';
		for (var i in options) {
			html+= '<option value="' + i + '">' + options[i] + '</option>';
		}
		html+= '</select>';
		return html;
	}

	this.renderBody = function() {
		var html = '';
		for(var i = 0; i < self.data.length; i++) {
			html+= '<tr class="grid-row">';
			html+= self.renderRow(self.data[i]);
			html+= '</tr>';
		}
		return html;
	}

	this.renderRow = function(rowData) {
		var id = self.settings.primaryKey;
		var keyValue = rowData[self.model][id];
		var html = '<td class="align-center"><input type="checkbox" class="grid-chbx-row" name="gridChecked[]" value="' + keyValue + '"></td>';
		html+= self.renderTableRowActions(rowData);
		for(var i = 0; i < self.columns.length; i++) {
			fieldInfo = self.columns[i];
			html+= self.renderTableCell(rowData[self.model][fieldInfo.key], fieldInfo, rowData);
		}
		return html;
	}

	this.renderTableRowActions = function(rowData) {
		var html = '<td class="nowrap aling-center">';
		html+= self.renderRowActions(rowData);
		html+= '</td>';
		return html;
	}

	this.renderRowActions = function(rowData) {
		var html = '';
		for(var i = 0; i < self.actions.row.length; i++) {
			var actionData = self.actions.row[i];
			var action = '<a href="' + actionData.href + '" title="' + actionData.label + '"><i class="' + actionData.icon + '"></i></a>';
			html+= action;
		}
		return html;
	}

	this.renderTableCell = function(value, col, rowData) {
		var _class = new Array();
		if (col.align == 'center') {
			_class.push('align-center');
		} else if (col.align == 'right') {
			_class.push('align-right');
		}
		if (typeof(col.nowrap) != 'undefined' && col.nowrap) {
			_class.push('nowrap');
		}
		if (col.format == 'text') {
			_class.push('format-text');
		}
		var td = '<td';
		var attr = _class.join(' ');
		if (attr) {
			td+= ' class="' + attr + '"';
		}
		td+= '>';
		return td + self.renderCell(value, col, rowData) + '</td>';
	}

	this.renderCell = function(value, col, rowData) {
		if (value === null) {
			return '';
		}
		if (col.format == 'text') {
			return '<span>' + value + '</span>';
		}
		if (col.format == 'bool') {
			return (value) ? '<i class="icon-in-bg icon-check"></i>' : '';
		}
		if (col.key == 'teaser') {

		}
		return value;
	}

	this.renderTableFooter = function() {
		var html = '<tr id="last-tr" class="grid-footer table-gradient"><td colspan="10" class="nowrap">';
		html+= self.renderFooter();
		html+= '</td></tr>';
		return html;
	}

	this.renderFooter = function() {
		var html = '<table><tbody><tr>';
		html+= self.renderTableCheckedActions();
		html+= self.renderTablePagination();
		html+= self.renderTableRecordsCount();
		html+= '</tr></tbody></table>';
		return html;
	}

	this.renderTableCheckedActions = function() {
		var html = '<td style="width: 30%">';
		html+= self.renderCheckedActions();
		html+= '</td>';
		return html;
	}

	this.renderCheckedActions = function() {
		var html = '<div class="grid-checked-actions hide"><small></small><div class="btn-group">';
		html+= '<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#"><span class="caret"></span></a>';
		html+= '<ul class="dropdown-menu">';
		for(var i = 0; i < self.actions.checked.length; i++) {
			var action = self.actions.checked[i];
			html+= '<li><a href="' + action.href + '"><i class="' + action.icon + '"></i> ' + action.label + '</a></li>';
		}
		html+= '</ul>';
		html+= '</div></div>';
		return html;
	}

	this.renderTablePagination = function() {
		var html = '<td style="width: 40%" class="align-center grid-pagination">';
		html+= self.renderPageIcons();
		html+= self.renderItemsPerPage();
		html+= '</td>';
		return html;
	}

	this.renderPageIcons = function() {
		var html = '';
		var pagination = self.settings.pagination;
		if (pagination.total > 1) {
			html = '<span>Страница</span>';
			if (pagination.curr > 1) {
				html+= '<a class="grid-pagination-first" href="javascript:void(0)" title="Go to first page"><i class="icon-first"></i></a>';
				html+= '<a class="grid-pagination-prev" href="javascript:void(0)" title="Go to previous page"><i class="icon-prev"></i></a>';
			}
			html+= '<input type="text" class="grid-pagination-page" value="' + pagination.curr + '" style="width: 17px;">';
			if (pagination.curr < pagination.total) {
				html+= '<a class="grid-pagination-next" href="javascript:void(0)" title="Go to next page"><i class="icon-next"></i></a>';
				html+= '<a class="grid-pagination-last" href="javascript:void(0)" title="Go to last page"><i class="icon-last"></i></a>';
			}
		}
		return html;
	}

	this.renderItemsPerPage = function() {
		var html = '<span>по</span><select>';
		for(var i = 0; i < self.settings.perPageList.length; i++) {
			html+= '<option>' + self.settings.perPageList[i] + '</option>'
		}
		html+= '</select><span>записей на странице</span>';
		return html;
	}

	this.renderTableRecordsCount = function() {
		var html = '<td style="width: 30%" class="align-right grid-records-count">';
		html+= self.renderRecordsCount();
		html+= '</td>';
		return html;
	}

	this.renderRecordsCount = function() {
		var pagination = self.settings.pagination;
		if (pagination.count) {
			return '<span>' + pagination.count + '</span>';
		}
		return '';
	}

	this.bindCheckAll = function() {
		$('.grid-chbx-checkAll', $self).change(function(){
			var allChecked = this.checked;
			$('.grid-chbx-row', $self).each(function(){
				this.checked = allChecked;
				var tr = $(this).parent().parent();
				tr.removeClass('grid-row-selected');
				if (allChecked) {
					tr.addClass('grid-row-selected');
				}
			});
			self.updateCheckedActions();
		});

	}

	this.bindCheckboxes = function() {
		$('.grid-chbx-row', $self).change(function(){
			$(this).parent().parent().toggleClass('grid-row-selected');
			self.updateCheckedActions();
		});
	}

	this.updateCheckedActions = function() {
		var checked = $('.grid-chbx-row:checked', $self).size();
		$('.grid-checked-actions', $self).removeClass('hide');
		if (!checked) {
			$('.grid-checked-actions', $self).addClass('hide');
		} else {
			$('.grid-checked-actions small', $self).html(checked + ' records checked');
		}
	}

	this.bindFilter = function() {
		$(' .grid-show-filter', $self).click(function(){
			$('.grid-filter', $self).toggleClass('hide');
		});
		$('.grid-filter-date', $self).datepicker({
			dateFormat: "dd.mm.yy",
			buttonImage: "img/calendar.png",
			showOn: "button",
			buttonImageOnly: true,
			changeYear: true
		});
	}

	this.bindPagination = function() {
		$('.grid-pagination-page', $self).change(function(){
			self.settings.pagination.curr = this.value;
			self.update();
		});
	}

	this.getURL = function() {
		var url = self.settings.baseURL;
		// handle pagination
		var pagination = self.settings.pagination;
		if (pagination.curr) {
			url+= '/page:' + pagination.curr;
		}
		return url;
	}

	this.update = function() {
		console.log(self.getURL());
		window.location.href = self.getURL();
	}

	self.init(container, columns, data, settings, actions);
}