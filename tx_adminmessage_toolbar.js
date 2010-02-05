/***************************************************************
*  Copyright notice
*
*  (c) 2009 Morten Tranberg Hansen (mth at cs dot au dot dk)
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * This is the frontend client 'adminmessage'.
 *
 * @author Morten Tranberg Hansen <mth at cs dot au dot dk>
 * @date   November 10 2009
 */


Ext.namespace('Ext.ux.TYPO3');  

Ext.ux.TYPO3.tx_adminmessage_toolbar = Ext.extend(Ext.util.Observable, {
		
		message_prefix: 'tx-adminmessage-toolbar-message-',

		constructor: function(config) {
				config = config || {};
				Ext.apply(this, config);

				this.aware = TYPO3.tx_aware_client;
				this.new_channel = 'new#adminmessage:'+TYPO3.configuration.username;
				this.old_channel = 'old#adminmessage:'+TYPO3.configuration.username;
				
				this.largest_message_uid = 0;

				this.icon = Ext.get('tx-adminmessage-toolbar-icon');
				this.menu = Ext.get(Ext.query('#tx-adminmessage-toolbar-menu .toolbar-item-menu')[0]);				
				this.item = Ext.get(Ext.query('#tx-adminmessage-toolbar-menu > a')[0]);

				if(!this.icon || !this.menu || !this.item) {
						return;
				}

				this.position_menu();
				this.add_messages();

				this.icon.on('click', this.toggle_menu, this);

				Ext.ux.TYPO3.tx_adminmessage_toolbar.superclass.constructor.call(this, config);
		},

		/********** PUBLIC **********/

		load: function() {
				this.aware.on(this.new_channel, this.new_message_event, this);
				this.aware.on(this.old_channel, this.old_message_event, this);
		},

		unload: function() {
				this.aware.un(this.new_channel, this.new_message_event, this);
				this.aware.un(this.old_channel, this.old_message_event, this);
		},

		toggle_menu: function() {

				if(this.has_messages() && !this.item.hasClass('toolbar-item-active')) {
						this.show_menu();
				} else {
						this.hide_menu();
				}

		},		

		new_message_event: function(channel, timestamp, data) {
				this.icon.set({src:'../typo3conf/ext/adminmessage/newmail.gif'});
				this.add_message(data);
		},

		old_message_event: function(channel, timestamp, data) {
				var m = this.find_message(data);
				if(m!=null) {
						m.remove();
						if(!this.has_messages()) {
								this.hide_menu();
						}
				}
		},

		remove_parent: function(event, dom, ref) {
				var el = Ext.get(dom);
				var parent = el.parent();
				var id = parent.getAttribute('id');
				var uid = id.substring(this.message_prefix.length, id.length);
				this.aware.addEvent('hide#adminmessage', {'username':TYPO3.configuration.username, 'uid':uid});
				parent.remove();
				if(!this.has_messages()) {
						this.hide_menu();
				}
		},


		/********** PRIVATE **********/

		add_messages: function() {
				//var messages = Ext.util.JSON.decode(TYPO3.tx_adminmessage_toolbar_messages);
				var messages = TYPO3.tx_adminmessage_toolbar_messages;
				for(var i=0; i<messages.size(); i++) {
						this.add_message(messages[i]);
				}
		},

		add_message: function(message) {

				if(this.find_message(message)==null) {

						var date = new Date(parseInt(message.crdate)*1000);
						
						var html = '\
<img src="../typo3conf/ext/adminmessage/delete.gif" width="11" height="12" alt="' + TYPO3.getLL('remove', 'adminmessage_toolbar') + '" title="' + TYPO3.getLL('remove', 'adminmessage_toolbar') + '" />\
<div class="datetime">[' + date.format(TYPO3.getLL('extjs_date_format', 'adminmessage_toolbar')) + ']</div>\
<div class="subject"> ' + message.subject + '</div>\
<div class="message">' + Ext.util.Format.nl2br(message.message) + '</div>';
						
						var el = new Ext.Element(document.createElement('li'));
						el.set({'id': this.message_prefix+message.uid});
						el.update(html);
						el.child('img').on('click', this.remove_parent, this);
						this.menu.insertFirst(el);

						var uid = parseInt(message.uid);
						if(uid>this.largest_message_uid) {
								this.largest_message_uid = uid;
						}
						
				}

		},

		show_menu: function() {
				this.item.addClass('toolbar-item-active');
				TYPO3BackendToolbarManager.hideOthers(this.item.dom);
				this.menu.fadeIn({duration: 0.2});
				this.icon.set({src:'../typo3conf/ext/adminmessage/mail_gray.gif'});
				this.aware.addEvent('seen#adminmessage', {'username':TYPO3.configuration.username, 'uid':this.largest_message_uid});
		}, 

		hide_menu: function() {
				this.item.removeClass('toolbar-item-active');
				this.menu.fadeOut({duration: 0.1});
				this.icon.set({src:'../typo3conf/ext/adminmessage/mail_gray.gif'});
				this.aware.addEvent('seen#adminmessage', {'username':TYPO3.configuration.username, 'uid':this.largest_message_uid});
		},

		has_messages: function() {
				return this.menu.first()!=null;

		},

		find_message: function(message) {
				
				var m = this.menu.first();
				while(m) {
						if(m.getAttribute('id')==(this.message_prefix+message.uid)) {
								return m;
						}
						m = m.next();
				}
				return null;
		},

		position_menu: function() {
				var calculatedOffset = 0;
				var parent = Ext.get('tx-adminmessage-toolbar-menu');
				var parentWidth      = parent.getWidth();
				/***** TODO: why does getWidth() on the ExtJS elements return 0? Need to use JQuery to make it work in IE :( 
				var ownWidth         = Ext.get(Ext.query('#tx-adminmessage-toolbar-menu .toolbar-item-menu')[0]).getWidth();
				var ownWidth         = Ext.get(parent.child('.toolbar-item-menu')).getWidth();
        *****/
				var ownWidth = $$('#tx-adminmessage-toolbar-menu .toolbar-item-menu')[0].getWidth();

				var toolbarItem = Ext.get('tx-adminmessage-toolbar-menu').prev();
				while(toolbarItem!=null) {
						calculatedOffset += toolbarItem.getWidth() - 1;
						// -1 to compensate for the margin-right -1px of the list items,
						// which itself is necessary for overlaying the separator with the active state background

						if(toolbarItem.first().hasClass('no-separator')) {
								calculatedOffset -= 1;
						}
						toolbarItem = toolbarItem.prev();
				}
				calculatedOffset = calculatedOffset - ownWidth + parentWidth;
				
				Ext.get(Ext.query('#tx-adminmessage-toolbar-menu .toolbar-item-menu')[0]).setStyle({
						left: calculatedOffset + 'px'
				});
		},
				
});




Ext.onReady(function() {
    TYPO3.tx_adminmessage_toolbar = new Ext.ux.TYPO3.tx_adminmessage_toolbar();
		TYPO3.tx_adminmessage_toolbar.load();
});

Ext.EventManager.on(window, 'unload', function() {
		TYPO3.tx_adminmessage_toolbar.unload();		
		
});