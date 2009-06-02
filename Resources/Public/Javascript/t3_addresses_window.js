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

Addresses.Window = function()
{
	/**
	 * Buttons: save - cancel attached to the form panel
	 */
	this.buttons = [{
		text: 'save',
		id: 'saveButton',
		listeners: {
			click: function(){
				// DEFINES THE SUBMIT OBJECT
				var submit = {
					clientValidation: true,
					method: 'GET',
					url: Addresses.statics.ajaxController,
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
							Ext.Msg.alert(Addresses.lang.failure, 'Server reported: ' + a.response.status + ' ' + a.response.statusText);
						}
						else if (a.failureType === Ext.form.Action.SERVER_INVALID) {
							Ext.Msg.alert(Addresses.lang.warning, a.result.errormsg);
						}
					}
				};

				var w = Ext.ComponentMgr.get('addresses_window');
				var form = w.getComponent('editForm').getForm();

				// case multiple edition -> don't validate form
				var uid = form.findField('uid').getValue();
				if (uid == '' || uid.search(',') == -1) {
					if (form.isValid()) {
						submit.clientValidation = true;
						form.submit(submit);
						Ext.Message.msg(Addresses.lang.saving, Addresses.lang.data_sent);
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
		text: 'Cancel',
		handler: function(){
			var w = Ext.ComponentMgr.get('addresses_window');
			w.hide();
		}
	}];

	/**
	 * tabPanel that contains some fields. This panel is attached to the modal window.
	 */
	this.tabPanel = {
		xtype:'tabpanel',
		height: Addresses.statics.editionHeight,
		activeTab: 0,
		defaults:{
			bodyStyle:'padding:5px'
		//					autoHeight: true,
		},
		items: Addresses.fieldsEdition
	};
	
	/*
	 * Fom panel attached to the Window
	 */
	this.formPanel = {
		xtype: 'form',
		id: 'editForm',
		url: 'genres.php',
		frame: true,
		bodyStyle:'padding: 0',
		labelAlign: 'top',
		buttons: this.buttons,
		items: this.tabPanel
	};

	/*
	 * Modal window that enables record editing: add - update data
	 */
	this.w = new Ext.Window({
		id: 'addresses_window',
		width: 600,
		height: Addresses.statics.editionHeight,
		modal: true,
		layout: 'fit',
		plain:true,
		bodyStyle:'padding:5px;',
		buttonAlign:'center',
		title: '',
		closeAction: 'hide',
		iconCls: 'my-icon',

		// formPanel that contains a tabPanel
		items: this.formPanel
	});

	/**
	 * Generic method for adding a listner on a combobox. It will store new data into the SimpleStore componenent
	 */
	this.addListnerToCombobox = function() {

		var comboboxes = this.w.findByType('combo');
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
							eval('var record = Addresses.store.' + id + '.getById("' + value + '");');

							// Add a new value to the store object
							if (typeof(record) == 'undefined') {

								// Add this record
								eval('Addresses.store.' + id + '.add(new Ext.data.Record({"' + id + '_id": value,"' + id + '_text": value}, value));');
							}
						}
					});
			}
		}

	};


	/**
	 * Add listner on fields zip + city
	 */
	this.addListnerTocity = function() {

		// Add a listener to the field zip
		// terms of reference: when a postal code is given tries to find out the city.
		var postalCode = this.w.findById('zip');
		var city = this.w.findById('city');
		if (city != null && postalCode != null) {
			postalCode.on(
				'blur',
				function(el) {
					var value = el.getValue();
					if (value != '') {
						var record = Addresses.store.localities.getById(value);
						if (typeof(record) == 'undefined') {
							city.setValue('');
						}
						else {
							city.setValue(record.get('city_text'));
						}
					}
				}
				);

			city.on(
				'blur',
				function(el) {
					var postalCodeValue = postalCode.getValue();
					var cityValue = city.getValue();
					if (postalCodeValue != '' && cityValue != '') {
						var record = Addresses.store.localities.getById(postalCodeValue);
						
						// Add a new value to the store object
						if (typeof(record) == 'undefined') {

							// Add this record
							Addresses.store.localities.add(new Ext.data.Record({city_id: postalCodeValue, city_text: cityValue},postalCodeValue));
						}
					}
				}
				);
		}

	};

	/**
	 * Initialize function
	 */
	this.init = function() {

		// Do that for generating the DOM, otherwise it won't have a mapping btw fields and data'
		this.w.show(); this.w.hide();

		this.addListnerToCombobox();
		this.addListnerTocity();

		// map one key by key code
		new Ext.KeyMap("editForm", {
			key: 13, // or Ext.EventObject.ENTER
			fn: function() {
				var component = Ext.ComponentMgr.get('saveButton');
				component.fireEvent('click');
			},
			stopEvent: true
		});
	};
};
