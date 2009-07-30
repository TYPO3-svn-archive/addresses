/*!
 * Ext JS Library 3.0.0
 * Copyright(c) 2006-2009 Ext JS, LLC
 * licensing@extjs.com
 * http://www.extjs.com/license
 */

function testMe2(uid) {
	time = 0.4;
	//	Ext.get('contactNumberForm').ghost('b', {easing: 'easeOut',duration: time ,remove: false,useDisplay: true});
	Ext.get('contactNumberForm').fadeOut({
		useDisplay: true,
		duration: time
	});
	Ext.get('addressForm').pause(time + 0.2).fadeIn({
		useDisplay: true,
		duration: 0.1
	});
}

var contactNumberStore = new Ext.data.ArrayStore({
	data: [["1", "mobile", "079 770 70 65", 'Aumônerie'], ["2", "fixe", "032 511 08 18", 'Test'], ["3", "fax", "024 471 70 74", 'Paulin']],
	fields: ['uid', 'type', 'number' , "nature"]
})
var storeType = new Ext.data.ArrayStore({
	data: [["mobile", "mobile_text"], ["fixe", "fixe"], ["fax", "fax"]],
	fields: ['type', 'type_text']
})

var storeNature = new Ext.data.ArrayStore({
	data: [["Aumônerie", "Aumônerie"], ["Test", "Test"], ["TPL", "TPL"]],
	fields: ['nature', 'nature_text']
})

Ext.ux.ContactNumber = Ext.extend(Ext.Panel, {
	text: 'Add element',

	//	// Overriden parent object method, with additional functionality
	initComponent: function(){

		Ext.apply(this, {
			deferredRender: false,
			items:[{
				html:'Téléphones'
			},
			{
				xtype: 'dataview',
				tpl: [
				'<div id="asdf">',
				'</div>',
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
				'{type}',
				'</td>',
				'<td style="width: 30%; padding: 3px 5px 3px 5px; border-bottom: 1px dotted gray;">',
				'{number}',
				'</td>',
				'<td style="padding: 3px 0; border-bottom: 1px dotted gray; color: gray">',
				'{nature}',
				'</td>',
				'</tr>',
				'<tr id="contactNumberEditRow{uid}" style="background-color:#EFEFF4">',
				'<td colspan="10"></td>',
				'</tr>',
				'</tpl>',
				'</tbody>',
				'</table>'
				],
				itemSelector: 'table',
				store: contactNumberStore
			},
			{
				xtype: 'button',
				text: this.text,
				cls:"x-btn-text-icon",
				icon:"Resources\/Public\/Icons\/add.png",
				anchor:"30%",
				style:{
					marginBottom:"10px",
					marginLeft:"65%"
				},
				handler: this.editRecord
			}
			]
		});

		Ext.ux.ContactNumber.superclass.initComponent.call(this, arguments);
	},

	//	onRender: function(ct){
	//		Ext.ux.ContactNumber.superclass.onRender.apply(this, arguments);
	//	},

	doLayout: function(shallow) {
		Ext.ux.ContactNumber.superclass.doLayout.call(this);
		if (typeof(shallow) == 'boolean') {

			Ext.addBehaviors({
				// add a listener for click on all anchors in element with id foo
				'#contactNumber .contactNumberMainRow@dblclick' : this.editRecord,
				'#contactNumber img[alt=edit]@click' : this.editRecord,
				'#contactNumber img[alt=delete]@click' : this.deleteRecord
			});
		//			new Ext.Button({text: 'asdf',renderTo: 'contactNumberRow1'});
		}
	},

	editRecord: function(event, element) {
		// Gets reference
		var uid = this.id.substring(20);
		var speed = 0.4;
		
		// Makes the form visible
		Ext.get('addressForm').fadeOut({
			useDisplay: true,
			duration: speed
		});
		Ext.get('contactNumberForm').pause(speed + 0.2).fadeIn({
			useDisplay: true,
			duration: 0.1
		});
		Ext.get('addressForm').fadeOut();
	},

	/**
	 * Deletes a record
	 *
	 * @access private
	 * @return void
	 */
	deleteRecord: function(event, element) {
		console.log(element);
		console.log(4);
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
			success: function(form,call){
				console.log(4);
				return
//				Address.window.hide();
//				Ext.StoreMgr.get('addressStore').load();
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
		console.log(form);
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
