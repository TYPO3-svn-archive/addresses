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

Ext.ux.Number = Ext.extend(Ext.Panel, {
	buttonText: '',

	//	// Overriden parent object method, with additional functionality
	initComponent: function(){

		Ext.apply(this, {
			deferredRender: false,
			items:[
			{
				xtype: 'dataview',
				tpl: [
				'<table id="number" style="width:100%; border-spacing: 0; cursor: pointer; margin-bottom: 5px">',
					'<tbody>',
						'<tpl for=".">',
							'<tr id="numberMainRow{uid}" class="numberMainRow" style="" onmouseover="this.childNodes[0].childNodes[0].style.visibility = \'visible\'; this.style.backgroundColor = \'#EFEFF4\';" onmouseout="this.childNodes[0].childNodes[0].style.visibility = \'hidden\'; this.style.backgroundColor = \'\'">',
								'<td style="padding: 3px 0; border-bottom: 1px dotted gray; width:10%; text-align: center;">',
									'<div style="visibility: hidden;">',
										'<img id="numberDeleteImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/delete.png" alt="delete" />',
										'<img id="numberEditImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/pencil.png" alt="edit" style="margin-left: 5px"/>',
									'</div>',
								'</td>',
								'<td style="width: 12%; padding: 3px 0; border-bottom: 1px dotted gray; text-align: right; color:gray">',
									'{type_text}',
								'</td>',
								'<td style="width: 30%; padding: 3px 5px 3px 5px; border-bottom: 1px dotted gray;">',
									'{number_evaluated}',
								'</td>',
								'<td style="padding: 3px 0; border-bottom: 1px dotted gray; color: gray">',
									'{nature}',
								'</td>',
								'<td style="padding: 3px 0; border-bottom: 1px dotted gray; color: gray">',
									'<tpl if="remarks">',
										'<img src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/note.png" alt="remarks" title="{remarks}"/>',
									'</tpl>',
								'</td>',
							'</tr>',
						'</tpl>',
					'</tbody>',
				'</table>'
				],
				itemSelector: 'tr',
				store: Address.stores.numbers
			},
			{
				xtype: 'button',
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

		// Defines a global variable
		Number.panel = Ext.ComponentMgr.get('address_numbers');

		// Calls parent method
		Ext.ux.Number.superclass.initComponent.call(this, arguments);
	},

	/**
	 * Initializes the form panel
	 *
	 * @access public
	 * @return void
	 */
	addFormPanel: function() {

		// Attached formpanel to Address.window
		var formPanel = new Ext.form.FormPanel({
			id: 'numberForm',
			waitMsgTarget: true,
			frame: true,
			labelAlign: 'top',
			hideMode: 'display',
			items: Number.windowFields
		});

		var panel = Address.window.get(0);
		panel.add(formPanel);
		
		// Hides form panel
		Ext.ComponentMgr.get('numberForm').setVisible(false);
	},

	//	onRender: function(ct){
	//		Ext.ux.Number.superclass.onRender.apply(this, arguments);
	//	},
	
	/**
	 * Attaches events on each rows whenever the component is drawed
	 *
	 * @access public
	 */
	doLayout: function() {
		Ext.ux.Number.superclass.doLayout.call(this);

		var elements = Ext.select('#number img[alt=edit]');
		if (elements.elements.length > 0) {

			// Checks whether an event already exists at the first element by check attribute 'display'
			// I know this is a silly trick but it works.
			// I would rather check whether the event is attached on the DOM element but I don't know how...
			var element = elements.elements[0];
			if (!element.getAttribute('display')) {
				element.setAttribute('display', 'block');

				// Get contact element
				Ext.addBehaviors({
					// add a listener for click on all anchors in element with id foo
					'#number .numberMainRow@dblclick' : Number.panel.edit,
					'#number img[alt=edit]@click' : Number.panel.edit,
					'#number img[alt=delete]@click' : Number.panel.deleteRecord
				});

				if (Addresses.DEBUG) {
					console.log('Number: attached events on rows');
				}
			}
		}

	},

	/**
	 * Adds 2 buttons into the top toolbar: Save contact number + Cancel
	 *
	 * @access private
	 * @return void
	 */
	addButtons: function() {

		// Add 2 buttons at a specific position
		var toolbar = Address.window.getTopToolbar();
		
		toolbar.insertButton(0,{
			id: 'numberSaveButton',
			xtype: 'button',
			text: Addresses.lang.saveNumber,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database_save.png',
			handler: Number.panel.save
		});
		toolbar.insertButton(toolbar.items.items.length - 1,{
			id: 'numberResetButton',
			xtype: 'button',
			text: Addresses.lang.reset,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database.png',
			handler: Number.panel.reset
		});

		// Re-draws the button
		toolbar.doLayout();
		if (Addresses.DEBUG) {
			console.log('Number: buttons have been added in the toolbar');
		}
	},
	
	/**
	 * Swaps between "addressForm" and "numberForm"
	 *
	 * @todo check the parameter + access of the method
	 * @access private
	 * @return void
	 */
	edit: function(element, event) {
		// Sets default value
		element = typeof(event) == 'undefined' ? {} : element
		event = typeof(element) == 'undefined' ? {} : event

		// Makes sure the parent record (i.e. address) has an uid. Check whether uid_foreign exists
		// Get uid_foreign value
		var uid_foreign = Address.form.findField('uid').getValue();
		if (uid_foreign == '') {
			Number.panel.saveParent();
		}
		else {
			if (!Ext.get('numberSaveButton')) {
				Number.panel.addButtons();
			}

			// TRUE means this is a new record
			if (typeof(event.id) == 'undefined') {

				Number.panel.editInsert();
			}
			else {
				Number.panel.editUpdate(event);
			}

			// Show / hide widgets
			Number.panel.setVisible(true);
			Number.panel.attachKeyMap();
		}
	},
	
	/**
	 * Shows 
	 *
	 * @access private
	 * @return void
	 */
	setVisible: function(isVisible) {
		var namespaces = [{name: 'number', visible: isVisible}, {name: 'address', visible: !isVisible}]
		for (var index = 0; index < namespaces.length; index ++) {
			var namespace = namespaces[index];
			Ext.ComponentMgr.get(namespace.name + 'Form').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'SaveButton').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'ResetButton').setVisible(namespace.visible);
		}

		//	Ext.get('numberForm').ghost('b', {easing: 'easeOut',duration: time ,remove: false,useDisplay: true});

//		var speed = 0.4;
//
//		// Makes the form visible
//		Ext.get('addressForm').fadeOut({
////		useDisplay: true,
//			endOpacity: 0,
//			duration: speed
//		});
//
//		Ext.get('numberForm').pause(speed + 0.2).fadeIn({
////			useDisplay: true,
//			duration: 0.1
//		});
	},

	/**
	 * Prepares form for a new record.
	 *
	 * @access private
	 * @return void
	 */
	editInsert: function() {
		// Fix a bug in ExtJS: reset manually the form
		// Ext.ComponentMgr.get('functionForm').getForm().reset(); does not work if the form has been loaded

		// Gets the fields
		var values = Ext.ComponentMgr.get('numberForm').getForm().getValues();

		// Defines a blank object
		var emptyValues = {};
		for(property in values) {
			emptyValues[property] = ""
		}

		var record = new Ext.data.Record(emptyValues)

		// Loads this blank record
		Ext.ComponentMgr.get('numberForm').getForm().loadRecord(record);
		////// end of the fix
		
		// Get uid_foreign value
		var uid_foreign = Address.form.findField('uid').getValue();

		var form = Ext.ComponentMgr.get('numberForm').getForm();
		// Set uid_foreign into field uid_foreign
		form.findField('uid_foreign').setValue(uid_foreign);
	},

	/**
	 * Prepares form for an existing record.
	 *
	 * @access private
	 * @return void
	 */
	editUpdate: function(element) {
		// The user may have done a dblClick on the row.
		// In this case, search the uid on the parentNode which contains the uid.
		// The parentNode will be a <tr/> or a <img/>
		if (element.id == '' && element.parentNode.id == '') {
			element = element.parentNode.parentNode;
		}
		else if (element.id == '' ) {
			element = element.parentNode;
		}
		var uid = element.id.substring(20);
		var record = Address.stores.numbers.getById(uid);
		var form = Ext.ComponentMgr.get('numberForm').getForm();
		form.loadRecord(record);
	},

	/**
	 * Deletes a record
	 *
	 * @access private
	 * @param element Object
	 * @param event string
	 * @return void
	 */
	deleteRecord: function(element, event) {
		var uid = event.id.replace('numberDeleteImg', '');
		var record = Address.stores.numbers.getById(uid);
		Ext.Msg.show({
			title: Addresses.lang.remove,
			buttons: Ext.MessageBox.YESNO,
			msg: Addresses.lang.are_you_sure_number + ' ' + record.data.number_evaluated + '?',
			fn: function(btn){
				if (btn == 'yes'){
					// Defines the data to transmit
					var dataSet = new Array();
					dataSet[0] = {'uid': uid};

					// Defines the connection
					var conn = new Ext.data.Connection();
					conn.request({
						method: 'GET',
						url: Addresses.statics.ajaxController,
						params:{
							ajaxID: 'NumberController::deleteAction',
							dataSet: Ext.util.JSON.encode(dataSet)
						},
						success: function(f,a){
							Address.stores.numbers.remove(record);
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
		}); // end of show
	},

	saveParent: function() {

		Ext.Msg.show({
			title: '',
			buttons: Ext.MessageBox.YESNO,
			msg: Addresses.lang.doSaveFirst,
			fn: function(btn){
				if (btn == 'yes'){
					// Close the window, save the address, reload the addresses
					//this.close();

					// Defines the submit based on the window.submit
					var submit = Ext.util.clone(Address.window.submit);
					submit.success = function(form, call) {

						// Extract the uid and set it to field .uid
						var record = call.result.records[0];
						Address.form.findField('address_uid').setValue(record.uid);
						var uid = Address.form.findField('address_uid').getValue();
						Ext.StoreMgr.get('addressStore').load();

						// Display re display the form
						Number.panel.edit();
					}
					Address.form.submit(submit);
				}
			}
		});
	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	save: function() {
		// Defines the submit Object
		var submit = {
			clientValidation: true,
			method: 'GET',
			url: Addresses.statics.ajaxController,
			waitMsg: Addresses.lang.saving,
			params:{
				ajaxID: 'NumberController::saveAction'
			},
			success: function(form, call){
				var record = call.result.records[0];
				// removes the old record for updated record
				if (call.result.request == 'UPDATE') {
					var _record = Address.stores.numbers.getById(record.uid);
					Address.stores.numbers.remove(_record)
				}
				// Adds, sorts and regenerates the layout.
				Address.stores.numbers.add(new Ext.data.Record(record, record.uid));
				Address.stores.numbers.sort('uid', 'ASC');
				Number.panel.doLayout();
				Number.panel.reset();
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
		var form = Ext.ComponentMgr.get('numberForm').getForm();
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

		// Show / hide widgets
		Number.panel.setVisible(false);

		// Resets form
		Ext.ComponentMgr.get('numberForm').getForm().reset();
	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	setValue: function(records) {
		Address.stores.numbers.removeAll();
		for (var i=0; i < records.length; i++) {
			var record = records[i];
			Address.stores.numbers.add(new Ext.data.Record(record, record.uid));
		}
	},

	/**
	 * Attaches special key strokes like "Enter"
	 *
	 * @access private
	 * @return void
	 */
	attachKeyMap: function() {
		// Tricks to remember whether the event has been attached
		if (typeof(this.isAttachedKeyMap) == 'undefined') {
			this.isAttachedKeyMap = false;
		}
		
		var namespace = 'number';
		if(Ext.get(namespace + 'Form') && !this.isAttachedKeyMap) {

			// Remembers that key has been attached
			this.isAttachedKeyMap = true;
			
			//map one key by key code
			new Ext.KeyMap(namespace + 'Form', {
				key: 13, // or Ext.EventObject.ENTER
				fn: function() {
					Number.panel.save();
				},
				stopEvent: true
			});
		}
	}
});

Ext.reg('number', Ext.ux.Number);
