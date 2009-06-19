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

Addresses.initGrid = function() {

	var configuration = new Object();
	Addresses.utility = new Object();

	/**
	 * Defines the resource path
	 */
	configuration.iconsPath = '../Module/Resources/Public/Icons/';
	//	configuration.ajaxPath = '../../../../';

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
			output = '<img class="pointer" src="' + configuration.iconsPath + 'pencil.png" onclick="Addresses.window.display(\'edit\')"/>&nbsp;&nbsp;';
			output += '<img class="pointer" src="' + configuration.iconsPath + 'clip_copy.gif" onclick="Addresses.window.display(\'copy\')"/>';
			return output;
		},
		dataIndex: 'uid'
	});

	/**
	 * Datasource
	 */
	configuration.datasource = new Ext.data.Store({
		storeId: 'addresses_datasource',
		autoLoad: true,
		reader: new Ext.data.JsonReader({
			fields: Addresses.fieldsStore,
			root: 'data',
			totalProperty: 'total'
		}),
		baseParams: {
			ajaxID: 'tx_addresses::indexAction',
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
	 * interval incremented
	 */
	Addresses.interval = 0;

	/**
	 * Starts counting. Useful for progress bars
	 */
	Addresses.startInterval = function() {

		// Defines interval
		var count = 0;
		Addresses.interval = window.setInterval(function() {
			count = count + 0.04;

			Ext.Msg.updateProgress(count);

			// reset counter
			if(count >= 1) {
				count = 0;
			}
		}, 100);
	};

	/**
	 * Top bar which is attached to the grid
	 */
	configuration.topbar = [
	{
		text: Addresses.lang.add,
		icon: configuration.iconsPath + 'accept.png',
		cls: 'x-btn-text-icon',
		handler: function() {
			Addresses.window.setTitle(Addresses.lang.new_record); // set title
			Addresses.form.reset(); // clear form
			Addresses.window.findById('informationPanel').setVisible(false);
			Addresses.window.show();
			Addresses.window.focusOnFirstVisibleField();
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
			Addresses.window.display('multipleEdit');
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
			var data = Addresses.grid.getSelectedUids();

			Ext.Msg.show({
				title: Addresses.lang.remove,
				buttons: Ext.MessageBox.YESNO,
				msg: Addresses.lang.are_you_sure + ' ' + Addresses.grid.getSelectedNames() + '?',
				fn: function(btn){
					if (btn == 'yes' && data.length > 0){
						var conn = new Ext.data.Connection();
						conn.request({
							method: 'GET',
							url: Addresses.statics.ajaxController,
							params:{
								ajaxID: 'tx_addresses::deleteAction',
								data: Ext.util.JSON.encode(data)
							},
							success: function(f,a){
								Ext.StoreMgr.get('addresses_datasource').load();
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
	configuration.bottomBar = [{
		id: 'recordPaging',
		xtype: 'paging',
		store: configuration.datasource,
		pageSize: Addresses.statics.pagingSize,
		refreshText: '',
		lastText: '',
		nextText: '',
		prevText: '',
		firstText: ''
	}];


	// adjust columns layout + render the grid
	Addresses.fieldsGrid.unshift(configuration.checkbox, configuration.expander); // add checkbox + expander to the grid
	Addresses.fieldsGrid.push(configuration.controller);
	
	/**
	 * Initializes the grid
	 *
	 * @return void
	 **/
	Addresses.grid = new Ext.grid.GridPanel({
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
		columns: Addresses.fieldsGrid,
		selModel: configuration.checkbox,
		tbar: configuration.topbar,
		bbar: configuration.bottomBar,
		listeners: {
				
			dblclick: function(e) {
				Addresses.window.display('edit');
			}
		},


		/**
	 * Returns a formated string: "first_name last_name"
	 *
	 * @return String
	 */
		getSelectedNames: function() {
			var items = Addresses.grid.getSelectionModel().getSelections();
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
			return Addresses.grid.getSelectionModel().getSelections();
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
		}
	});

	/**
	 * Initializes the listener on the selection
	 *
	 * @return void
	 **/
	Addresses.grid.getSelectionModel().on(
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

Ext.Message = function(){
	var msgCt;

	function createBox(t, s){
		return ['<div class="msg">',
		'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
		'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3>', t, '</h3>', s, '</div></div></div>',
		'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
		'</div>'].join('');
	}
	return {
		msg : function(title, format){
			if(!msgCt){
				msgCt = Ext.DomHelper.insertFirst(document.body, {
					id:'msg-div'
				}, true);
			}
			msgCt.alignTo(document, 't-t');
			var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
			var m = Ext.DomHelper.append(msgCt, {
				html:createBox(title, s)
			}, true);
			m.slideIn('t').pause(1).ghost("t", {
				remove:true
			});
		},

		init : function(){
			var t = Ext.get('exttheme');
			if(!t){ // run locally?
				return;
			}
			var theme = Cookies.get('exttheme') || 'aero';
			if(theme){
				t.dom.value = theme;
				Ext.getBody().addClass('x-'+theme);
			}
			t.on('change', function(){
				Cookies.set('exttheme', t.getValue());
				setTimeout(function(){
					window.location.reload();
				}, 250);
			});

			var lb = Ext.get('lib-bar');
			if(lb){
				lb.show();
			}
		}
	};
}();


//Addresses.utility = {
//	updatePageTree: function() {
//		if (top && top.content && top.content.nav_frame && top.content.nav_frame.Tree) {
//			top.content.nav_frame.Tree.refresh();
//		}
//	}
//};