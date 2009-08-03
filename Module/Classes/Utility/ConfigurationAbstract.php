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
abstract class Tx_Addresses_Utility_ConfigurationAbstract {

	/**
	 * Gets the configuration for the Ext JS interface. The return array is going to be converted into JSON.
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	public static function getGridConfiguration($namespace) {
		global $LANG;
		$configurations = Tx_Addresses_Utility_TCA::getFieldsFromGrid($namespace);
		
		$fields = array();
		foreach ($configurations as $fieldName => $configuration) {
			$_array = array();

			// Defines staff
			$_array['header'] = $LANG->sL($configuration['label']);
			$_array['dataIndex'] = $fieldName;

			if (isset($configuration['config']['width'])) {
				$_array['width'] = (int)$configuration['config']['width'];
			}

			if (isset($configuration['config']['hidden'])) {
				$_array['hidden'] = (boolean)$configuration['config']['hidden'];
			}

			if (isset($configuration['config']['eval']) && $configuration['config']['eval'] == 'date') {
				$_array['renderer'] = "Ext.util.Format.dateRenderer('" . Tx_Addresses_Utility_Configuration::getDateFormat() . "')";
			}

			if (isset($configuration['config']['sortable'])) {
				$_array['sortable'] = (boolean)$configuration['config']['sortable'];
			}

			// Check whether it is an id
			if (isset($configuration['id']) && $configuration['id']) {
				$_array['id'] = $fieldName;;
			}

			array_push($fields, $_array);
		}
		return $fields;
	}

	/**
	 * Extracts the JavaScript configuration fields name.
	 *
	 * @return array
	 */
	protected static function getFieldsTypeInGrid($namespace) {

		$result = array();
		foreach	(Tx_Addresses_Utility_TCA::getFieldsFromGrid($namespace) as $field => $configuration) {
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
	 * Says whether the array is associative or not
	 *
	 * @param array $array
	 * @return array
	 */
	protected static function is_assoc($array) {
		return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
	}

	/**
	 * Checks the permissions. Removes the fields for them the user has no permission.
	 *
	 * @param string $namespace
	 * @param field $fields
	 * @return array
	 */
	protected static function checkFieldsPermission($namespace, $fields) {
		$fieldsOK = array();
		foreach ($fields as $field) {
			if (is_array($field) && !self::is_assoc($field)) {
				$fieldsOK[] = self::checkFieldsPermission($namespace, $field);
			}
			else if (is_array($field)) {
				if (isset($field['fieldName'])) {
					if (Tx_Addresses_Utility_Permission::hasPermission($namespace, $field['fieldName'])) {
						$fieldsOK[] = $field;
					}
				}
			}
			else {
				if (Tx_Addresses_Utility_Permission::hasPermission($namespace, $field)) {
					$fieldsOK[] = $field;
				}
			}
		}
		return $fieldsOK;
	}

	/**
	 * Loops around the showed items and makes sure the user has access to the field.
	 *
	 * @param string $namespace
	 * @param array $showItems
	 * @return array
	 */
	protected static function getShowItems($namespace, $showItems) {
		$_showItems = array();
		foreach ($showItems as $showItem) {
			$_panels = array();
			if (isset($showItem['panels']) && is_array($showItem['panels'])) {
				foreach	($showItem['panels'] as $panel) {
					if (isset($panel['fields']) && is_array($panel['fields'])) {
						$fieldsOK = self::checkFieldsPermission($namespace, $panel['fields']);
						if (!empty($fieldsOK)) {
							$_panel = $panel;
							$_panel['fields'] = $fieldsOK;
							$_panels[] = $_panel;
						}
					} // end if
				} // end foreach
			}
			if (!empty($_panels)) {
				$_showItem = $showItem;
				$_showItem['panels'] = $_panels;
				$_showItems[] = $_showItem;
			}
		}
		return $_showItems;
	}

	/**
	 * Return the configuration for $field<b>s</b> given in input.
	 * 
	 * @param string $namespace
	 * @param array $fields
	 * @return array
	 */
	protected static function getFieldsConfiguration($namespace, $fields) {
		$configurations = array();
		foreach ($fields as $fieldName) {
			if (is_array($fieldName)) {

				// Loops on the fields
				$_configurations = array();
				$_configurations['layout'] = 'column';
				$_configurations['xtype'] = 'panel';
				foreach ($fieldName as $_fieldName) {
					// This is the default panel
					$__configuration = array();
					$__configuration['columnWidth'] = $_fieldName['columnWidth'];
					$__configuration['items'] = array();
					$__configuration['items']['xtype'] = 'panel';
					$__configuration['items']['layout'] = 'form';
					$__configuration['items']['defaults'] = Tx_Addresses_Utility_TCE::getDefaults();
					$__configuration['items']['items'] = Tx_Addresses_Utility_TCE::getFieldConfiguration($namespace, $_fieldName['fieldName']);
					$_configurations['items'][] = $__configuration;
				}
				$configurations[] = $_configurations;
			}
			else {
				$configurations[] = Tx_Addresses_Utility_TCE::getFieldConfiguration($namespace, $fieldName);
			}
		}
		return $configurations;
	}

	/**
	 * Returns an associative array containing the fields configuration.
	 * The array will be transformed to JSON and be intepreted by ExtJS.
	 * Notice, this array can be quite big according to the number of fields.
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	protected static function getWindowConfiguration($namespace) {
		global $LANG;
		$configurations = array();
		$columns = Tx_Addresses_Utility_TCA::getColumns($namespace);
		$showItems = Tx_Addresses_Utility_TCA::getShowItems($namespace);
		$showItems = self::getShowItems($namespace, $showItems);

		// Adds the uid in the first panel
		if (isset($showItems[0]['panels'][0]['fields'])) {
			// Add manually the uid
			array_push($showItems[0]['panels'][0]['fields'], 'uid');

			// init configuration array
			$configurations['xtype'] = 'panel';
			$configurations['layout'] = 'column';

			// Loos around the showed items
			foreach ($showItems as $showItem) {
				$_configuration = $tabpanels = array();

				// Defines default value for 
				$_configuration['columnWidth'] = $showItem['columnWidth'];

				// Makes the difference whether the panel contains 1 element or multi elements
				switch ($showItem['xtype']) {
					case 'tabpanel':
						$tabpanels['xtype'] = 'tabpanel';
						$tabpanels['activeTab'] = isset($showItem['activeTab']) ? $showItem['activeTab'] : 0;
						$tabpanels['deferredRender'] = FALSE;
						$tabpanels['defaults'] = array('bodyStyle' => 'padding:5px', 'height' => 555); // 'autoHeight' => TRUE
						foreach ($showItem['panels'] as $panel) {
							$_panel = array();
							$_panel = Tx_Addresses_Utility_TCE::getTab($panel['title']);
							$_panel['items'] = self::getFieldsConfiguration($namespace, $panel['fields']);
							$tabpanels['items'][] = $_panel;
						}
						break;
					case 'panel':
						// Extract the unique field name
						$_configuration['xtype'] = 'panel';
						$_configuration['title'] = '&nbsp;';
						$_configuration['layout'] = 'form';
						$_configuration['bodyStyle'] = 'padding: 5px 0 5px 5px';
						$_configuration['defaults'] = Tx_Addresses_Utility_TCE::getDefaults();
						$fieldName = $showItem['panels'][0]['fields'][0];
						$tabpanels[] = Tx_Addresses_Utility_TCE::getFieldConfiguration($namespace, $fieldName);
						break;
					default:
						t3lib_div::debug('Script has stopped because of a missing configuration. Please define xtype value', 'debug');
						t3lib_div::debug($showItem, '$showItem');
						throw new Exception('Error has been sent');
				}

				// Adds the panel's description to the main configuration array
				$_configuration['items'] = $tabpanels;
				$configurations['items'][] = $_configuration;
			}
		}
		return $configurations;

		// Stores configuration for not empty $configuration
//		if (!empty($configuration)) {
//			$configurations[$index]['items'][] = $configuration;
//			if (isset($columns[$item]['config']['foreign_table'])) {
//				$configurations[$index]['items'][] = Tx_Addresses_Utility_TCE::getEditForeignTableButton($namespace, $columns[$item]['config']['foreign_class']);
//			}
//		}
	}

	/**
	 * Returns an array containing stores
	 *
	 * @return	array
	 */
	public static function getStores($namespace) {
		return  Tx_Addresses_Utility_TCE::getStores($namespace);
	}
}
?>