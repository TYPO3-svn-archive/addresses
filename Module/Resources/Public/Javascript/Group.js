/**
 * ExtJS for the 'addresses' extension.
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

Ext.ux.Group = Ext.extend(Ext.Panel, {
	buttonText: '',
	saveButtonText: '',

	//	// Overriden parent object method, with additional functionality
	initComponent: function(){

		var fromMultiselect = this.multiselects[0];
		var toMultiselect = this.multiselects[1];
		Ext.apply(this, {
			deferredRender: false,
			items:[
			{
				name: this.name,
//				id:"address_groups",
				fieldLabel: this.fieldLabel,
				xtype: "itemselector",
				imagePath: "Resources\/Public\/Icons",
				multiselects:[{
					width: fromMultiselect.width,
					height: fromMultiselect.height,
					store: fromMultiselect.store,
					displayField: this.name + "_text",
					valueField: this.name
				},{
					width: toMultiselect.width,
					height: toMultiselect.height,
					store: [],
					displayField: this.name + "_text",
					valueField: this.name
				}]
			},
			{
				xtype: 'button',
				fieldName: this.name,
				text: this.buttonText,
				cls:"x-btn-text-icon",
				icon:"Resources\/Public\/Icons\/add.png",
				anchor:"30%",
				style:{
					marginBottom:"10px"
				},
				handler: this.edit
			}
			]
		});

		// Calls parent method
		Ext.ux.Group.superclass.initComponent.call(this, arguments);
	},

	/**
	 * Initializes the form panel
	 *
	 * @access public
	 * @return void
	 */
	addFormPanel: function(fieldName) {

		// Attached formpanel to Address.window
		var formPanel = new Ext.form.FormPanel({
			id: fieldName + 'Form',
			waitMsgTarget: true,
			frame: true,
			labelAlign: 'top',
			hideMode: 'display',
			items: Group.windowFields
		});

		var panel = Address.window.get(0);
		panel.add(formPanel);

		// Hides form panel
		Ext.ComponentMgr.get(fieldName + 'Form').setVisible(false);
	},

	/**
	 * Adds 2 buttons into the top toolbar: Save contact number + Cancel
	 *
	 * @access private
	 * @param Object panel
	 * @param string fieldName
	 * @return void
	 */
	addButtons: function(panel, fieldName) {

		// Add 2 buttons at a specific position
		var toolbar = Address.window.getTopToolbar();

		toolbar.insertButton(0,{
			id: fieldName + 'SaveButton',
			xtype: 'button',
			text: panel.saveButtonText,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database_save.png',
			handler: panel.save
		});
		toolbar.insertButton(toolbar.items.items.length - 1,{
			id: fieldName + 'ResetButton',
			xtype: 'button',
			text: Addresses.lang.reset,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database.png',
			handler: panel.reset
		});

		// Re-draws the button
		toolbar.doLayout();
		if (Addresses.DEBUG) {
			console.log(fieldName + ': buttons save + cancel have been inserted into the toolbar');
		}
	},

	/**
	 * Swaps between "addressForm" and "subForm"
	 *
	 * @todo check the parameter + access of the method
	 * @access private
	 * @return void
	 */
	edit: function(element, event) {
		var panel = Ext.ComponentMgr.get('address_' + element.fieldName);

		if (!Ext.get(element.fieldName + 'SaveButton')) {
			panel.addButtons(panel, element.fieldName);
		}

		// TRUE means this is a new record
		if (typeof(event.id) == 'undefined') {
//			Group.panel.editInsert();
		}
		else {

			panel.editUpdate(event);
		}

		// Show / hide widgets
		panel.setVisible(true, element.fieldName);
		panel.attachKeyMap(element.fieldName);
	},

	/**
	 * Shows
	 *
	 * @access private
	 * @param boolean isVisible
	 * @param string fieldName
	 * @return void
	 */
	setVisible: function(isVisible, fieldName) {
		var namespaces = [{name: 'address', visible: !isVisible}, {name: fieldName, visible: isVisible}]
		for (var index = 0; index < namespaces.length; index ++) {
			var namespace = namespaces[index];
			Ext.ComponentMgr.get(namespace.name + 'Form').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'SaveButton').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'ResetButton').setVisible(namespace.visible);
		}
	},

	/**
	 * Prepares form for an existing record.
	 *
	 * @access private
	 * @return void
	 */
//	editUpdate: function(element) {
//		// The user may have done a dblClick on the row.
//		// In this case, search the uid on the parentNode which contains the uid.
//		// The parentNode will be a <tr/> or a <img/>
//		if (element.id == '' && element.parentNode.id == '') {
//			element = element.parentNode.parentNode;
//		}
//		else if (element.id == '' ) {
//			element = element.parentNode;
//		}
//		var uid = element.id.substring(20);
//		var record = Address.stores.groups.getById(uid);
//		var form = Ext.ComponentMgr.get('groupForm').getForm();
//		form.loadRecord(record);
//	},

	/**
	 * Deletes a record
	 *
	 * @access private
	 * @return void
	 */
//	deleteRecord: function(event, element) {
//		var uid = element.id.replace('numberDeleteImg', '');
//		var record = Address.stores.groups.getById(uid);
//		Ext.Msg.show({
//			title: Addresses.lang.remove,
//			buttons: Ext.MessageBox.YESNO,
//			msg: Addresses.lang.are_you_sure_group + ' ' + record.data.number_evaluated + '?',
//			fn: function(btn){
//				if (btn == 'yes'){
//					// Defines the data to transmit
//					var dataSet = new Array();
//					dataSet[0] = {'uid': uid};
//
//					// Defines the connection
//					var conn = new Ext.data.Connection();
//					conn.request({
//						method: 'GET',
//						url: Addresses.statics.ajaxController,
//						params:{
//							ajaxID: 'GroupController::deleteAction',
//							dataSet: Ext.util.JSON.encode(dataSet)
//						},
//						success: function(f,a){
//							Address.stores.groups.remove(record);
//						},
//						failure: function(f,a){
//							if (a.failureType === Ext.form.Action.CONNECT_FAILURE) {
//								Ext.Msg.alert('Failure', 'Server reported: ' + a.response.status + ' ' + a.response.statusText);
//							}
//							else if (a.failureType === Ext.form.Action.SERVER_INVALID) {
//								Ext.Msg.alert('Warning', a.result.errormsg);
//							}
//							else {
//								Ext.Msg.alert('Warning', 'Unknow error');
//							}
//
//						}
//					});
//				}
//			}
//		}); // end of show
//	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	save: function() {
		// cleans up the id for retrieving the fieldName
		var fieldName = this.id.replace('SaveButton', '');
		fieldName = fieldName.replace('address_', '');
		
		// Defines the submit Object
		var submit = {
			clientValidation: true,
			method: 'GET',
			url: Addresses.statics.ajaxController,
			waitMsg: Addresses.lang.saving,
			params:{
				ajaxID: 'GroupController::saveAction'
			},
			success: function(form, call){
				var record = call.result.records[0];
				// removes the old record for updated record
//				if (call.result.request == 'UPDATE') {
//					var _record = Address.stores.groups.getById(record.uid);
//					Address.stores.groups.remove(_record)
//				}
				// Adds, sorts and regenerates the layout.
//				console.log(fieldName);

				var uid = record.uid;
				var title = record.title

				// Insert dynamically the record into the store
				var command = 'Address.stores.' + fieldName + '.add(new Ext.data.Record({' +
					'' + fieldName + ': uid,' +
					'' + fieldName + '_text: title' +
				'}, uid));'
				eval(command)
//				Address.stores.groups.add(new Ext.data.Record(record, record.uid));
//				Address.stores.groups.sort('uid', 'ASC');
				Ext.ComponentMgr.get('address_' + fieldName).reset();
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

		// Send form
		var form = Ext.ComponentMgr.get(fieldName + 'Form').getForm();
		if (form.isValid()) {
			form.submit(submit);
		}
		else {
			Ext.Msg.alert(Addresses.lang.error, Addresses.lang.fields_error);
		}
	},


	/**
	 * Listener for cancel button.
	 */
	reset: function() {
		// cleans up the id for retrieving the fieldName
		var fieldName = this.id.replace('ResetButton', '');
		fieldName = fieldName.replace('address_', '');

		// Show / hide widgets
		Ext.ComponentMgr.get('address_' + fieldName).setVisible(false, fieldName);

		// Resets form
		Ext.ComponentMgr.get(fieldName + 'Form').getForm().reset();
	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	setValue: function(records) {},

	/**
	 * Attaches special key strokes like "Enter"
	 *
	 * @access private
	 * @param fieldName string
	 * @return void
	 */
	attachKeyMap: function(fieldName) {
		// Tricks to remember whether the event has been attached
		if (typeof(this.isAttachedKeyMap) == 'undefined') {
			this.isAttachedKeyMap = false;
		}
		if(Ext.get(fieldName + 'Form') && !this.isAttachedKeyMap) {
			
			// Remembers that key has been attached
			this.isAttachedKeyMap = true;
			
			//map one key by key code
			new Ext.KeyMap(fieldName + 'Form', {
				key: Ext.EventObject.ENTER,
				fn: function() {
					Ext.ComponentMgr.get('address_' + fieldName).save();
				},
				stopEvent: true
			});

		}
	}
});

Ext.reg('groups', Ext.ux.Group);
