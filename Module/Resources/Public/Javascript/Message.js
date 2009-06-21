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
 * Display message information for the 'addresses' extension.
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

Ext.Message = function(){
	var msgCt;

	function createBox(t, s){
		return ['<div class="msg">',
		'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
		'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3>', t, '</h3>', s, '</div></div></div>',
		'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
		'</div>'].join('');
	}

	return {
		msg : function(title, format){
			if(!msgCt){
				msgCt = Ext.DomHelper.insertFirst(document.body, {
					id:'msg-div'
				}, true);
			}
			msgCt.alignTo(document, 't-t');
			var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
			var m = Ext.DomHelper.append(msgCt, {
				html:createBox(title, s)
			}, true);
			m.slideIn('t').pause(1).ghost("t", {
				remove:true
			});
		},

		init : function(){
			var t = Ext.get('exttheme');
			if(!t){ // run locally?
				return;
			}
			var theme = Cookies.get('exttheme') || 'aero';
			if(theme){
				t.dom.value = theme;
				Ext.getBody().addClass('x-'+theme);
			}
			t.on('change', function(){
				Cookies.set('exttheme', t.getValue());
				setTimeout(function(){
					window.location.reload();
				}, 250);
			});

			var lb = Ext.get('lib-bar');
			if(lb){
				lb.show();
			}
		}
	};
}();
