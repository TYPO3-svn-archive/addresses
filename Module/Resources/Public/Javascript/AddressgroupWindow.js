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

Addressgroup.initWindow = function() {

	var configuration = new Object();
	/**
	 * Buttons: save - cancel attached to the form panel
	 */
	configuration.buttons = [{
		text: Addresses.lang.save,
		id: 'addressgroupSaveButton',
		cls: 'x-btn-text-icon',
		icon: 'Resources/Public/Icons/database_save.png',
		listeners: {
			click: function(){
				// DEFINES THE SUBMIT OBJECT
				var submit = {
					clientValidation: true,
					method: 'GET',
					url: Addresses.statics.ajaxController,
					waitMsg: Addresses.lang.saving,
					params:{
						ajaxID: 'AddressgroupController::saveAction'
					},
					success: function(form, call){
						var uid = call.result.rows[0].uid;
						var title = call.result.rows[0].title
						//Add this record to the stores
						Address.stores.addressgroups.add(new Ext.data.Record({
							addressgroups: uid,
							addressgroups_text: title
						},uid));
						Addressgroup.window.hide();
					},
					failure: function(form,call){
						if (call.failureType === Ext.form.Action.CONNECT_FAILURE) {
							Ext.Msg.alert(Addresses.lang.failure, 'Server reported: ' + call.response.status + ' ' + call.response.statusText);
						}
						else if (call.failureType === Ext.form.Action.SERVER_INVALID) {
							Ext.Msg.alert(Addresses.lang.warning, call.result.errormsg);
						}
					}
				};

				// case multiple edition -> don't validate form
				var form = Addressgroup.form
				var uid = form.findField('addressgroupUid').getValue();
				if (uid == '' || uid.search(',') == -1) {
					if (form.isValid()) {
						submit.clientValidation = true;
						form.submit(submit);
						Addressgroup.window.wait();
					}
					else {
						Ext.Msg.alert(Addresses.lang.error, Addresses.lang.fields_error);
					}
				}
				else {
					form.clearInvalid();
					submit.clientValidation = false;
					form.submit(submit);
				}
			}
		}
	},
	{
		text: Addresses.lang.cancel,
		id: 'addressgroupCancelButton',
		cls: 'x-btn-text-icon',
		icon: 'Resources/Public/Icons/filter_clear.png',
		handler: function(){
			Addressgroup.window.hide();
		}
	}];


	/**
	 * tabPanel that contains some fields. This panel is attached to the modal window.
	 */
	configuration.tabPanel = {
		xtype:'tabpanel',
		height: Addressgroup.layout.windowHeight,
		activeTab: 0,
		deferredRender: false,
		defaults:{
			bodyStyle:'padding:5px'
		//					autoHeight: true,
		},
		items: Addressgroup.windowFields
	};

	/*
	 * Fom panel attached to the Window
	 */
	configuration.formPanel = {
		xtype: 'form',
		id: 'addressgroupForm',
		waitMsgTarget: true,
		frame: true,
		bodyStyle:'padding: 0',
		labelAlign: 'top',
		buttons: configuration.buttons,
		items: {
			xtype: 'panel',
			layout:'column',
			items: [{
				columnWidth: .60,
				items: configuration.tabPanel
			},{
				title: Addresses.lang.information,
				columnWidth: .40,
				xtype: 'panel',
				layout:'form',
				bodyStyle: 'padding: 5px 0 5px 5px',
				items: {
					xtype: "textarea",
					height: 150,
					name: "remarks",
					id: "addressgroupRemarks",
					fieldLabel: Addresses.lang.remarks,
					selectOnFocus:true,
					anchor: "95%",
					blankText: Addresses.lang.fieldMandatory,
					labelSeparator: ""
				}
			}]
		}
	};

	/*
	 * Modal window that enables record editing: add - update data
	 */
	Addressgroup.window = new Ext.Window({
		width: 700,
		height: Addressgroup.layout.windowHeight,
		modal: true,
		layout: 'fit',
		plain:true,
		buttonAlign:'center',
		title: '',
		closeAction: 'hide',
		iconCls: 'window-icon',
		items: configuration.formPanel,
		tbar: configuration.buttons,
		bbar: new Ext.ux.StatusBar({
			defaultText: '&nbsp;',
			text: '&nbsp;',
			items: {}
		}),
		/**
		 * Closes the window and resets other things
		 *
		 * @access private
		 * @return void
		 */
		listeners: {
			beforehide: function() {
				if (typeof(Address.form) == 'object') {
					Address.form.reset();
					Ext.ComponentMgr.get('addressgroupSaveButton').setDisabled(false);
					Ext.ComponentMgr.get('addressgroupCancelButton').setDisabled(false);
					Address.window.getBottomToolbar().setStatus('&nbsp;');
				}
			}
		},

		/**
		 * Generic method for adding a listner on a textarea. Enables the key stroke "enter"
		 */
		addListnerToTextareas: function() {
			var textareas = this.findByType('textarea');
			for (var index = 0; index < textareas.length; index++) {
				var textarea = textareas[index];
				textarea.on({
					'keydown' :	function(el, e) {
						var key = Ext.EventObject.getKey();
						if (key === 13){
							e.stopPropagation();
						}

					}
				});
			}
		},

		/**
		 * Generic method for adding a listner on a combobox. It will store new data into the SimpleStore componenent
		 */
		addListnerToComboboxes: function() {
			var comboboxes = this.findByType('combo');
			for (var index = 0; index < comboboxes.length; index++) {
				var combobox = comboboxes[index];
				if (combobox.editable) {
					combobox.on(
						'blur',
						function(el) {
							var value = el.getValue();
							var id = el.getId().replace('groupAddress', '').toLowerCase()

							// Makes sure the value is not null
							if (value != '') {
								eval('var record = Addressgroup.stores.' + id + '.getById("' + value + '");');

								// Add a new value to the store object
								if (typeof(record) == 'undefined') {

									// Add this record
									eval('Addressgroup.stores.' + id + '.add(new Ext.data.Record({"' + id + '_id": value,"' + id + '_text": value}, value));');
								}
							}
						});
				}
			}
		},

		/**
		 * Set focus on the first field
		 */
		focusOnFirstVisibleField : function() {
			try {
				var firstVisibleElement = Addressgroup.windowFields[0].items[1].id;
				Ext.ComponentMgr.get(firstVisibleElement).focus(true,500); // wait for 100 miliseconds
			}
			catch (e) {
				console.log(e);
			}
		},

		/**
		 * Changes GUI according to status. Makes the buttons unavailable + display a message
		 *
		 * @access private
		 * @return void
		 */
		wait: function() {
			//			Ext.Message.msg(Addresses.lang.saving, Addresses.lang.data_sent);
			Ext.ComponentMgr.get('addressgroupSaveButton').setDisabled(true);
			Ext.ComponentMgr.get('addressgroupCancelButton').setDisabled(true);
		},

		/**
		 * Initialize function
		 */
		init: function() {
			// Do that for generating the DOM, otherwise it won't have a mapping btw fields and data'
			// For instance method KeyMap bellow won't work
			this.show();
			this.hide();

			this.addListnerToTextareas();
			this.addListnerToComboboxes();

			// map one key by key code
			new Ext.KeyMap("addressgroupForm", {
				key: 13, // or Ext.EventObject.ENTER
				fn: function() {
					var component = Ext.ComponentMgr.get('addressgroupSaveButton');
					component.fireEvent('click');
				},
				stopEvent: true
			});
		}
	});
};