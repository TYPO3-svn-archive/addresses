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
		tpl : new Ext.Template(
			'<p style="margin-left:45px;"><b>' + Addresses.lang.name + ' :</b> {first_name} {last_name}</p>' +
			'<br/>'
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
		width: 50,
		header : '&nbsp;',
		renderer: function(val) {
			output = '<img class="pointer" src="' + configuration.iconsPath + 'pencil.png" onclick="Address.window.load(\'edit\')"/>&nbsp;&nbsp;';
			output += '<img class="pointer" src="' + configuration.iconsPath + 'clip_copy.gif" onclick="Address.window.load(\'copy\')"/>';
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
			root: 'rows',
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
			Address.window.load('multipleEdit');
		}
	},
	'-',
	{
		id: 'deleteButton',
		text: Addresses.lang.delete_selected,
		icon: configuration.iconsPath + '/delete.gif',
		cls: 'x-btn-text-icon',
		disabled: true,
		handler: function() {
			Address.grid.deleteSelectedRecord();
		}
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
		selModel: configuration.checkbox,
		tbar: configuration.topBar,
		bbar: configuration.bottomBar,
		listeners: {
			dblclick: function(e) {
				Address.window.load('edit');
			},
			keypress: function(key) {
				if (key.keyCode == key.DELETE) {
					this.deleteSelectedRecord();
				}
			}
		},


		/**
		 * Returns a formated string: "first_name last_name"
		 *
		 * @return String
		 */
		getSelectedNames: function() {
			var items = Address.grid.getSelectionModel().getSelections();
			var names = '';
			for (var index = 0; index < items.length; index ++) {
				var item = items[index];
				// Add ',' separtor
				if (index > 0) {
					names += ', ';
				}
				names += item.data.first_name + ' ' + item.data.last_name;
			}
			return names;
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
		deleteSelectedRecord: function() {
			var dataSet = Address.grid.getSelectedUids();

			Ext.Msg.show({
				title: Addresses.lang.remove,
				buttons: Ext.MessageBox.YESNO,
				msg: Addresses.lang.are_you_sure + ' ' + Address.grid.getSelectedNames() + '?',
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
		}

	});

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
	 * Resizes the grid to fit the window
	 *
	 * 
	 **/
	// Resize grid
	var elements = ['x-grid3-scroller', 'x-panel-body', 'x-grid3'];
	for (var index = 0; index < elements.length; index ++) {
		var element = elements[index];
		Ext.select('.' + element).setStyle({
			height: window.innerHeight - 200 + 'px'
		});
	}
//		grid.getView().getRowClass = function(record, index){
//			var cssStyle = (record.data.change<0.7 ? (record.data.change<0.5 ? (record.data.change<0.2 ? 'red-row' : 'green-row') : 'blue-row') : '');
//			return 'red-row';
//		};
};
