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

//function testMe2(uid) {
//	time = 0.4;
//	//	Ext.get('contactnumberForm').ghost('b', {easing: 'easeOut',duration: time ,remove: false,useDisplay: true});
//	Ext.get('contactnumberForm').fadeOut({
//		useDisplay: true,
//		duration: time
//	});
//	Ext.get('addressForm').pause(time + 0.2).fadeIn({
//		useDisplay: true,
//		duration: 0.1
//	});
//}

//var contactnumbersStore = new Ext.data.ArrayStore({
//	data: [["1", "mobile", "079 770 70 65", 'Aumônerie'], ["2", "fixe", "032 511 08 18", 'Test'], ["3", "fax", "024 471 70 74", 'Paulin']],
//	fields: ['uid', 'type', 'number' , "nature"]
//})
var storeType = new Ext.data.ArrayStore({
	data: [["mobile", "mobile_text"], ["fixe", "fixe"], ["fax", "fax"]],
	fields: ['type', 'type_text']
})

var storeNature = new Ext.data.ArrayStore({
	data: [["Aumônerie", "Aumônerie"], ["Test", "Test"], ["TPL", "TPL"]],
	fields: ['nature', 'nature_text']
})

Ext.ux.ContactNumber = Ext.extend(Ext.Panel, {
	buttonText: '',

	//	// Overriden parent object method, with additional functionality
	initComponent: function(){

		Ext.apply(this, {
			deferredRender: false,
			items:[
			{
				xtype: 'dataview',
				tpl: [
				'<table id="contactNumber" style="width:100%; border-spacing: 0; cursor: pointer; margin-bottom: 5px">',
					'<tbody>',
						'<tpl for=".">',
							'<tr id="contactNumberMainRow{uid}" class="contactNumberMainRow" style="" onmouseover="this.childNodes[0].childNodes[0].style.visibility = \'visible\'; this.style.backgroundColor = \'#EFEFF4\';" onmouseout="this.childNodes[0].childNodes[0].style.visibility = \'hidden\'; this.style.backgroundColor = \'\'">',
								'<td style="padding: 3px 0; border-bottom: 1px dotted gray; width:10%; text-align: center;">',
									'<div style="visibility: hidden;">',
										'<img id="contactNumberDeleteImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/delete.png" alt="delete" />',
										'<img id="contactNumberEditImg{uid}" src="/typo3conf/ext/addresses/Module/Resources/Public/Icons/pencil.png" alt="edit" style="margin-left: 5px"/>',
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
				store: Address.stores.contactnumbers
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

		Ext.ux.ContactNumber.superclass.initComponent.call(this, arguments);
	},

	//	onRender: function(ct){
	//		Ext.ux.ContactNumber.superclass.onRender.apply(this, arguments);
	//	},

	/**
	 * Attaches events on each rows whenever the component is drawed
	 */
	doLayout: function(shallow) {
		Ext.ux.ContactNumber.superclass.doLayout.call(this);

		// Get contact element
		var el = Ext.ComponentMgr.get('address_contactnumbers');
		Ext.addBehaviors({
			// add a listener for click on all anchors in element with id foo
			'#contactNumber .contactNumberMainRow@dblclick' : el.edit,
			'#contactNumber img[alt=edit]@click' : el.edit,
			'#contactNumber img[alt=delete]@click' : el.deleteRecord
		});
		console.log('layout done');
	},

	/**
	 * Swaps between "addressForm" and "contactnumberForm"
	 *
	 * @todo check the parameter + access of the method
	 * @access private
	 * @return void
	 */
	edit: function(event, element) {
//		var speed = 0.4;
//
//		// Makes the form visible
//		Ext.get('addressForm').fadeOut({
////		useDisplay: true,
//			endOpacity: 0,
//			duration: speed
//		});
//
//		Ext.get('contactnumberForm').pause(speed + 0.2).fadeIn({
////			useDisplay: true,
//			duration: 0.1
//		});

		// TRUE means this is a new record
		if (typeof(element.id) == 'undefined') {

			Ext.ComponentMgr.get('address_contactnumbers').editInsert();
		}
		else {
			Ext.ComponentMgr.get('address_contactnumbers').editUpdate(element);
		}
		
		Ext.ComponentMgr.get('addressForm').setVisible(false);
		Ext.ComponentMgr.get('contactnumberForm').setVisible(true);
		
		// Defines the actions of the buttons located in the top bar
		Address.window.setControllersActionInTopBar('contactnumbers');
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

		var form = Ext.ComponentMgr.get('contactnumberForm').getForm();
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
		var record = Address.stores.contactnumbers.getById(uid);
		var form = Ext.ComponentMgr.get('contactnumberForm').getForm();
		form.loadRecord(record);
	},

	/**
	 * Deletes a record
	 *
	 * @access private
	 * @return void
	 */
	deleteRecord: function(event, element) {
		var uid = element.id.replace('contactNumberDeleteImg', '');
		var record = Address.stores.contactnumbers.getById(uid);
		Ext.Msg.show({
			title: Addresses.lang.remove,
			buttons: Ext.MessageBox.YESNO,
			msg: Addresses.lang.are_you_sure_contactnumber + ' ' + record.data.number_evaluated + '?',
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
							ajaxID: 'ContactnumberController::deleteAction',
							dataSet: Ext.util.JSON.encode(dataSet)
						},
						success: function(f,a){
							Address.stores.contactnumbers.remove(record);
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
				ajaxID: 'ContactnumberController::saveAction'
			},
			success: function(form, call){
				var record = call.result.records[0];
				// removes the old record for updated record
				if (call.result.request == 'UPDATE') {
					var _record = Address.stores.contactnumbers.getById(record.uid);
					Address.stores.contactnumbers.remove(_record)
				}
				// Adds, sorts and regenerates the layout.
				Address.stores.contactnumbers.add(new Ext.data.Record(record, record.uid));
				Address.stores.contactnumbers.sort('uid', 'ASC');
				Ext.ComponentMgr.get('address_contactnumbers').doLayout();
				Ext.ComponentMgr.get('address_contactnumbers').hide();

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
		var form = Ext.ComponentMgr.get('contactnumberForm').getForm();
		var uid = form.findField('contactnumber_uid').getValue();
		if (uid == '' || uid.search(',') == -1) {
			if (form.isValid()) {
				submit.clientValidation = true;
				form.submit(submit);
//				Address.window.wait();
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
	},


	/**
	 * Listener for cancel button.
	 */
	hide: function() {
		//	Ext.get('contactnumberForm').ghost('b', {easing: 'easeOut',duration: time ,remove: false,useDisplay: true});

//		var speed = 0.2;

		// Makes the form visible
//		Ext.get('contactnumberForm').fadeOut({
//			useDisplay: true,
//			duration: speed
//		});
//		Ext.get('addressForm').pause(speed + 0.2).fadeIn({
//			useDisplay: true,
//			duration: 0.1
//		});

		Ext.ComponentMgr.get('addressForm').setVisible(true);
		Ext.ComponentMgr.get('contactnumberForm').setVisible(false);

		// Resets form
		Ext.ComponentMgr.get('contactnumberForm').getForm().reset();
		
		// Changes the controller (save - cancel) action
		Address.window.setControllersActionInTopBar(Address.window);
	},

	/**
	 * Method for saving the form.
	 *
	 * @access private
	 * @return void
	 */
	setValue: function(records) {
		Address.stores.contactnumbers.removeAll();
		for (var i=0; i < records.length; i++) {
			var record = records[i];
			Address.stores.contactnumbers.add(new Ext.data.Record(record, record.uid));
		}
	},

	afterRender: function(a) {
		Ext.ux.ContactNumber.superclass.afterRender.call(this);

	//
	//		console.log(this);
	//		console.log( this.getEl());
	//		console.log( this.getEl().get('contactNumberRow1'));
	//		console.log(this.el);
	//		console.log(this.el.dom.getElementsByTagName("div"));
	//		var test = this.el.dom.getElementsByTagName("div");
	//		alert(test.length)
	//		console.log(this.el.dom.select('div'));
	//		console.log(this.el.dom.querySelector('div'));
	//		new Ext.Button({text: 'asdf',renderTo: this.el});
	}

});

Ext.reg('contactnumber', Ext.ux.ContactNumber);
