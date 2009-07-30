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
	 * Returns configuration according to the given field's name.
	 * This method works like a dispatcher. Firstly the TCA of the field is loaded.
	 * Then, the right method is called according to the field's type.
	 *
	 * @param string the name space;
	 * @param string the field name;
	 * @return array $configuration
	 */
	public static function getFieldConfiguration($namespace, $fieldName) {
		global $LANG;
		$configuration = array(); // Defines default value
		$columns = Tx_Addresses_Utility_TCA::getColumns($namespace);
		$tca = $columns[$fieldName]['config'];

		switch($tca['type']) {
			case 'passthrough':
				$configuration = self::getHiddenField($namespace, $columns, $fieldName);
				break;
			case 'text':
				$configuration = self::getTextArea($namespace, $columns, $fieldName);
				break;
			case 'input':
				$configuration = self::getTextField($namespace, $columns, $fieldName);
				break;
			case 'user':
				if (isset($tca['userFunc'])) {
					$configuration = call_user_func_array($tca['userFunc'], array($namespace, $columns, $fieldName));
				}
				break;
			case 'select':
				if ($tca['maxitems'] > 1 && isset($tca['foreign_table'])) {
					$configuration = self::getItemSelector($namespace, $columns, $fieldName);
				}
				else {
					$configuration = self::getComboBox($namespace, $columns, $fieldName);
				}
				break;
			default;
				t3lib_div::debug('Invalid configuration for "' . $fieldName . '" in ' . __FILE__ . ', line: ' . __LINE__, 'MESSAGE');
				t3lib_div::debug($namespace, '$namespace');
				t3lib_div::debug($fieldName, '$field');
				t3lib_div::debug($columns, '$columns');
				throw new Exception('An error has been thrown!');
		} //end switch
		return $configuration;
	}
	
	/**
	 * Returns the locations store
	 *
	 * @global t3lib_DB $TYPO3_DB
	 * @param	string	$storeName
	 * @param	int		$uidField
	 * @param	string	$textField
	 * @param	string	$table
	 * @return	string
	 */
	public static function getCustomStore($storeName, $uidField, $textField, $table) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;

		$clause = 'deleted = 0';
		$clause .= ' AND ' . $uidField . ' != "" AND ' . $uidField . ' != "0"';
		$clause .= ' AND ' . $textField . ' != "" AND ' . $textField . ' != "0"';
		$clause .= t3lib_BEfunc::BEenableFields($table);

		$resource = $TYPO3_DB->exec_SELECTquery('distinct(' . $uidField . ') , ' . $textField, $table, $clause);
		$records = array();
		while ($row = $TYPO3_DB->sql_fetch_row($resource)) {
			$records[] = array($row[0], $row[1]);
		}
		return '"' . $storeName . '": new Ext.data.SimpleStore({id:0, "fields": ["' . $uidField . '_id", "' . $textField . '_text"],"data" : ' . json_encode($records) . '})';
	}

	/**
	 * Returns the common configuration for tab.
	 *
	 * @global	Language	$LANG
	 * @param	array		$items
	 * @return	array
	 */
	public static function getTab(&$title) {
		global $LANG;
		$configuration['title'] = $LANG->sL($title);
		$configuration['layout'] = 'form';
		// Adds here default configuration
		$configuration['defaults'] = self::getDefaults();
		return $configuration;
	}

	/**
	 * ExtJS has a configuration key 'defaults' which is for setting default
	 * values to the fields. This configuration's key enables to spare many lines of code
	 * since it is not necessary to repeat information for each fields.
	 *
	 * @return array
	 */
	public static function getDefaults () {
		$configuration = array(
			'xtype' => 'textfield',
			'anchor' => '95%',
			'blankText' =>'fieldMandatory',
			'labelSeparator' => '',
			'selectOnFocus' => TRUE,
		);
		return $configuration;
	}

	/**
	 * Returns the common configuration for the combo box.
	 *
	 * @param	string		$namespace
	 * @global	Language	$LANG
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getComboBox($namespace, &$columns, $fieldName) {
		global $LANG;
		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);
		$tca =  $columns[$fieldName]['config'];

		$configuration['xtype'] = 'combo';
		$configuration['mode'] = 'local';
		$configuration['store'] = $namespace . '.stores.' . $fieldName;
		$configuration['displayField'] = $fieldName .'_text';
		$configuration['triggerAction'] = 'all';
		$configuration['editable'] = isset($tca['editable']) ? $tca['editable'] : TRUE;

		if (isset($tca['default'])) {
			// Generates a GUI bug on FF
//			$configuration['value'] = $LANG->sL($tca['default']);
		}

		// Add configuration for non-editable field
		if (isset($tca['editable']) && !$tca['editable']) {
			// Generates a GUI bug on FF
//			$configuration['value'] = '0'; // assume value 0 is defined in the combobox
			$configuration['valueField'] = $fieldName;
			$configuration['hiddenName'] = $fieldName;
			$configuration['id'] = $fieldName . '_id'; // Must be different to avoid conflict. 2 fiels are created. One is hidden
		}

		return $configuration;
	}

	/**
	 * Returns an array containing stores
	 * 
	 * @param	string		$namespace
	 * @return array
	 */
	public static function getStores($namespace) {
		$columns = Tx_Addresses_Utility_TCA::getColumns($namespace);
		$stores = array();

		foreach ($columns as $fieldName => $column) {
			$tca = $columns[$fieldName]['config'];
			if ($tca['type'] == 'select') {

				if (isset($tca['foreign_table'])) {
					$stores[] = self::getStoreForeignTable($fieldName, $tca['foreign_table']);
				}
				else {
					$stores[] = self::getStore($fieldName, $tca);
				}
			}
		}
		return $stores;
	}

	/**
	 * Returns the store configuration in Json formation
	 *
	 * @param	string	$fieldName
	 * @return	string
	 */
	public static function getStore($fieldName, $tca) {
		global $LANG;
		
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
				$records = call_user_func_array($tca['itemsProcFunc'], array($table, $_fieldName));
				array_pop($records);
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


		$json = json_encode($elements);
		$store = <<<EOF
$fieldName : new Ext.data.ArrayStore({idIndex: 0, fields: ["$fieldName", "{$fieldName}_text"], data: $json})
EOF;
		return $store;
	}

	/**
	 * Returns the store configuration in Json formation
	 *
	 * @global	t3lib_DB	$TYPO3_DB
	 * @param	string		$fieldName
	 * @param	string		$foreignTable
	 * @return	string
	 */
	public static function getStoreForeignTable($fieldName, $foreignTable) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		global $TCA;

		$label = Tx_Addresses_Utility_TCA::getLabel($foreignTable);
		$clause = 'deleted = 0 ';
		$clause .= t3lib_BEfunc::BEenableFields($foreignTable);
		$records = $TYPO3_DB->exec_SELECTgetRows('uid as "0", ' . $label . ' as "1"', $foreignTable, $clause);

		$json = json_encode($records);
		$store = <<<EOF
$fieldName : new Ext.data.ArrayStore({idIndex: 0, fields: ["$fieldName", "{$fieldName}_text"], data: $json, sortInfo: {field: "{$fieldName}_text", direction: "ASC"}})
EOF;
		return $store;
	}

	/**
	 * Returns the common configuration of element textarea.
	 *
	 * @param	string		$namespace
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getTextArea($namespace, &$columns, $fieldName) {
		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);
		$tca =  $columns[$fieldName]['config'];

		// Set default xtype
		$configuration['xtype'] = 'textarea';
		if (isset($tca['height'])) {
			$configuration['height'] = (int) $tca['height'];
		}
		$configuration['enableKeyEvents'] = TRUE;

		return $configuration;
	}

    /**
     * Count the number of fields that will be displayed on the editing window.
     * Useful for determining the height of the editing window.
     *
     * @param array $configuration
     * @return int
     */
    public static function getWindowHeight(Array $configuration) {
        $maximumNumberOfItems = 0;
		if (isset($configuration['items']) && is_array($configuration['items'])) {
			foreach ($configuration['items'] as $items) {

				// First case: the items contains a tabpanels
				if (isset($items['items']['xtype']) && $items['items']['xtype'] == 'tabpanel') {
					foreach($items['items']['items'] as $panel) {
						$numberOfItems = count($panel['items']);
						if ($numberOfItems > $maximumNumberOfItems) {
							$maximumNumberOfItems = $numberOfItems;
						}
					}
				}
				// Second case: the items contains *no* tabpanels
				else if (isset($items['items'])) {
					$numberOfItems = count($items['items']);
					if ($numberOfItems > $maximumNumberOfItems) {
						$maximumNumberOfItems = $numberOfItems;
					}
				}
			}
		}

        $windowHeight = 45 * $maximumNumberOfItems + 150;
        if ($windowHeight < 400) {
            $windowHeight = 400;
        }
        return $windowHeight;
    }

	/**
	 * Returns the height of the itemSelector. This value is within 150 and 300 (px).
	 *
	 * @global t3lib_DB $TYPO3_DB
	 * @param array $tca
	 * @return int
	 */
	protected static function getItemSelectorHeight($tca) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$height = 150;

		if (isset($tca['foreign_table'])) {
			$foreignTable = $tca['foreign_table'];
			$clause = 'deleted = 0 ';
			$clause .= t3lib_BEfunc::BEenableFields($foreignTable);
			$record = $TYPO3_DB->exec_SELECTcountRows('*', $foreignTable, $clause);
			$_height = $record * 22;
			// Defines the limit
			if ($_height > 150 && $_height < 300) {
				$height = $_height;
			}
		}
		return $height;
	}

	/**
	 * Returns the common configuration of element textarea.
	 *
	 * @param	string		$namespace
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getItemSelector($namespace, &$columns, $fieldName) {
		$tca =  $columns[$fieldName]['config'];
		$width = 170;
		$height = self::getItemSelectorHeight($tca);

		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);

		$configuration['xtype'] = 'itemselector';
		$configuration['imagePath'] = 'Resources/Public/Icons';
		$fromMulitSelect['width'] = $width;
		$fromMulitSelect['height'] = $height;
		$fromMulitSelect['store'] = $namespace . '.stores.' . $fieldName;
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
	 * Returns UID field
	 *
	 * @param	string		$namespace
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @return	array
	 */
	public static function getHiddenField($namespace, &$columns, $fieldName) {
		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);
		$tca =  $columns[$fieldName]['config'];

		$configuration['hidden'] = TRUE;
		$configuration['hideLabel'] = TRUE;
		return $configuration;
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
	public static function getTextField($namespace, &$columns, $fieldName) {
		global $LANG;
		$configuration = self::getCommonConfiguration($columns, $fieldName, $namespace);
		$tca =  $columns[$fieldName]['config'];

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
	 * Removes quotes around renderer e.g. "Ext.util.Format.dateRenderer('d.m.Y')"
	 * * Removes quotes around object e.g. "Addresses.stores.blabla" becomes Addresses.stores.blabla
	 *
	 * @param	string		$namespace
	 * @param	string	$json
	 * @return	string
	 */
	public static function removesQuotes($namespace, $json) {
		$patterns[] = '/\"(Ext.util.Format.dateRenderer\(.+\))\"/isU';
		$replaces[] = '$1';
		$patterns[] = '/\"(' . $namespace . '\.functions\..+)"/isU';
		$replaces[] = '$1';
		$patterns[] = '/\"(' . $namespace . '\.stores\..+)\"/isU';
		$replaces[] = '$1';
		$patterns[] = '/\"(function.+\})\"/isU';
		$replaces[] = '$1';
		return preg_replace($patterns, $replaces, $json);
	}

	/**
	 * Returns configuration for editing a foreign table
	 *
	 * @global Language $LANG
	 * @param	string		$namespace
	 * @param	string	$foreignTable
	 * @return	array
	 */
	public static function getEditForeignTableButton($namespace, $foreignClass) {
		global $LANG;
		$configuration['xtype'] = 'button';
		$configuration['text'] = $LANG->getLL('addNewElement');
		$configuration['cls'] = 'x-btn-text-icon';
		$configuration['icon'] = 'Resources/Public/Icons/add.png';
		$configuration['anchor'] = '30%';
		$configuration['style'] = array('marginBottom' => '10px', 'marginLeft' => '65%');
		$namespace = str_replace('Tx_Addresses_Domain_Model_', '', $foreignClass);
		$function = $namespace . '.window.setTitle(Addresses.lang.new_record); ';
		$function .= $namespace . '.window.show(); ';
		$configuration['handler'] = 'function() {' . $function . '}';
		return $configuration;
	}

	/**
	 * Returns the common configuration of any elements.
	 *
	 * @global	Language	$LANG
	 * @param	array		$columns which corresponds the TCA's columns
	 * @param	array		$fieldName
	 * @param	string		$namespace
	 * @return	array
	 */
	private static function getCommonConfiguration(&$columns, $fieldName, $namespace = '') {
		global $LANG;
		// field name + label which are default values
		$configuration['name'] = $fieldName;
		$configuration['id'] = strtolower($namespace) . '_' . $fieldName;
		if (isset($columns[$fieldName]['label'])) {
			$configuration['fieldLabel'] = $LANG->sL($columns[$fieldName]['label']);
		}

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


	/**
	 * This function is called by the ['config']['itemsProcFunc']
	 *
	 * @param	string		$table
	 * @param	string		$field
	 * @return	array
	 */
	public static function getArrayForSelect($table, $field) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$_records = array();
		if (is_string($table) && is_string($field)) {
			$clause = 'deleted = 0 ';
			$clause .= t3lib_BEfunc::BEenableFields($table);
			$records = $TYPO3_DB->exec_SELECTgetRows('distinct(' . $field . ')', $table, $clause);

			// TRUE Means the uid of the option will be the same as the value
			if (!strpos($field, ',')) {
				foreach($records as $record) {
					$_records[] = array(
						$record[$field],
						$record[$field],
					);
				}
			}
		}
		return $_records;
	}

	/**
	 * This function is called by the ['config']['userFunc']
	 *
	 * @param	string		$table
	 * @param	string		$field
	 * @return	string
	 */
	public static function convertUidToValue($table, $field, $uid) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$result = '';
		if (is_string($table) && is_string($field) && (int)$uid > 0) {
			$clause = "deleted = 0 AND uid = $uid ";
			$clause .= t3lib_BEfunc::BEenableFields($table);
			$records = $TYPO3_DB->exec_SELECTgetRows('distinct(' . $field . ')', $table, $clause);
			if (isset($records[0])) {
				$result = $records[0][$field];
			}
			return $result;
		}
	}
}
?>