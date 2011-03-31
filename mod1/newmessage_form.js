Ext.onReady(function() { 

		Ext.QuickTips.init();
		
		Ext.form.Field.prototype.msgTarget = 'side';

		var get_timestamp =  function(dateField, timeField) {
				var d_date = new Date(dateField.getValue());
				var t_date = Date.parseDate(timeField.getRawValue(), TYPO3.jslang.getLL('extjs_timeformat','adminmessage'));
				return d_date.getTime()+t_date.getTime()-t_date.clearTime(true).getTime();
		}
		
		var messageForm = new Ext.form.FormPanel({
				url:'ajax.php',
				renderTo:'newmessage',
				title: TYPO3.jslang.getLL('send_new_message','adminmessage'),
				width:500,
				bodyStyle: 'padding:10px;',
				frame:true,
				labelAlign: 'top',
				collapsible:true,
				items: [
						{
								layout: 'column',
								items: [{
										columnWidth: 0.35,
										layout: 'form',
										items: [
												{
														xtype: 'combo',
														store: {
																xtype: 'jsonstore',
																url:'ajax.php',
																baseParams: {
																		ajaxID: 'tx_adminmessage_mod1::getGroups'
																},
																root: 'groups',
																fields: [{name:'uid', type: 'int'}, 'title']
														},
														displayField:'title',
														valueField:'uid',
														triggerAction: 'all',
														fieldLabel: 'To group',
														emptyText:'Select a group (optional)',
														editable: false,
														id:'to-group',
														hiddenName: 'group',
														listeners: {
																select: function() {
																		messageForm.findById('to-user').clearValue();
																}
														}
												}]
								},{
										columnWidth: 0.35,
										layout: 'form',
										items: [
												{
														xtype: 'combo',
														store: {
																xtype: 'jsonstore',
																url:'ajax.php',
																baseParams: {
																		ajaxID: 'tx_adminmessage_mod1::getUsers'
																},
																root: 'users',
																fields: [{name:'uid', type: 'int'}, 'username']
																//autoLoad: true,
														},
														//mode: 'local',
														displayField:'username',
														valueField:'uid',
														triggerAction: 'all',
														//typeAhead: true,
														fieldLabel: 'To user',
														//hideLabel: true,
														emptyText:'Select a user (optional)',
														//selectOnFocus:true,
														editable: false,
														id:'to-user',
														hiddenName: 'user',
														listeners: {
																select: function() {
																		messageForm.findById('to-group').clearValue();
																}
														}
												}]

								},{
										columnWidth: 0.3,
										layout: 'form',
										items: [
												{
														xtype: 'button',
														listeners: {
																click: function() {
																		messageForm.findById('to-group').clearValue();
																		messageForm.findById('to-user').clearValue();
																}
														},
														text: 'Clear selection',
														fieldLabel: 'To all'
														/*style: {
																paddingTop: '15px',
														},*/
												}
										]
								
								
						},
						
						{
								xtype:'textfield',
								id:'subject',
								fieldLabel: TYPO3.jslang.getLL('subject','adminmessage'),
								width:275,
								allowBlank:false,
								blankText: TYPO3.jslang.getLL('subject_blank','adminmessage'),
								anchor:'95%'
								//vtype:'email',
								//vtypeText:'Enter a subject'
						},
						{
								xtype:'textarea',
								//xtype:'htmleditor',
								id:'message',
								fieldLabel: TYPO3.jslang.getLL('message','adminmessage'),
								width:275,
								height:200,
								allowBlank:false,
								blankText: TYPO3.jslang.getLL('message_blank','adminmessage'),
								anchor:'95%',
								enableAlignments: false,
								enableColors: false,
								enableFont: false,
								enableFontSize: false,
								enableLists: false,
								enableSourceEdit: false

						}, {
								layout: 'column',
								items: [{
										columnWidth: 0.5,
										layout: 'form',
										items: [
												{
														xtype:'datefield',
														id:'startdate',
														name:'startdate',
														fieldLabel: TYPO3.jslang.getLL('startdate','adminmessage'),
														allowBlank:false,
														blankText: TYPO3.jslang.getLL('startdate_blank','adminmessage'),
														value: new Date(),
														anchor:'90%',
														//submitValue: false,
														format: TYPO3.jslang.getLL('extjs_dateformat','adminmessage')
														//hiddenName: 'morten', not working
														/*listeners: {
																select: function(datefield, newValue, oldValue) {
																		var start = messageForm.findById('start');
																		start.setValue(start.getValue()-)
																},
														},*/
												}

										]
								},{
										columnWidth: 0.5,
										layout: 'form',
										items: [
												{
														xtype:'timefield',
														id:'starttime',
														fieldLabel: TYPO3.jslang.getLL('starttime','adminmessage'),
														allowBlank:false,
														blankText: TYPO3.jslang.getLL('starttime_blank','adminmessage'),
														value: new Date(),
														anchor:'90%',
														submitValue: false,
														format: TYPO3.jslang.getLL('extjs_timeformat','adminmessage')
												}
										]

								}]
						},
						
						{
								layout: 'column',
								items: [{
										columnWidth: 0.5,
										layout: 'form',
										items: [
												{
														xtype:'datefield',
														id:'enddate',
														fieldLabel: TYPO3.jslang.getLL('enddate','adminmessage'),
														//allowBlank:false,
														blankText: TYPO3.jslang.getLL('enddate_blank','adminmessage'),
														//value: new Date(),
														anchor:'90%',
														submitValue: false,
														format: TYPO3.jslang.getLL('extjs_dateformat','adminmessage')
												}

										]
								},{
										columnWidth: 0.5,
										layout: 'form',
										items: [
												{
														xtype:'timefield',
														id:'endtime',
														fieldLabel: TYPO3.jslang.getLL('endtime','adminmessage'),
														//allowBlank:false,
														blankText: TYPO3.jslang.getLL('endtime_blank','adminmessage'),
														//value: new Date(),
														anchor:'90%',
														submitValue: false,
														format: TYPO3.jslang.getLL('extjs_timeformat','adminmessage')
												}
										]

								}]
						},
						
						{
								xtype:'hidden',
								id:'ajaxID',
								value:'tx_adminmessage_mod1::sendMessage'
						},
						{
								xtype:'hidden',
								id: 'start'
						},
						{
								xtype:'hidden',
								id: 'end'
						}
						
				],
				buttons: [
						{
								text: TYPO3.jslang.getLL('clear','adminmessage'),
								handler: function () {
										// when this button clicked, reset this form
										messageForm.getForm().reset();
								}

						},{ 
								text: TYPO3.jslang.getLL('send_message','adminmessage'),
								handler: function () {
										// when this button clicked, sumbit this form
										if(messageForm.getForm().isValid()) {
												
												messageForm.findById('start').setValue(get_timestamp(messageForm.findById('startdate'), messageForm.findById('starttime')));

												/*var enddate = new Date(messageForm.findById('enddate').getValue());
												var endtime = Date.parseDate(messageForm.findById('endtime').getRawValue(), TYPO3.jslang.getLL('extjs_timeformat','adminmessage'));*/
												var enddate = messageForm.findById('enddate');
												var endtime = messageForm.findById('endtime');
												if(enddate.getValue()) {
														if(endtime.getRawValue()) {
																messageForm.findById('end').setValue(get_timestamp(enddate, endtime));
														} else {
																messageForm.findById('end').setValue( (new Date(enddate.getValue())).getTime() );
														}
												}
												
												messageForm.getForm().submit({
														waitMsg: TYPO3.jslang.getLL('sending_message','adminmessage'),		// Wait Message
														success: function () {		// When saving data success
																Ext.MessageBox.alert (TYPO3.jslang.getLL('success','adminmessage'), TYPO3.jslang.getLL('success_text','adminmessage'));
																// clear the form
																messageForm.getForm().reset();
														},
														failure: function () {		// when saving data failed
																Ext.MessageBox.alert (TYPO3.jslang.getLL('failed','adminmessage'), TYPO3.jslang.getLL('failed_text','adminmessage'));
														}
												});
										}
								}

						}
				]
			}]
		});


});