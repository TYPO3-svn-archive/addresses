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
 * Utilities to manage the permission
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_Permission {


	/**
	 * Check whether the fields is going to be displayed or not.
	 *
	 * @global Object $BE_USER
	 * @param string $namespace
	 * @param string $fieldName
	 * @return boolean
	 */
	function hasPermission($namespace, $fieldName) {
		global $BE_USER;
		$columns = Tx_Addresses_Utility_TCA::getColumns($namespace);
		$hasPermission = FALSE;
		if ($BE_USER->isAdmin() ||
			(isset($columns[$fieldName]['exclude']) && !$columns[$fieldName]['exclude']) ||
			$BE_USER->check('non_exclude_fields','tx_addresses_domain_model_address:' . $fieldName)) {
			$hasPermission = TRUE;
		}
		return $hasPermission;
	}



}
?>