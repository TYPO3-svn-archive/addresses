/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009 Fabien Udriot <fabien.udriot@ecodev.ch>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * ExtJS for the 'addresses' extension.
 * Contains the Addresses functions
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

Address.initGrid = function() {

	// Overrides weird translation (At least for French)
	if(Ext.PagingToolbar) {
		Ext.apply(Ext.PagingToolbar.prototype,{
			displayMsg: Addresses.lang.paging_label
		});
	}

	// Defines variables
	Address.utility = new Object();
	var configuration = new Object();

	/**
	 * Defines the resource path
	 */
	configuration.iconsPath = '../Module/Resources/Public/Icons/';

	/**
	 * Row expander (plugins)
	 */
	configuration.expander = new Ext.grid.RowExpander({
		tpl : new Ext.XTemplate(
			'{expander}'
			)
	});

	/**
	 * Row checkbox
	 */
	configuration.checkbox = new Ext.grid.CheckboxSelectionModel({
		singleSelect: false
	});

	/**
	 * Controller
	 */
	configuration.controller = new Object({
		width: 70,
		header : '&nbsp;',
		renderer: function(val) {
			//			output = '<img class="pointer" src="' + configuration.iconsPath + 'zoom.png" alt="view" onclick=""/>&nbsp;';
			output = '<img class="pointer" src="' + configuration.iconsPath + 'pencil.png" alt="edit" onclick="Address.window.edit(\'single\')"/>&nbsp;';
			output += '<img class="pointer" src="' + configuration.iconsPath + 'clip_copy.png" alt="copy" onclick="Address.window.edit(\'copy\')"/>&nbsp;';
			output += '<img class="pointer" src="' + configuration.iconsPath + 'garbage.png" alt="delete" onclick="Address.grid.deleteRecords()"/>&nbsp;';
			return output;
		},
		dataIndex: 'uid'
	});
	
	/**
	 * Datasource
	 */
	configuration.datasource = new Ext.data.Store({
		storeId: 'addressStore',
		autoLoad: true,
		reader: new Ext.data.JsonReader({
			fields: Address.gridFieldsType,
			root: 'records',
			totalProperty: 'total'
		}),
		baseParams: {
			ajaxID: 'AddressController::indexAction',
			limit: Addresses.statics.pagingSize
		},
		remoteSort: true,
		//		groupField: 'locality',
		//		sortInfo: {
		//			field: 'locality',
		//			direction: "ASC"
		//		},
		proxy: new Ext.data.HttpProxy({
			method: 'GET',
			url: Addresses.statics.ajaxController
		}),
		listeners : {
			load: function (element, data) {
				// Decides whether to sort server side or client side
				if (element.reader.jsonData.total > element.getCount()) {
					element.remoteSort = true;
				}
				else {
					element.remoteSort = false;
				}
				
				// @debug like a double click on the first row
//				var sm = Address.grid.getSelectionModel();
//				sm.selectFirstRow();
//				Address.window.edit('single');
			}
		}

	});

	/**
	 * Top bar which is attached to the grid
	 */
	configuration.topBar = [
	{
		text: Addresses.lang.add,
		icon: configuration.iconsPath + 'accept.png',
		cls: 'x-btn-text-icon',
		handler: function() {
			Address.window.setTitle(Addresses.lang.new_record); // set title
			Address.window.show();
			Address.window.focusOnFirstVisibleField();
		}
	},
	'-',
	{
		id: 'multipleEditionButton',
		text: Addresses.lang.edit_selected,
		icon: configuration.iconsPath + 'pencil.png',
		cls: 'x-btn-text-icon',
		disabled: true,
		handler: function() {
			Address.window.edit('multiple');
		}
	},
	'-',
	{
		id: 'deleteButton',
		text: Addresses.lang.delete_selected,
		icon: configuration.iconsPath + '/garbage.png',
		cls: 'x-btn-text-icon',
		disabled: true,
		handler: function() {
			Address.grid.deleteRecords();
		}
	},
	{
		id: 'expandButton',
		text: Addresses.lang.expand_all,
		icon: configuration.iconsPath + '/expand.png',
		cls: 'x-btn-text-icon'
	},
	{
		id: 'collapseButton',
		text: Addresses.lang.collapse_all,
		icon: configuration.iconsPath + '/collapse.png',
		cls: 'x-btn-text-icon'
	},
	'->',
	new Ext.app.SearchField({
		id: 'searchField',
		store: configuration.datasource,
		width: 200
	})
	];

	/**
	 * Bottom Bar
	 */
	configuration.bottomBar = {
		id: 'gridPaging',
		xtype: 'paging',
		store: configuration.datasource,
		pageSize: Addresses.statics.pagingSize,
		plugins: new Ext.ux.ProgressBarPager(),
		displayInfo: true
	};

	// adjust columns layout + render the grid
	Address.gridFields.unshift(configuration.checkbox, configuration.expander); // add checkbox + expander to the grid
	Address.gridFields.push(configuration.controller);
	
	/**
	 * Initializes the grid
	 *
	 * @return void
	 **/
	Address.grid = new Ext.grid.GridPanel({
		/**
		 * Public property
		 */
		id: 'addresses_grid',
		renderTo: Addresses.statics.renderTo,
		store: configuration.datasource,
		//			view: new Ext.grid.GroupingView(),
		width:'99%',
		height: 200,
		fitHeight: true,
		frame:false,
		title: Addresses.lang.title,
		iconCls:'icon-grid',
		buttonAlign: 'left',
		loadMask: {
			msg: Addresses.lang.loading
		},
		plugins: configuration.expander,
		columns: Address.gridFields,
		sm: configuration.checkbox,
		tbar: configuration.topBar,
		bbar: configuration.bottomBar,
		viewConfig: {
			forceFit: true
		},

		/**
		 * Listeners
		 */
		listeners: {
			click: function(event) {
				// Don't send mousedown event
				// - clicking on the checkbox
				// - clicking on icon edit
				// - clicking on the expander icon
				if (event.getTarget().className != 'x-grid3-row-checker' 
					&& event.getTarget().className != 'pointer'
					&& event.getTarget().className != 'x-grid3-row-expander') {

					var parentNode = event.getTarget('div.x-grid3-row');
					if (parentNode) {
						var expander = Ext.query('.x-grid3-row-expander', parentNode)[0];
						Ext.util.fireEvent(expander, 'mousedown');
					}
				}
			},
			dblclick: function() {
				Address.window.edit('single');
			},
			keypress: function(key) {
				if (key.keyCode == key.DELETE) {
					this.deleteRecords();
				}
			}
		},

		/**
		 * Returns a formated string: "first_name last_name"
		 *
		 * @return String
		 */
		getDeleteMessage: function() {
			var items = Address.grid.getSelectionModel().getSelections();
			var message = '';
			if (items.length <= 5) {
				for (var index = 0; index < items.length; index ++) {
					var item = items[index];
					// Add ',' separtor
					if (index > 0) {
						message += ', ';
					}
					message += item.data.first_name + ' ' + item.data.last_name;
				}
				message = Addresses.lang.are_you_sure.replace('{0}', message);
			}
			else {
				message = Addresses.lang.remove_selected_records;
				message = message.replace('{0}', items.length);
			}
			return message;
		},

		/**
		 * Returns the selected items
		 *
		 * @return Array
		 */
		getSelection: function() {
			return Address.grid.getSelectionModel().getSelections();
		},


		/**
		 * Return an array containing the selected uid
		 *
		 * @return Array
		 */
		getSelectedUids: function() {
			var items = this.getSelection();
			var data = new Array();
			for (var index = 0; index < items.length; index ++) {
				// Get selections
				var item = items[index];
				data[index] = {
					uid: item.data.uid
				};
			}
			return data;
		},

		/**
		 * Delete selected records
		 *
		 * @return void
		 */
		deleteRecords: function() {
			var dataSet = Address.grid.getSelectedUids();

			Ext.Msg.show({
				title: Addresses.lang.remove,
				buttons: Ext.MessageBox.YESNO,
				msg: Address.grid.getDeleteMessage(),
				fn: function(btn){
					if (btn == 'yes' && dataSet.length > 0){
						var conn = new Ext.data.Connection();
						conn.request({
							method: 'GET',
							url: Addresses.statics.ajaxController,
							params:{
								ajaxID: 'AddressController::deleteAction',
								dataSet: Ext.util.JSON.encode(dataSet)
							},
							success: function(f,a){
								Ext.StoreMgr.get('addressStore').load();
							},
							failure: function(f,a){
								if (a.failureType === Ext.form.Action.CONNECT_FAILURE) {
									Ext.Msg.alert('Failure', 'Server reported: ' + a.response.status + ' ' + a.response.statusText);
								}
								else if (a.failureType === Ext.form.Action.SERVER_INVALID) {
									Ext.Msg.alert('Warning', a.result.errormsg);
								}
								else {
									Ext.Msg.alert('Warning', 'Unknow error');
								}

							}
						});
					}
				}
			});
		},

		/**
		 * Expands / collapse all rows
		 *
		 * @access public
		 * @scope Address.grid
		 */
		expand: function(element, event) {
			var numberOfRows = this.getStore().getCount();

			for (index = 0; index < numberOfRows; index++) {
				var row = this.getView().getRow(index);
				if (!Ext.get(row).hasClass('x-grid3-row-expanded')) {
					var expander = Ext.query('.x-grid3-row-expander', row)[0];
					Ext.util.fireEvent(expander, 'mousedown');
				}
			}
		},

		/**
		 * Expands / collapse all rows
		 *
		 * @access public
		 * @scope Address.grid
		 */
		collapse: function(element, event) {
			var numberOfRows = this.getStore().getCount();

			for (index = 0; index < numberOfRows; index++) {
				var row = this.getView().getRow(index);
				if (Ext.get(row).hasClass('x-grid3-row-expanded')) {
					var expander = Ext.query('.x-grid3-row-expander', row)[0];
					Ext.util.fireEvent(expander, 'mousedown');
				}
			}
		},

		/**
		 * show / hide the controller cell (i.e the cell that contains the icons)
		 *
		 * @access public
		 */
		showControlIcons: function(event, element) {

			// this= a row of the grid
			var gridView = Address.grid.getView();

			// Find out the column index
			var columnIndex = gridView.findRowIndex(element);

			var row = gridView.getRow(columnIndex);

			// Find the image that belons to the controll cell
			var images = Ext.query('img[alt=edit]', row);

			// ... and Find out the cell index
			var cellIndex = Address.grid.getView().findCellIndex(images[0]);

			// Get reference of the cell that contains the control icon
			var controlIconCell = gridView.getCell(columnIndex, cellIndex);

			// Makes it invisible
			Ext.get(controlIconCell).setStyle({
				visibility: this.visibility
			})

		}

	});

	// Attaches event
	Ext.getCmp('expandButton').on ('click', Address.grid.expand, this.grid);
	Ext.getCmp('collapseButton').on ('click', Address.grid.collapse, this.grid);

	/**
	 * Initializes the listener on the selection
	 *
	 * @return void
	 **/
	Address.grid.getSelectionModel().on(
		'selectionchange',
		function(selModel) {
			// Other possible writing
			//				var toolbar = this.grid.getTopToolbar();
			//				toolbar.items.get('multipleEditionButton').setDisabled(false);
			Ext.ComponentMgr.get('multipleEditionButton').setDisabled(selModel.getCount() === 0);
			Ext.ComponentMgr.get('deleteButton').setDisabled(selModel.getCount() === 0);
		},
		this,
		{
			buffer:10
		}
		);

	/**
	 * Attach event when the grid is refreshed.
	 */
	Address.grid.getView().on({
		refresh: function() {
			var numberOfRows = this.grid.getStore().getCount();

			for (index = 0; index < numberOfRows; index++) {

				// By default, hide the cell that contains the controller icon
				var row = this.grid.getView().getRow(index);
				var images = Ext.query('img[alt=edit]', row)[0];
				Ext.get(images).parent('td').setStyle({
					visibility: 'hidden'
				});

				// Attache some event
				Ext.get(row).on('mouseenter', Address.grid.showControlIcons, {
					visibility: 'visible'
				});
				Ext.get(row).on('mouseleave', Address.grid.showControlIcons, {
					visibility: 'hidden'
				});
			}
		}
	});

	/**
	 * Resizes the grid to fit the window
	 *
	 * 
	 **/
	// Resize grid
	var elements = ['x-grid3-scroller', 'x-panel-body', 'x-grid3'];
	for (var index = 0; index < elements.length; index ++) {
		var element = elements[index];
		Ext.select('.' + element).setStyle({
			height: window.innerHeight - 120 + 'px'
		});
	}

//		grid.getView().getRowClass = function(record, index){
//			var cssStyle = (record.data.change<0.7 ? (record.data.change<0.5 ? (record.data.change<0.2 ? 'red-row' : 'green-row') : 'blue-row') : '');
//			return 'red-row';
//		};
};
