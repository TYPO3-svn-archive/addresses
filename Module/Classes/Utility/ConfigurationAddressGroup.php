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
 * Utilities to manage the configuration of tx_addresses_domain_model_addressgroup
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_ConfigurationAddressGroup extends Tx_Addresses_Utility_ConfigurationAbstract {

	/**
	 *
	 * @var array
	 */
	protected static $namespace = 'AddressGroup';

	
	/**
	 * Gets the configuration for the Ext JS interface. The return array is going to be converted into JSON.
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	public static function getGridConfiguration() {
		return array();
	}
	
	/**
	 * Extracts the JavaScript configuration fields name.
	 *
	 * @return array
	 */
	public static function getFieldsTypeOfGrid() {
		$result = array();
		foreach	(Tx_Addresses_Utility_TCA::getFieldsGrid() as $field => $configuration) {
			$_array = array();
			$_array['name'] = $field;
			if (isset($configuration['config']['eval']) && $configuration['config']['eval'] == 'date') {
				$_array['type'] = 'date';
				$_array['dateFormat'] = Tx_Addresses_Utility_Configuration::getDateFormat();
			}

			if (isset($configuration['config']['eval']) && $configuration['config']['eval'] == 'int') {
				$_array['type'] = 'int';
			}
			array_push($result, $_array);
		}

		return $result;
	}


	/**
	 * Returns an array containing the fields configuration
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	public static function getWindowConfiguration() {
		return array();
	}


	/**
	 * Returns an array containing stores
	 *
	 * @return	array
	 */
	 public static function getStores() {
		return array();
	 }

}
?>