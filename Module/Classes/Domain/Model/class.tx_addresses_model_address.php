<?php
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
 * Model class for the 'addresses' extension.
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

class tx_addresses_model_address {

	/**
	 *
	 * @var string
	 */
	protected $clause = '';

	/**
	 *
	 * @var boolean
	 */
	protected $debug = FALSE;

	/**
	 * Constructor
	 */
	public function __construct() {
		$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
		$this->debug = (boolean) $configurations['debug'];
		$this->pid = (int) $configurations['PID'];
	}

	/**
	 * Get address(es) for the grid
	 *
	 * @param array $data: the uid of the address
	 * @return	array
	 */
	public function findById($data) {
		global $TCA, $TYPO3_CONF_VARS;
		t3lib_div::loadTCA('tx_addresses_domain_model_address');

		$clause = $this->getUidClause($data);
		$output['success'] = FALSE;
		if ($clause != '') {
			$records = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
				$this->getFields(),
				'tx_addresses_domain_model_address',
				'deleted = 0 AND hidden = 0 AND ' . $clause
			);

			// Get the intersection of the array
			if (!empty($records)) {
				$_record = $records[0];
				foreach($records as $record) {
					$_record = array_intersect($_record,$record);
				}
				$_record['uid'] = $this->getUidList($data);
				$output['success'] = TRUE;
				$output['data'] = $_record;
			}

			// Traverses all $field in order to format the date fields
			foreach ($output['data'] as $fieldName => $value) {
				if (isset($TCA['tx_addresses_domain_model_address']['columns'][$fieldName])) {
					$tca = $TCA['tx_addresses_domain_model_address']['columns'][$fieldName];
					if (isset($tca['config']['eval'])
						&& strpos($tca['config']['eval'], 'date') !== FALSE
						&& $value) {
						$output['data'][$fieldName] = date($TYPO3_CONF_VARS['SYS']['ddmmyy'], $value);
					}
				}
			}
		}
		return $output;
	}

	/**
	 * Returns the SQL clause WHERE ...
	 *
	 * @return string
	 */
	protected function getClause() {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$parameters = t3lib_div::_GET();
		if (isset($parameters['filterTxt']) && $parameters['filterTxt'] != '' && $this->clause == '') {
			$search = filter_input(INPUT_GET, 'filterTxt', FILTER_SANITIZE_STRING);
			$res = $TYPO3_DB->sql_query('SHOW COLUMNS from tx_addresses_domain_model_address;');
			$fields = array();
			while ($row = $TYPO3_DB->sql_fetch_row($res)) {
				$fieldName = $row[0];
				$fieldType = $row[1];
				if (strpos($fieldType, 'char') !== FALSE
					|| strpos($fieldType, 'text')  !== FALSE) {
						$fields[] = $fieldName;
				}
			}
			$searchClause = ' LIKE "%' . $search . '%"';
			$this->clause = implode($searchClause . ' OR ', $fields) . $searchClause ;
		}
		$and = $this->clause == '' ? '' : ' AND ';
		return $and . $this->clause;
	}

	/**
	 * Returns the SQL clause WHERE ...
	 *
	 * @return string
	 */
	protected function getSort() {
		$parameters = t3lib_div::_GET();
		$sort = 'last_name DESC';
		if (isset($parameters['sort']) && isset($parameters['dir'])) {
			if ($parameters['dir'] == 'ASC' || $parameters['dir'] == 'DESC') {
				$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING);
				$sort .= ' ' . $parameters['dir'];
			}
		}
		return $sort;
	}

	/**
	 * Returns LIMIT 3 OFFSET 0
	 * @return string
	 */
	protected function getOrderBy() {
		$request = '';
		$parameters = t3lib_div::_GET();
		if (isset($parameters['limit'])) {
			$limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_NUMBER_INT);
			$start = 0;
			if (isset($parameters['start'])) {
				$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT);
			}
			$request = $limit . ' OFFSET ' . $start;
		}
		return $request;
	}

	/**
	 * Get addresses for the grid
	 *
	 * @return	string
	 */
	public function findAll() {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;

		$request = $TYPO3_DB->SELECTquery(
			$this->getFields(),
			'tx_addresses_domain_model_address',
			'deleted = 0 AND hidden = 0' . $this->getClause(),
			'', // groupBy
			$this->getSort(), // orderBy
			$this->getOrderBy()
		);


		if ($this->debug) {
			t3lib_div::devLog('Select records: ' . $request, 'addresses', -1);
		}
		// Log the search
		if ($this->debug && isset($parameters['filterTxt']) && $parameters['filterTxt'] != '') {
			t3lib_div::devLog('Search records: ' . $request, 'addresses', 0);
		}

		$res = $TYPO3_DB->sql_query($request);

		$records = array();
		if (!$TYPO3_DB->sql_error()) {
			while($records[] = $TYPO3_DB->sql_fetch_assoc($res));
			array_pop($records);
			$TYPO3_DB->sql_free_result($res);
		}

		$results = $TYPO3_DB->exec_SELECTgetRows(
			'count(*) as total',
			'tx_addresses_domain_model_address',
			'deleted = 0 AND hidden = 0' . $this->getClause()
		);

		$output['success'] = TRUE;
		$output['total'] = $results[0]['total'];
		$output['data'] = $records;
		return $output;
	}


	/**
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $data
	 * @return string
	 */
	protected function getFields() {
		global $TCA, $BE_USER;
		t3lib_div::loadTCA('tx_addresses_domain_model_address');
		$columns = $TCA['tx_addresses_domain_model_address']['columns'];
		$fields = array();
		foreach (array_keys($columns) as $field) {
			if ($BE_USER->isAdmin() ||
				!isset($columns[$field]['exclude']) ||
				(isset($columns[$field]['exclude']) && !$columns[$field]['exclude']) ||
				$BE_USER->check('non_exclude_fields','tx_addresses_domain_model_address:' . $field)) {
				$fields[] = $field;
			}
		}
		return implode(',', $fields);
	}


	/**
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $data
	 * @return string
	 */
	protected function getUidList($data) {
		$list = $separator = '';
		foreach ($data as $key => $value) {
			if ((int)$value->uid > 0) {
				$list .= $separator . $value->uid;
				if ($separator == '') {
					$separator = ',';
				}
			}
		}
		return $list;
	}

	/**
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $data
	 * @return string
	 */
	protected function getUidClause($data) {
		$clause = $separator = '';
		foreach ($data as $key => $value) {
			if ((int)$value->uid > 0) {
				$clause .= $separator . 'uid=' . $value->uid;
				if ($separator == '') {
					$separator = ' OR ';
				}
			}
		}
		return $clause;
	}

	/**
	 * Delete the address(es)
	 *
	 * @param array $data: the uid of the address(es)
	 * @return	boolean
	 */
	public function delete($data) {
		global $TYPO3_DB;

		// Retireves the clause
		$clause = $this->getUidClause($data);

		// Executes query
		$request = $TYPO3_DB->UPDATEquery(
			'tx_addresses_domain_model_address',
			$clause,
			array('deleted' => 1)
		);
		$config = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
		if ($this->debug) {
			t3lib_div::devLog('Delete records: ' . $request, 'addresses', -1);
		}
		return $TYPO3_DB->sql_query($request);
	}

	/**
	 * Checks whether the parameter's value is authorized or not.
	 *
	 * @param array $configuration
	 * @param string $value
	 * @return boolean
	 */
	protected function validateComboboxValue($configuration, $value) {
		$result = FALSE;

		// Check whether the value that are passed are suitable
		if (isset($configuration['editable']) && !$configuration['editable']) {
			if (is_array($configuration['items'])) {
				foreach ($configuration['items'] as $item) {
					if ($value == $item[1]) {
						$result = TRUE;
						break;
					}
				}
			}
		}
		else {
			$result = TRUE;
		}
		return $result;
	}

	/**
	 * Checks whether the value that has been given as parameter equals the default value. If yes return TRUE ; in the contrary FALSE.
	 *
	 * @global language $LANG
	 * @param array $configuration
	 * @param string $value
	 * @return boolean
	 */
//	protected function isDefaultValue($configuration, $value) {
//		global $LANG;
//		$result = FALSE;
//
//		// Check whether it is not the default value
//		if (isset($configuration['emptyText'])) {
//			if ($value == $LANG->sL($configuration['emptyText'])) {
//				$result = TRUE;
//			}
//		}
//		return $result;
//	}

	/**
	 * Save address(es): UPDATE or INSERT depending on the uid
	 *
	 * @return array
	 */
	public function save() {
		$values = t3lib_div::_GET();
		t3lib_div::loadTCA('tx_addresses_domain_model_address');
		global $TCA, $LANG, $BE_USER, $TYPO3_DB;
		foreach ($values as $fieldName => $value) {
			if (isset($TCA['tx_addresses_domain_model_address']['columns'][$fieldName])) {
				$tca = $TCA['tx_addresses_domain_model_address']['columns'][$fieldName];

				// Makes sure the field can be saved
				if ($this->checkPermission($tca, $fieldName)) {

				// Sanitize the value
					$value = $this->sanitizeField($tca['config'], $fieldName, $value);

					// Does some additional control
					switch ($tca['config']['type']) {
						case 'input':
							$fields[$fieldName] = $value;
							// Evaluates the date
							if (isset($tca['config']['eval'])) {
								if(strpos($tca['config']['eval'], 'date') !== FALSE) {
									$fields[$fieldName] = strtotime($fields[$fieldName]);
								}
							}
							break;
						case 'select':
							if ($this->validateComboboxValue($tca['config'], $value)) {
								$fields[$fieldName] = $value;
							}
							break;
						case 'passthrough':
							break;
					}
				}
			}
		} // end foreach

		// Defines here whether it is a "multiple" update or "single" update
		$uids = array();
		if ($values['uid'] != '') {
			$uids = explode(',', $values['uid']);
		}
		// Checks wheter $uids contains array
		foreach($uids as $uid) {
			if ((int) $uid < 1) {
				die('uid should be an integer');
			}
		}

		// TRUE means update the record
		if ((int) $uids > 0) {
		// TRUE means multiple edit
			if (count($uids) > 1) {
				foreach ($fields as $key => &$field) {
					if ($field == '') {
						unset($fields[$key]);
					}
				}
			}

			$fields['tstamp'] = time();
			$fields['pid'] = $this->pid;
			$request = $TYPO3_DB->UPDATEquery(
				'tx_addresses_domain_model_address',
				'uid=' .implode(' OR uid=', $uids),
				$fields
			);
			if ($this->debug) {
				t3lib_div::devLog('Update record: ' . $request, 'addresses', -1);
			}
			$result = $TYPO3_DB->sql_query($request);
			if ($result) $result = 'UPDATE';
		}
		else {
			$fields['cruser_id'] = $BE_USER->user['uid'];
			$fields['tstamp'] = time();
			$fields['crdate'] = time();
			$fields['pid'] = $this->pid;
			$request = $TYPO3_DB->INSERTquery(
				'tx_addresses_domain_model_address',
				$fields
			);
			if ($this->debug) {
				t3lib_div::devLog('New record: ' . $request, 'addresses', -1);
			}
			$result = $TYPO3_DB->sql_query($request);
			if ($result) $result = 'INSERT';
		}
		return $result;
	}

	/**
	 * Makes sure the return values are the correct ones
	 *
	 * @param array $configuration
	 * @param string $key
	 * @param string $value
	 * @return array
	 */
	protected function sanitizeField(Array $configuration, $key, $value) {
		switch($configuration['type']) {
			case 'input':
			case 'select':
			// Shortens size of string
				if (isset($configuration['size'])) {
					$value = substr($value, 0, $configuration['size']);
				}
				$value = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
				break;
			case 'passthrough':
				break;
			default:
				t3lib_div::debug($configuration, '$configuration');
				die('<b>Invalid configuration</b>');
				break;
		}
		return trim($value);
	}

	/**
	 * Check whether the fields is going to be displayed
	 *
	 * @global Object $BE_USER
	 * @param array $tca
	 * @param string $field
	 * @return boolean
	 */
	protected function checkPermission(&$tca, $field) {
		global $BE_USER;
		$hasPermission = FALSE;
		if ($BE_USER->isAdmin() ||
			(isset($tca[$field]['exclude']) && !$tca[$field]['exclude']) ||
			$BE_USER->check('non_exclude_fields','tx_addresses_domain_model_address:' . $field)) {
			$hasPermission = TRUE;
		}
		return $hasPermission;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/Classes/Domain/Model/class.tx_addresses_model_tables.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/Classes/Domain/Model/class.tx_addresses_model_tables.php']);
}

?>