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

Addresses.Main = function(){

	/**
	 * Defines the resource path
	 */
	this.iconsPath = '../Resources/Public/Icons/';

	/**
	 * Row expander (plugins)
	 */
	this.expander = new Ext.grid.RowExpander({
		tpl : new Ext.Template(
			'<p style="margin-left:45px;"><b>' + Addresses.lang.name + ' :</b> {firstname} {lastname}</p>' +
			'<br/>'
			)
	});

	/**
	 * Row checkbox
	 */
	this.checkbox = new Ext.grid.CheckboxSelectionModel({
		singleSelect: false
	});

	/**
	 * Controller
	 */
	this.controller = new Object({
		width: 50,
		renderer: function(val) {
			output = '<img id="edit-' + val + '" class="pointer" src="' + main.iconsPath + 'pencil.png" onclick="main.showWindow(this)"/>&nbsp;&nbsp;';
			output += '<img id="copy-' + val + '" class="pointer" src="' + main.iconsPath + 'clip_copy.gif" onclick="main.showWindow(this)"/>';
			return output;
		},
		dataIndex: 'uid'
	});

	/**
	 * Mode could be either copy or new
	 */
	this.showWindow = function(element) {
		var sm = this.grid.getSelectionModel();
		var selections = sm.getSelections();
		var data = new Array();
		for (var index = 0; index < selections.length; index ++) {
			// Get selections
			var selection = selections[index];
			data[index] = {
				uid: selection.data.uid
			};
		}

		if (data.length > 0) {
			var w = Ext.ComponentMgr.get('addresses_window');
			var form = w.getComponent('editForm').getForm()
			form.reset(); // clear form

			Ext.Msg.progress(Addresses.lang.loading, '');
			main.startInterval();

			form.load({
				method: 'GET',
				url: '/typo3/ajax.php',
				params:{
					method: 'GET',
					ajaxID: 'tx_addresses::editAction',
					data: Ext.util.JSON.encode(data)
				},
				text: 'Loading',
				success: function() {
					
					// Set title
					if (element.id == 'multipleEditionButton') {
						w.setTitle(Addresses.lang.multiple_update_record); // set title
					}
					else if(element.id.search('edit-') != -1) {
						w.setTitle(Addresses.lang.update_record); // set title
					}
					else {
						// Removes the id so that the server will consider the data as a new record
						form.findField('uid').setValue('');
						w.setTitle(Addresses.lang.copy_record); // set title
					}

					window.clearInterval(Addresses.Main.interval);
					Ext.Msg.hide();
					w.show();

					main.focusOnFirstVisibleField();
				}
			});
		}
	}

	/**
	 * Visible columns part of the grid
	 */
	this.columns = new Array();

	/**
	 * Datasource
	 */
	this.datasource = new Ext.data.Store({
		storeId: 'addresses_datasource',
		autoLoad: true,
		reader: new Ext.data.JsonReader({
			fields: Addresses.fieldsName,
			root: 'data',
			totalProperty: 'total'
		}),
		baseParams: {
			ajaxID: 'tx_addresses::indexAction',
			limit: Addresses.statics.pagingSize
		},
		remoteSort: true,
		//		groupField: 'city',
		//		sortInfo: {
		//			field: 'city',
		//			direction: "ASC"
		//		},
		proxy: new Ext.data.HttpProxy({
			method: 'GET',
			url: '/typo3/ajax.php'
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
	this.interval = 0;

	/**
	 * Starts counting. Useful for progress bars
	 */
	this.startInterval = function() {

		// Defines interval
		var count = 0;
		Addresses.Main.interval = window.setInterval(function() {
			count = count + 0.04;

			Ext.Msg.updateProgress(count);

			// reset counter
			if(count >= 1) {
				count = 0;
			}
		}, 100);
	};

	/**
	 * Returns the selected items
	 *
	 * @return Array
	 */
	this.getSelection = function() {
		return this.grid.getSelectionModel().getSelections();
	}


	/**
	 * Return an array containing the selected uid
	 *
	 * @return Array
	 */
	this.getSelectedUids = function() {
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


	/**
	 * Returns a formated string: "firstname lastname"
	 *
	 * @return String
	 */
	this.getSelectedNames = function() {
		var items = this.grid.getSelectionModel().getSelections();
		var names = '';
		for (var index = 0; index < items.length; index ++) {
			var item = items[index];
			// Add ',' separtor
			if (index > 0) {
				names += ', ';
			}
			names += item.data.firstname + ' ' + item.data.lastname;
		}
		return names;
	}

	/**
	 * Set focus on the first field
	 */
	this.focusOnFirstVisibleField = function() {
		try {
			var firstVisibleElement = Addresses.fieldsEdition[0].items[1].id
			Ext.ComponentMgr.get(firstVisibleElement).focus(true,100); // wait for 100 miliseconds
		}
		catch (e) {
			console.log(e);
		}
	}

	/**
	 * Top bar which is attached to the grid
	 */
	this.topbar = [
	{
		text: Addresses.lang.add,
		icon: this.iconsPath + 'accept.png',
		cls: 'x-btn-text-icon',
		handler: function() {
			var w = Ext.ComponentMgr.get('addresses_window');
			w.setTitle(Addresses.lang.new_record); // set title
			var form = w.getComponent('editForm').getForm()
			form.reset(); // clear form
			w.show();
			main.focusOnFirstVisibleField();
		}
	},
	'-',
	{
		id: 'multipleEditionButton',
		text: Addresses.lang.edit_selected,
		icon: this.iconsPath + 'pencil.png',
		cls: 'x-btn-text-icon',
		disabled: true,
		handler: function() {
			main.showWindow(this);
		}
	},
	'-',
	{
		id: 'deleteButton',
		text: Addresses.lang.delete_selected,
		icon: this.iconsPath + '/delete.gif',
		cls: 'x-btn-text-icon',
		disabled: true,
		handler: function() {
			var data = main.getSelectedUids()

			Ext.Msg.show({
				title: Addresses.lang.remove,
				buttons: Ext.MessageBox.YESNO,
				msg: Addresses.lang.are_you_sure + ' ' + main.getSelectedNames() + '?',
				fn: function(btn){
					if (btn == 'yes' && data.length > 0){
						var conn = new Ext.data.Connection();
						conn.request({
							method: 'GET',
							url: '/typo3/ajax.php',
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
			})
		}
	},
	'->',
	new Ext.app.SearchField({
		id: 'searchField',
		store: this.datasource,
		width: 200
	})
	];

	/**
	 * Bottom Bar
	 */
	this.bottomBar = [{
		id: 'recordPaging',
		xtype: 'paging',
		store: this.datasource,
		pageSize: Addresses.statics.pagingSize,
		refreshText: '',
		lastText: '',
		nextText: '',
		prevText: '',
		firstText: ''
	}];

	/**
	 * Main grid. Contains all records
	 */
	this.grid = new Object();

	/**
	 * Initializes the grid
	 *
	 * @return void
	 **/
	this.init = function() {
		
		// EXPERIMENTAL GRID
		this.grid = new Ext.grid.GridPanel({
			id: 'addresses_grid',
			renderTo: Addresses.statics.renderTo,
			store: this.datasource,
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
			plugins: this.expander,
			columns: this.columns,
			listeners: this.listeners,
			selModel: this.checkbox,
			tbar: this.topbar,
			bbar: this.bottomBar
		});

		this.grid.getSelectionModel().on(
			'selectionchange',
			function(selModel) {
				// Other possible writing
				//				var toolbar = this.grid.getTopToolbar();
				//				toolbar.items.get('multipleEditionButton').setDisabled(false);
				Ext.ComponentMgr.get('multipleEditionButton').setDisabled(selModel.getCount() == 0);
				Ext.ComponentMgr.get('deleteButton').setDisabled(selModel.getCount() == 0);
			},
			this,
			{
				buffer:10
			}
			);

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
	}
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


Addresses.utility = {
	updatePageTree: function() {
		if (top && top.content && top.content.nav_frame && top.content.nav_frame.Tree) {
			top.content.nav_frame.Tree.refresh();
		}
	}
};