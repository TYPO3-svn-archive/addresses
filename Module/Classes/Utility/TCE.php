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
 * Utilities to manage the TCE of an extension
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_TCE {

/**
 *
 * @var array $elements
 */
	protected static $elements = array();

	/**
	 * Returns the common configuration of element textarea.
	 *
	 * @global	Language	$LANG
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getComboBoxConfiguration(&$columns, $fieldName) {
		global $LANG;
		$configuration = self::getCommonConfiguration($columns, $fieldName);
		$tca =  $columns[$fieldName]['config'];

		$configuration['xtype'] = 'combo';
		$configuration['mode'] = 'local';
		$configuration['store'] = 'Addresses.store.' . $fieldName;
		$configuration['displayField'] = $fieldName .'_text';
		$configuration['triggerAction'] = 'all';
		$configuration['editable'] = isset($tca['editable']) ? $tca['editable'] : TRUE;

		if (isset($tca['default'])) {
			$configuration['value'] = $LANG->sL($tca['default']);
		}

		// Add configuration for non-editable field
		if (isset($tca['editable']) && !$tca['editable']) {
			$configuration['value'] = '0'; // assume value 0 is defined in the combobox
			$configuration['valueField'] = $fieldName;
			$configuration['hiddenName'] = $fieldName;
			$configuration['id'] = $fieldName . '_id'; // Must be different to avoid conflict. 2 fiels are created. One is hidden
		}

		// Fetches the value
		$elements = array();
		if (isset($tca['items']) && is_array($tca['items'])) {
			foreach ($tca['items'] as $_elements) {
				$elements[] = array(
					$LANG->sL($_elements[1]),
					$LANG->sL($_elements[0]),
				);
			}
		}
		// Check wheter an external function must be called
		if (isset($tca['itemsProcFunc'])) {
			$table = $tca['itemsProcFunc.']['table'];
			$_fieldName = $tca['itemsProcFunc.']['field'];
			if ($table != '' && $_fieldName != '') {
				$records = call_user_func_array(explode('->', $tca['itemsProcFunc']), array($table, $_fieldName));
			}
			// Merges array
			$elements = array_merge($elements, $records);
			$elements = self::arrayUnique($elements);
		}


		// Obtain a list of columns. For sorting purpose
		$values = array();
		foreach ($elements as $key => $row) {
			$values[$key] = $row[1];
		}

		// Sort the data with values options
		array_multisort($values, SORT_ASC, $elements);

		// Add a possible default value
		if (isset($tca['default']) && is_array($tca['default'])) {
			$value = $LANG->sL($tca['default'][0]);
			$id = $tca['default'][1];
			array_unshift($elements, array($id, $value));
		}
		// Stores the variable for later user
		self::$elements = $elements;

		return $configuration;
	}

	/**
	 * Returns the store configuration in Json formation
	 *
	 * @param	string	$fieldName
	 * @return	string
	 */
	public static function getLastStoreConfiguration($fieldName) {
		$json = json_encode(self::$elements);
		$store = <<<EOF
$fieldName : new Ext.data.SimpleStore({idIndex: 0, fields: ["$fieldName", "{$fieldName}_text"], data: $json})
EOF;
		return $store;
	}

	/**
	 * Returns the store configuration in Json formation
	 *
	 * @global	array		$TCA
	 * @global	t3lib_DB	$TYPO3_DB
	 * @param	string		$fieldName
	 * @param	string		$foreignTable
	 * @return	string
	 */
	public static function getStoreConfiguration($fieldName, $foreignTable) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		global $TCA;

		$clause = 'deleted = 0 ';
		$clause .= t3lib_BEfunc::BEenableFields($foreignTable);
		$records = $TYPO3_DB->exec_SELECTgetRows('uid as "0", ' . $TCA[$foreignTable]['ctrl']['label'] . ' as "1"', $foreignTable, $clause);

		$json = json_encode($records);
		$store = <<<EOF
$fieldName : new Ext.data.SimpleStore({idIndex: 0, fields: ["$fieldName", "{$fieldName}_text"], data: $json, sortInfo: {field: "{$fieldName}_text", direction: "ASC"}})
EOF;
		return $store;
	}

	/**
	 * Returns the common configuration of element textarea.
	 *
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getTextAreaConfiguration(&$columns, $fieldName) {
		$configuration = self::getCommonConfiguration($columns, $fieldName);

		// Set default xtype
		$configuration['xtype'] = 'textarea';
		$configuration['enableKeyEvents'] = TRUE;

		return $configuration;
	}

	/**
	 * Returns the common configuration of element textarea.
	 *
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getItemSelectorConfiguration(&$columns, $fieldName) {
		$width = 170;
		$height = 150;
		$tca =  $columns[$fieldName]['config'];
		$configuration = self::getCommonConfiguration($columns, $fieldName);

		$configuration['xtype'] = 'itemselector';
		$configuration['imagePath'] = 'Resources/Public/Icons';
		$fromMulitSelect['width'] = $width;
		$fromMulitSelect['height'] = $height;
		$fromMulitSelect['store'] = 'Addresses.store.' . $fieldName;
		$fromMulitSelect['displayField'] = $fieldName . '_text';
		$fromMulitSelect['valueField'] = $fieldName;

		$toMulitSelect['width'] = $width;
		$toMulitSelect['height'] = $height;
		$toMulitSelect['store'] = Array();
		$toMulitSelect['displayField'] = $fieldName . '_text';
		$toMulitSelect['valueField'] = $fieldName;

		$configuration['multiselects'] = array($fromMulitSelect, $toMulitSelect);

		return $configuration;
	}

	/**
	 * Returns the configuration of element textfield.
	 *
	 * @global	Language	$LANG
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getTextFieldConfiguration(&$columns, $fieldName) {
		global $LANG;
		$configuration = self::getCommonConfiguration($columns, $fieldName);
		$tca =  $columns[$fieldName]['config'];

		// Set default xtype
		$configuration['xtype'] = 'textfield';

		// Defines max length
		if (isset($tca['max'])) {
			$configuration['maxLength'] = (int) $tca['max'];
		}
		if (isset($tca['default'])) {
			$configuration['value'] = $LANG->sL($tca['default']);
		}

		// validators
		if (isset($tca['eval'])) {
			$evals = explode(',', $tca['eval']);
			foreach ($evals as $eval) {
				switch ($eval) {
					case 'required':
						$configuration['allowBlank'] = FALSE;
						break;
					case 'email':
						$configuration['vtype'] = 'email';
						break;
					case 'int':
						$configuration['vtype'] = 'int';
						break;
					case 'date':
						$configuration['xtype'] = 'datefield';
						$configuration['format'] = Tx_Addresses_Utility_Configuration::getDateFormat();
						$configuration['invalidText'] = $LANG->getLL('invalidDate');
						break;
				}
			}
		}
		return $configuration;
	}

	/**
	 * Returns the common configuration of any elements.
	 *
	 * @global	Language	$LANG
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	private static function getCommonConfiguration(&$columns, $fieldName) {
		global $LANG;
		// field name + label which are default values
		$configuration['name'] = $fieldName;
		$configuration['id'] = $fieldName;
		if (isset($columns[$fieldName]['label'])) {
			$configuration['fieldLabel'] = $LANG->sL($columns[$fieldName]['label']);
		}
		$configuration['selectOnFocus'] = true;

		return $configuration;

	}

	/**
	 * Eliminates doublon
	 *
	 * @param array $myArray
	 * @return array
	 */
	private static function arrayUnique($myArray) {

		foreach ($myArray as &$myvalue) {
			$myvalue = serialize($myvalue);
		}

		$myArray = array_unique($myArray);

		foreach ($myArray as &$myvalue) {
			$myvalue = unserialize($myvalue);
		}

		return $myArray;
	}
}
?>