<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Fabien Udriot <fabien.udriot@ecodev.ch>
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3. 
*  All credits go to the v5 team.
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
 * Utilities to manage the configuration of an extension
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_Configuration {

	/**
	 * Returns the date format defined in the install tool.
	 *
	 * @global	array	$TYPO3_CONF_VARS
	 * @return	string
	 */
	public static function getDateFormat() {
		global $TYPO3_CONF_VARS;
		return $TYPO3_CONF_VARS['SYS']['ddmmyy'];
	}


}
?>