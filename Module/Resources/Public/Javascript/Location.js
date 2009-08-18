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

Ext.ux.Location = Ext.extend(Ext.Panel, {
	buttonText: '',

	//	// Overriden parent object method, with additional functionality
	initComponent: function(){

		Ext.apply(this, {
			deferredRender: false,
			items:[
			{
				xtype: 'dataview',
				tpl: [
				'<table id="location" style="width:100%; border-spacing: 0; cursor: pointer; margin-bottom: 5px">',
					'<tbody>',
						'<tpl for=".">',
							'<tr id="locationMainRow{uid}" class="locationMainRow" style="" onmouseover="this.childNodes[0].childNodes[0].style.visibility = \'visible\'; this.style.backgroundColor = \'#EFEFF4\';" onmouseout="this.childNodes[0].childNodes[0].style.visibility = \'hidden\'; this.style.backgroundColor = \'\'">',
								'<td style="width:12%; padding: 3px 0; border-bottom: 1px dotted gray; text-align: center;">',
									'<div style="visibility: hidden;">',
										'<img id="locationDeleteImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/delete.png" alt="delete" />',
										'<img id="locationEditImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/pencil.png" alt="edit" style="margin-left: 5px"/>',
									'</div>',
								'</td>',
								'<td style="width: 60%; padding: 3px 0; border-bottom: 1px dotted gray;">',
									'<p>{street}</p>',
									'<p>{postal_code} {locality}</p>',
									'<p>{country}</p>',
								'</td>',
								'<td style="padding: 3px 0; border-bottom: 1px dotted gray; color:gray">',
									'{nature}',
								'</td>',
								'<td style="width:7%; padding: 3px 0; border-bottom: 1px dotted gray; color: gray">',
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
				store: Address.stores.locations
			},
			{
				xtype: 'button',
				text: this.buttonText,
				cls:"x-btn-text-icon",
				icon:"Resources\/Public\/Icons\/add.png",
				anchor:"30%",
				style:{
					marginBottom:"10px",
					marginLeft:"65%"
				},
				handler: this.edit
			}
			]
		});

		// Defines a global variable
		Location.panel = Ext.ComponentMgr.get('address_locations');

		// Calls parent method
		Ext.ux.Location.superclass.initComponent.call(this, arguments);
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
			id: 'locationForm',
			waitMsgTarget: true,
			frame: true,
			labelAlign: 'top',
			hideMode: 'display',
			items: Location.windowFields
		});

		var panel = Address.window.get(0);
		panel.add(formPanel);
		
		// Hides form panel
		Ext.ComponentMgr.get('locationForm').setVisible(false);
	},

	//	onRender: function(ct){
	//		Ext.ux.Location.superclass.onRender.apply(this, arguments);
	//	},
	
	/**
	 * Attaches events on each rows whenever the component is drawed
	 *
	 * @access public
	 */
	doLayout: function() {
		Ext.ux.Location.superclass.doLayout.call(this);

		var elements = Ext.select('#location img[alt=edit]');
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
					'#location .locationMainRow@dblclick' : Location.panel.edit,
					'#location img[alt=edit]@click' : Location.panel.edit,
					'#location img[alt=delete]@click' : Location.panel.deleteRecord
				});

				if (Addresses.DEBUG) {
					console.log('Location: attached events on rows');
				}
			}
		}

	},

	/**
	 * Adds 2 buttons into the top toolbar: Save the record + Cancel
	 *
	 * @access private
	 * @return void
	 */
	addButtons: function() {

		// Add 2 buttons at a specific position
		var toolbar = Address.window.getTopToolbar();

		toolbar.insertButton(0,{
			id: 'locationSaveButton',
			xtype: 'button',
			text: Addresses.lang.saveLocation,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database_save.png',
			handler: Location.panel.save
		});
		toolbar.insertButton(toolbar.items.items.length - 1,{
			id: 'locationResetButton',
			xtype: 'button',
			text: Addresses.lang.reset,
			cls: 'x-btn-text-icon',
			icon: 'Resources/Public/Icons/database.png',
			handler: Location.panel.reset
		});

		// Re-draws the button
		toolbar.doLayout();
		if (Addresses.DEBUG) {
			console.log('Location: buttons have been added in the toolbar');
		}
	},
	
	/**
	 * Swaps between "addressForm" and "locationForm"
	 *
	 * @todo check the parameter + access of the method
	 * @access private
	 * @return void
	 */
	edit: function(event, element) {
		// Sets default value
		event = typeof(event) == 'undefined' ? {} : event
		element = typeof(element) == 'undefined' ? {} : element

		// Makes sure the parent record (i.e. address) has an uid. Check whether uid_foreign exists
		// Get uid_foreign value
		var uid_foreign = Address.form.findField('uid').getValue();
		if (uid_foreign == '') {
			Location.panel.saveParent();
		}
		else {
			if (!Ext.get('locationSaveButton')) {
				Location.panel.addButtons();
			}

			// TRUE means this is a new record
			if (typeof(element.id) == 'undefined') {
				Location.panel.editInsert();
			}
			else {
				Location.panel.editUpdate(element);
			}

			// Show / hide widgets
			Location.panel.setVisible(true);
			Location.panel.attachKeyMap();
		}
	},
	
	/**
	 * Shows 
	 *
	 * @access private
	 * @return void
	 */
	setVisible: function(isVisible) {
		var namespaces = [{name: 'address', visible: !isVisible}, {name: 'location', visible: isVisible}]
		for (var index = 0; index < namespaces.length; index ++) {
			var namespace = namespaces[index];
			Ext.ComponentMgr.get(namespace.name + 'Form').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'SaveButton').setVisible(namespace.visible);
			Ext.ComponentMgr.get(namespace.name + 'ResetButton').setVisible(namespace.visible);
		}
	},

	/**
	 * Prepares form for a new record.
	 *
	 * @access private
	 * @return void
	 */
	editInsert: function() {
		// Get uid_foreign value
		var uid_foreign = Address.form.findField('uid').getValue();

		var form = Ext.ComponentMgr.get('locationForm').getForm();
		
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
		var uid = element.id.replace(/[a-zA-Z]+/, '');
		var record = Address.stores.locations.getById(uid);
		var form = Ext.ComponentMgr.get('locationForm').getForm();
		form.loadRecord(record);
	},

	/**
	 * Deletes a record
	 *
	 * @access private
	 * @param event Object
	 * @param element Object
	 * @return void
	 */
	deleteRecord: function(event, element) {
		var uid = element.id.replace('locationDeleteImg', '');
		var record = Address.stores.locations.getById(uid);
		Ext.Msg.show({
			title: Addresses.lang.remove,
			buttons: Ext.MessageBox.YESNO,
			msg: Addresses.lang.are_you_sure.replace('{0}', record.data.label),
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
							ajaxID: 'LocationController::deleteAction',
							dataSet: Ext.util.JSON.encode(dataSet)
						},
						success: function(f,a){
							Address.stores.locations.remove(record);
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
						Location.panel.edit();
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
				ajaxID: 'LocationController::saveAction'
			},
			success: function(form, call){
				var record = call.result.records[0];
				// removes the old record for updated record
				if (call.result.request == 'UPDATE') {
					var _record = Address.stores.locations.getById(record.uid);
					Address.stores.locations.remove(_record)
				}
				// Adds, sorts and regenerates the layout.
				Address.stores.locations.add(new Ext.data.Record(record, record.uid));
				Address.stores.locations.sort('uid', 'ASC');
				Location.panel.doLayout();
				Location.panel.reset();
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
		var form = Ext.ComponentMgr.get('locationForm').getForm();
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
		Location.panel.setVisible(false);

		// Resets form
		Ext.ComponentMgr.get('locationForm').getForm().reset();
	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	setValue: function(records) {
		Address.stores.locations.removeAll();
		for (var i=0; i < records.length; i++) {
			var record = records[i];
			Address.stores.locations.add(new Ext.data.Record(record, record.uid));
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
		
		var namespace = 'location';
		if(Ext.get(namespace + 'Form') && !this.isAttachedKeyMap) {

			// Remembers that key has been attached
			this.isAttachedKeyMap = true;
			
			//map one key by key code
			new Ext.KeyMap(namespace + 'Form', {
				key: 13, // or Ext.EventObject.ENTER
				fn: function() {
					Location.panel.save();
				},
				stopEvent: true
			});
		}
	}
});

Ext.reg('location', Ext.ux.Location);
