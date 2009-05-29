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

// Global object
var main, edition;

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

Event.observe(window, 'load', function() {
	//Quicktips initialisieren
//	Ext.QuickTips.init();

	// @todo: description
	// Ext.form.Field.prototype.msgTarget = 'side';

	// disable loadindicator
//	Ext.UpdateManager.defaults.showLoadIndicator = false;
	
	// fire addresses grid
	main = new Addresses.Main();
	
	// adjust columns layout + render the grid
	Addresses.fieldsColumns.unshift(main.checkbox, main.expander); // add checkbox + expander to the grid
	Addresses.fieldsColumns.push(main.controller);
	main.columns = Addresses.fieldsColumns;
//	main.init();

	// Prepare editing window
	edition = new Addresses.Edition();
	edition.init();
	edition.w.show();
});
