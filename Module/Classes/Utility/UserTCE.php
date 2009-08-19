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
 * Utilities to manage the UserTCE of an extension
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
	class Tx_Addresses_Utility_UserTCE {
	
	/**
	 * Returns the configuration of element textfield.
	 *
	 * @global	Language	$LANG
	 * @param	string		$namespace
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getContactnumbersField($namespace, &$columns, $fieldName) {
		global $LANG;
		$configuration['xtype'] = 'contactnumber';
		$configuration['id'] = 'address_contactnumbers';
		$configuration['fieldLabel'] = '';
		$configuration['buttonText'] = $LANG->getLL('addNewContactnumber');
		return $configuration;
//		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);
//		$tca =  $columns[$fieldName]['config'];
//
//		// Defines max length
//		if (isset($tca['max'])) {
//			$configuration['maxLength'] = (int) $tca['max'];
//		}
//		if (isset($tca['default'])) {
//			$configuration['value'] = $LANG->sL($tca['default']);
//		}
//
//		// validators
//		if (isset($tca['eval'])) {
//			$evals = explode(',', $tca['eval']);
//			foreach ($evals as $eval) {
//				switch ($eval) {
//					case 'required':
//						$configuration['allowBlank'] = FALSE;
//						break;
//					case 'email':
//						$configuration['vtype'] = 'email';
//						break;
//					case 'int':
//						$configuration['vtype'] = 'int';
//						break;
//					case 'date':
//						$configuration['xtype'] = 'datefield';
//						$configuration['format'] = Tx_Addresses_Utility_Configuration::getDateFormat();
//						$configuration['invalidText'] = $LANG->getLL('invalidDate');
//						break;
//				}
//			}
//		}
//		return $configuration;
	}


	/**
	 * Returns the configuration of element textfield.
	 *
	 * @global	Language	$LANG
	 * @param	string		$namespace
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getLocationField($namespace, &$columns, $fieldName) {
		global $LANG;
		$configuration['xtype'] = 'location';
		$configuration['id'] = 'address_locations';
		$configuration['fieldLabel'] = '';
		$configuration['buttonText'] = $LANG->getLL('addNewLocation');
		return $configuration;
	}



}
?>