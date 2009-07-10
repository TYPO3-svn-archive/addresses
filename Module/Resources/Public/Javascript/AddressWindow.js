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

Address.initWindow = function() {

	var configuration = new Object();
	/**
	 * Buttons: save - cancel attached to the form panel
	 */
	configuration.buttons = [{
		text: Addresses.lang.save,
		id: 'addressSaveButton',
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
						ajaxID: 'AddressController::saveAction'
					},
					success: function(form,call){
						Address.window.hide();
						Ext.StoreMgr.get('addressStore').load();
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
				var form = Address.form
				var uid = form.findField('addressUid').getValue();
				if (uid == '' || uid.search(',') == -1) {
					if (form.isValid()) {
						submit.clientValidation = true;
						form.submit(submit);
						Address.window.wait();
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
	'-',
	{
		text: Addresses.lang.cancel,
		id: 'addressCancelButton',
		cls: 'x-btn-text-icon',
		icon: 'Resources/Public/Icons/filter_clear.png',
		handler: function(){
			Address.window.hide();
		}
	}];

	/**
	 * tabPanel that contains some fields. This panel is attached to the modal window.
	 */
	configuration.tabPanel = {
		xtype:'tabpanel',
		height: Address.layout.windowHeight,
		activeTab: 2,
		deferredRender: false,
		defaults:{
			bodyStyle:'padding:5px'
		//					autoHeight: true,
		},
		items: Address.windowFields
	};

	/*
	 * Fom panel attached to the Window
	 */
	configuration.formPanel = {
		xtype: 'form',
		id: 'addressForm',
		waitMsgTarget: true,
		frame: true,
		bodyStyle:'padding: 0',
		labelAlign: 'top',
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
					id: "addressRemarks",
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
	Address.window = new Ext.Window({
		width: 700,
		height: Address.layout.windowHeight,
		modal: true,
		layout: 'fit',
		plain: true,
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
					Ext.ComponentMgr.get('addressSaveButton').setDisabled(false);
					Ext.ComponentMgr.get('addressCancelButton').setDisabled(false);
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
							var id = el.getId().replace('address', '').toLowerCase();

							// Makes sure the value is not null
							if (value != '') {
								eval('var record = Address.stores.' + id + '.getById("' + value + '");');

								// Add a new value to the store object
								if (typeof(record) == 'undefined') {

									// Add this record
									eval('Address.stores.' + id + '.add(new Ext.data.Record({"' + id + '_id": value,"' + id + '_text": value}, value));');
								}
							}
						});
				}
			}

		},

		/**
		 * Add listner on fields postal_code + locality
		 */
		addListnerTolocality: function() {

			// Add a listener to the field postal_code
			// terms of reference: when a postal code is given tries to find out the locality.
			var postalCode = this.findById('postal_code');
			var locality = this.findById('locality');
			if (locality != null && postalCode != null) {
				postalCode.on(
					'blur',
					function(el) {
						var value = el.getValue();
						if (value != '') {
							var record = Address.stores.localities.getById(value);
							if (typeof(record) == 'undefined') {
								locality.setValue('');
							}
							else {
								locality.setValue(record.get('locality_text'));
							}
						}
					}
					);

				locality.on(
					'blur',
					function(el) {
						var postalCodeValue = postalCode.getValue();
						var localityValue = locality.getValue();
						if (postalCodeValue != '' && localityValue != '') {
							var record = Address.stores.localities.getById(postalCodeValue);

							// Add a new value to the store object
							if (typeof(record) == 'undefined') {

								// Add this record
								Address.stores.localities.add(new Ext.data.Record({
									locality_id: postalCodeValue,
									locality_text: localityValue
								},postalCodeValue));
							}
						}
					}
					);
			}

		},

		/**
		 * Set focus on the first field
		 */
		focusOnFirstVisibleField : function() {
			try {
				var firstVisibleElement = Address.windowFields[0].items[1].id;
				Ext.ComponentMgr.get(firstVisibleElement).focus(true,500); // wait for 100 miliseconds
			}
			catch (e) {
				console.log(e);
			}
		},

		/**
		 * Mode could be either copy or new
		 */
		display: function(state) {
			var sm = Address.grid.getSelectionModel();
			var selections = sm.getSelections();
			var dataSet = new Array();
			for (var index = 0; index < selections.length; index ++) {
				// Get selections
				var selection = selections[index];
				dataSet[index] = {
					uid: selection.data.uid
				};
			}

			if (dataSet.length > 0) {
				Address.form.reset(); // clear form
				Address.window.waitMask.show();
				
				Address.form.load({
					method: 'GET',
					url: Addresses.statics.ajaxController,
					params:{
						method: 'GET',
						ajaxID: 'AddressController::editAction',
						dataSet: Ext.util.JSON.encode(dataSet)
					},
					waitTitle: Addresses.lang.loading,
					success: function(form,call) {
						// Set title
						if (state == 'multipleEdit') {
							Address.window.setTitle(Addresses.lang.multiple_update_record); // set title
						}
						else if (state == 'edit') {
							Address.window.setTitle(Addresses.lang.update_record); // set title
						}
						else if (state == 'copy'){
							// Removes the id so that the server will consider the data as a new record
							form.findField('addressUid').setValue('');
							Address.window.setTitle(Addresses.lang.copy_record); // set title
						}
						Address.window.waitMask.hide();
						var data = call.result.data;
						var message =  Addresses.lang.createdOn + ' ' + data.crdateTime + ' ' + Addresses.lang.by + ' ' + data.cruser_id;
						message +=  '&nbsp;&nbsp; &bull; &nbsp;&nbsp;'
						message += Addresses.lang.updatedOn + ' ' + data.tstampTime + ' ' + Addresses.lang.by + ' ' + data.upuser_id;
						Address.window.getBottomToolbar().setStatus(message);

						Address.window.show();
						Address.window.focusOnFirstVisibleField();
					}
				});
			}
		},

		/**
		 * Object used for display a mask when the user is waiting
		 */
		waitMask: new Ext.LoadMask(Ext.getBody(), {
			msg: Addresses.lang.loading
		}),

		/**
		 * Changes GUI according to status. Makes the buttons unavailable + display a message
		 *
		 * @access private
		 * @return void
		 */
		wait: function() {
			//			Ext.Message.msg(Addresses.lang.saving, Addresses.lang.data_sent);
			Ext.ComponentMgr.get('addressSaveButton').setDisabled(true);
			Ext.ComponentMgr.get('addressCancelButton').setDisabled(true);
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
			this.addListnerTolocality();

			// map one key by key code
			new Ext.KeyMap("addressForm", {
				key: 13, // or Ext.EventObject.ENTER
				fn: function() {
					var component = Ext.ComponentMgr.get('addressSaveButton');
					component.fireEvent('click');
				},
				stopEvent: true
			});
		}
	});
};