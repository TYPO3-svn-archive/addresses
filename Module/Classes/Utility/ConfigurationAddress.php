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
 * Utilities to manage the configuration of tx_addresses_domain_model_address
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_ConfigurationAddress extends Tx_Addresses_Utility_ConfigurationAbstract {

	/**
	 *
	 * @var array
	 */
	protected static $namespace = 'Address';

	/**
	 * Gets the configuration for the Ext JS interface. The return array is going to be converted into JSON.
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	public static function getGridConfiguration() {
		global $LANG;
		$configurations = Tx_Addresses_Utility_TCA::getFieldsGrid();

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
		global $LANG;
		$columns = Tx_Addresses_Utility_TCA::getColumns();
		$items = explode(',', Tx_Addresses_Utility_TCA::getShowItems());
		$items = array_map('trim', $items);
		$index = -1;
		$configurations = array();
		$items = array_filter($items);
		foreach ($items as $item) {

			// IMPORTANT:
			// The section bellow will define the informations for the head of the tabpanel.
			// In other words, this is a new tab!
			if (is_int(strpos($item, '--div--'))) {

				$index++;
				$configurations[$index] = Tx_Addresses_Utility_TCE::getTab($item);

				// Add uid of the record as hidden field
				if ($index === 0) {
					$configurations[$index]['items'][] = Tx_Addresses_Utility_TCE::getUid($item);
				}
			}
			// Means this is normal field
			else {
				if (is_int(strpos($item, '|'))) {
					$fields = explode('|', $item);
					$fields = array_map('trim', $fields);

					$_configurations = $configuration = $columnWidth = array();
					$i = $j = 0;

					// Loops on the fields
					foreach ($fields as $field) {
						$_properties = explode(':', $field);
						$field = $_properties[0];

						$_array = self::getConfiguration($field);
						if (!empty($_array)) {

							$_configurations[$i]['defaults'] = array(
								'anchor' => '95%',
								'blankText' => $LANG->getLL('fieldMandatory'),
								'labelSeparator' => '',
							);

							$_configurations[$i]['layout'] = 'form';
							$_configurations[$i]['items'][] = $_array;
							$i++;

							// Defines the columns Width array. The array will be used later on.
							if (isset($_properties[1])) {
								$columnWidth[] = (float) $_properties[1];
							}
						}
					}

					// Makes aure there are fields to add.
					if (!empty($_configurations)) {
						$configuration['layout'] = 'column';

						// second loops is necessary since we don't know in advance which fiels are allowed
						foreach ($_configurations as $_configuration) {
							if (!isset($columnWidth[$j])) {
								$columnWidth[$j] = round(1 / count($_configurations), 1);
							}
							$configuration['items'][$j]['columnWidth'] = $columnWidth[$j];
							$configuration['items'][$j]['items'] = $_configuration;
							$j++;
						}
					}
				} //end if
				else {
					$configuration = self::getConfiguration($item);
				}

				// Add configuration whenever it is not empty
				if (!empty($configuration)) {
					$configurations[$index]['items'][] = $configuration;
					if (isset($columns[$item]['config']['foreign_table'])) {
						$configurations[$index]['items'][] = Tx_Addresses_Utility_TCE::getEditForeignTableButton(self::$namespace, $columns[$item]['config']['foreign_table']);
					}
				}
			}
		}
		return self::sanitizeConfigurations($configurations);
	}


	/**
	 * Returns an array containing stores
	 *
	 * @return	array
	 */
	 public static function getStores() {
		$stores[] = Tx_Addresses_Utility_TCE::getCustomStore('localities', 'postal_code', 'locality', 'tx_addresses_domain_model_address');
		return array_merge($stores, Tx_Addresses_Utility_TCE::getStores());
	 }

	/**
	 * Removes tabs that contain no fields from the tabpanel
	 *
	 * @param array $configurations
	 * @return array
	 */
	protected static function sanitizeConfigurations(Array $configurations) {
		$_configurations = Array();
		foreach ($configurations as &$configuration) {
			if (isset($configuration['items'])) {
				$_configurations[] = $configuration;
			}
		}
		return $_configurations;
	}

	/**
	 * Return configuration of array
	 *
	 * @param string the field name;
	 * @return array $configuration
	 */
	protected static function getConfiguration($fieldName) {
		global $LANG;
		$columns = Tx_Addresses_Utility_TCA::getColumns();
		$tca = $columns[$fieldName]['config'];

		// Makes sure the user has the permission
		if (Tx_Addresses_Utility_Permission::checkPermission($columns, $fieldName)) {

			switch($tca['type']) {
				case 'text':
					$configuration = Tx_Addresses_Utility_TCE::getTextArea($columns, $fieldName);
					break;
				case 'input':
					$configuration = Tx_Addresses_Utility_TCE::getTextField($columns, $fieldName);
					break;
				case 'select':
					if ($tca['maxitems'] > 1 && isset($tca['foreign_table'])) {
						$configuration = Tx_Addresses_Utility_TCE::getItemSelector($columns, $fieldName, self::$namespace);
					}
					else {
						$configuration = Tx_Addresses_Utility_TCE::getComboBox($columns, $fieldName, self::$namespace);
					}
					break;
				default;
					t3lib_div::debug($fieldName, '$field');
					t3lib_div::debug($tca, '$tca');
					throw new Exception('<b>Invalid configuration</b> in ' . __FILE__ . ', line: ' . __LINE__);
			} //end switch
		} // end if
		return $configuration;
	}
}
?>