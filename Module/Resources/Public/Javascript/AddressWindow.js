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
		text: 'save',
		id: 'saveButton',
		listeners: {
			click: function(){
				// DEFINES THE SUBMIT OBJECT
				var submit = {
					clientValidation: true,
					method: 'GET',
					url: Address.statics.ajaxController,
					params:{
						ajaxID: 'tx_addresses::saveAction'
					},
					success: function(f,a){
						var w = Ext.ComponentMgr.get('addresses_window');
						w.hide();
						Ext.StoreMgr.get('addresses_datasource').load();
					},
					failure: function(f,a){
						if (a.failureType === Ext.form.Action.CONNECT_FAILURE) {
							Ext.Msg.alert(Address.lang.failure, 'Server reported: ' + a.response.status + ' ' + a.response.statusText);
						}
						else if (a.failureType === Ext.form.Action.SERVER_INVALID) {
							Ext.Msg.alert(Address.lang.warning, a.result.errormsg);
						}
					}
				};

				// case multiple edition -> don't validate form
				var form = Address.form
				var uid = form.findField('uid').getValue();
				if (uid == '' || uid.search(',') == -1) {
					if (form.isValid()) {
						submit.clientValidation = true;
						form.submit(submit);
						Ext.Message.msg(Address.lang.saving, Address.lang.data_sent);
					}
					else {
						Ext.Msg.alert(Address.lang.error, Address.lang.fields_error);
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
		text: 'Cancel',
		handler: function(){
			var w = Ext.ComponentMgr.get('addresses_window');
			w.hide();
		}
	}];



	/**
	 * tabPanel that contains some fields. This panel is attached to the modal window.
	 */
	configuration.tabPanel = {
		xtype:'tabpanel',
		height: Address.statics.editionHeight,
		activeTab: 0,
		deferredRender: false,
		defaults:{
			bodyStyle:'padding:5px'
		//					autoHeight: true,
		},
		items: Address.fieldsWindow
	};

	/*
	 * Fom panel attached to the Window
	 */
	configuration.formPanel = {
		xtype: 'form',
		id: 'editForm',
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
				title: Address.lang.information,
				columnWidth: .40,
				xtype: 'panel',
				layout:'form',
				bodyStyle: 'padding: 5px 0 5px 5px',
				items: [{
					xtype: "textarea",
					height: 150,
					name: "remarks",
					id: "remarks",
					fieldLabel: Address.lang.remarks,
					selectOnFocus:true,
					anchor: "95%",
					blankText: Address.lang.fieldMandatory,
					labelSeparator: ""
				},{
					xtype: 'panel',
					id: 'informationPanel',
					tpl: new Ext.Template([
						'<div style="margin-top:10px;">' + Address.lang.visa + '</div>',
						'<div>' + Address.lang.createdOn + ' {crdate} ' + Address.lang.by + ' {cruser_id}</div>',
						'<div>' + Address.lang.updatedOn + ' {tstamp} ' + Address.lang.by + ' {upuser_id}</div>',
						])
				}]
			}]
		}
	};
	
	/*
	 * Modal window that enables record editing: add - update data
	 */
	Address.window = new Ext.Window({

		/*
		 * Modal window that enables record editing: add - update data
		 */
		id: 'addresses_window',
		width: 700,
		height: Address.statics.editionHeight,
		modal: true,
		layout: 'fit',
		plain:true,
		bodyStyle:'padding:5px;',
		buttonAlign:'center',
		title: '',
		closeAction: 'hide',
		iconCls: 'my-icon',
		items: configuration.formPanel,
		listeners: {
			show: function() {
				var informationPanel = Address.window.findById('informationPanel');
				var tpl = informationPanel.tpl;
				tpl.overwrite(informationPanel.body,Address.data);
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
							var id = el.getId();

							// Makes sure the value is not null
							if (value != '') {
								eval('var record = Address.store.' + id + '.getById("' + value + '");');

								// Add a new value to the store object
								if (typeof(record) == 'undefined') {

									// Add this record
									eval('Address.store.' + id + '.add(new Ext.data.Record({"' + id + '_id": value,"' + id + '_text": value}, value));');
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
							var record = Address.store.localities.getById(value);
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
							var record = Address.store.localities.getById(postalCodeValue);

							// Add a new value to the store object
							if (typeof(record) == 'undefined') {

								// Add this record
								Address.store.localities.add(new Ext.data.Record({
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
				var firstVisibleElement = Address.fieldsWindow[0].items[1].id;
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
			var data = new Array();
			for (var index = 0; index < selections.length; index ++) {
				// Get selections
				var selection = selections[index];
				data[index] = {
					uid: selection.data.uid
				};
			}

			if (data.length > 0) {
				Address.form.reset(); // clear form

				Ext.Msg.progress(Address.lang.loading, '');
				Address.startInterval();

				Address.form.load({
					method: 'GET',
					url: Address.statics.ajaxController,
					params:{
						method: 'GET',
						ajaxID: 'tx_addresses::editAction',
						data: Ext.util.JSON.encode(data)
					},
					text: 'Loading',
					success: function(form,call) {
						// Set title
						if (state == 'multipleEdit') {
							Address.window.setTitle(Address.lang.multiple_update_record); // set title
						}
						else if (state == 'edit') {
							Address.window.setTitle(Address.lang.update_record); // set title
						}
						else if (state == 'copy'){
							// Removes the id so that the server will consider the data as a new record
							form.findField('uid').setValue('');
							Address.window.setTitle(Address.lang.copy_record); // set title
						}

						window.clearInterval(Address.interval);
						Ext.Msg.hide();
						Address.data = call.result.data;
						Address.window.show();
						Address.window.focusOnFirstVisibleField();
						Address.window.findById('informationPanel').setVisible(true);
					}
				});
			}
		},

		/**
		 * Initialize function
		 */
		init: function() {
			// Do that for generating the DOM, otherwise it won't have a mapping btw fields and data'
			// For instance method KeyMap bellow won't work
			this.show();
			this.hide();
			//			this.form =

			this.addListnerToTextareas();
			this.addListnerToComboboxes();
			this.addListnerTolocality();

			// map one key by key code
			new Ext.KeyMap("editForm", {
				key: 13, // or Ext.EventObject.ENTER
				fn: function() {
					var component = Ext.ComponentMgr.get('saveButton');
					component.fireEvent('click');
				},
				stopEvent: true
			});
		}
	});

};