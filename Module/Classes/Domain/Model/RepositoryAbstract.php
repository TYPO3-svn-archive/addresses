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

abstract class Tx_Addresses_Domain_Model_RepositoryAbstract {

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
	 *
	 * @var string
	 */
	protected $tableName;

	/**
	 *
	 * @var array
	 */
	protected $foreignTables = FALSE;

	/**
	 *
	 * @var string
	 */
	protected $namespace;

	/**
	 * Constructor
	 */
	public function __construct($namespace) {
		$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
		$this->debug = (boolean) $configurations['debug'];
		$this->pid = (int) $configurations['PID'];
		$this->tableName = 'tx_addresses_domain_model_' . strtolower($this->namespace);
		$this->namespace = $namespace;
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
			'*',
			$this->tableName,
			$this->getClause(),
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

		// Fields from Grid TCA are merged into the Columns's TCA
		$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);
		$columnsFromGrid = Tx_Addresses_Utility_TCA::getFieldsFromGrid($this->namespace);
		$fieldsFromGrid = $this->getFields($columnsFromGrid, $this->tableName);

		// Formats array
		$records = array();
		if (!$TYPO3_DB->sql_error()) {
			while($record = $TYPO3_DB->sql_fetch_assoc($res)) {

				// Format the content
				$record = $this->formatForHumans($record, $columns);

				// Only keep the fields that are going to be displayed in the grid.
				foreach ($fieldsFromGrid as $fieldName) {
					$_record[$fieldName] = $record[$fieldName];
				}
				
				// Gets the expander HTML
				$_record['expander'] = $this->getExpander($record);

				array_push($records, $_record);
			}
			$TYPO3_DB->sql_free_result($res);
		}

		$results = $TYPO3_DB->exec_SELECTgetRows(
			'count(*) as total',
			$this->tableName,
			$this->getClause()
		);

		$output['success'] = TRUE;
		$output['total'] = $results[0]['total'];
		$output['records'] = $records;
		return $output;
	}

	/**
	 * Get the HTML that goes in the expander field
	 *
	 * @global t3lib_DB $TYPO3_DB
	 * @param array $record
	 * @return string
	 */
	protected function getExpander($record) {
		global $TYPO3_DB, $LANG;
		
		// Fetches the template
		$expanderTemplate = Tx_Addresses_Utility_TCA::getExpanderTemplate($this->tableName);
		$templatePath = $this->resolvePath($expanderTemplate);
		$template = t3lib_div::makeInstance('Tx_Addresses_Temp_Template', $templatePath);

		// Set template variables
		$template->set('address', $record);
		$columns = Tx_Addresses_Utility_TCA::getColumns($this->tableName);
		foreach ($columns as $fieldName => $tca) {
			$config = $tca['config'];
			if ($config['foreign_table']) {
				if (isset($config['MM'])) {
					$subRecords = $TYPO3_DB->exec_SELECTgetRows(
						'*',
						$config['foreign_table'],
						'uid in (SELECT uid_foreign FROM ' . $config['MM'] . ' WHERE uid_local = ' . $record['uid'] . ' AND ' . $config['MM'] . '.deleted = 0)'
					);
				}
				else {
					$subRecords = $TYPO3_DB->exec_SELECTgetRows(
						'*',
						$config['foreign_table'],
						'uid_foreign  = ' . $record['uid'] . ' AND ' . $config['foreign_table'] . '.deleted = 0'
					);
				}
				
				// Format sub records
				$subColumns = Tx_Addresses_Utility_TCA::getColumns($config['foreign_table']);
				$_subRecords = array();
				foreach ($subRecords as &$subRecord) {
					$subRecord = $this->formatForHumans($subRecord, $subColumns);
				}
				$template->set($fieldName, $subRecords);
			}
		}

		$content = $template->fetch();


		// translates labels
		preg_match_all('/#{3}(.+)#{3}/isU', $content, $matches, PREG_SET_ORDER);
		foreach($matches as $match) {
			$marker = $match[0];
			$label = $match[1];
			$content = str_replace($marker, $LANG->sL($label), $content);
		}
		return $content;
	}


	/**
	 * Substitutes EXT: with extension path in a file path
	 *
	 * @param string The path
	 * @return string The resolved path
	 * @static
	 */
	protected function resolvePath($path) {
		$path = explode('/', $path);
		if(strpos($path[0], 'EXT') > -1) {
			$parts = explode(':', $path[0]);
			$path[0] = t3lib_extMgm::extPath($parts[1]);
		}
		$path = implode('/', $path);
		$path = str_replace('//', '/', $path);
		return $path;
	}

	/**
	 * Get address(es) for the grid
	 *
	 * @param array $dataSet: the uid of the address
	 * @return	array
	 */
	public function findById($dataSet) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$clause = $this->getUidClause($dataSet);
		$clause .= ' AND deleted = 0';
		$clause .= t3lib_BEfunc::BEenableFields($this->tableName);
		$output['success'] = FALSE;
		if ($clause != '') {
			$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);
			$records = $TYPO3_DB->exec_SELECTgetRows(
				$this->getFieldsName($columns, $this->tableName),
				$this->tableName,
				$clause
			);

			foreach($records as &$record) {
				foreach($this->foreignTables as $fieldName => $tca) {
					$record[$fieldName] = $this->getRelatedRecords($dataSet[0]->uid, $tca);
				}
			}

			// Gets the intersection of the array whenever editing multiple records.
			if (!empty($records)) {
				$_record = $records[0];
				foreach($records as $record) {
					$_record = array_intersect($_record,$record);
				}
				$_record['uid'] = $this->getUidList($dataSet);
				$output['success'] = TRUE;
				$output['record'] = $_record;
			}

			// Fields from Grid TCA are merged into the Columns's TCA
			$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);
			// data is mandatory for ExtJS
			$output['data'] = $this->formatForHumans($output['record'], $columns);
		}
		return $output;
	}

	/**
	 * Get the uid from a MM relation
	 *
	 * @global t3lib_DB $TYPO3_DB
	 * @param int $uid
	 * @param array $tca
	 * @return array
	 */
	protected function getRelatedRecords($uid, &$tca) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;

		// Namespace is necessary for fetching the fields
		$tableName = $tca['config']['foreign_table'];
		$columns = Tx_Addresses_Utility_TCA::getColumns($tableName);
		$fields = $this->getFieldsName($columns, $tca['config']['foreign_table']);
		if (isset($tca['config']['MM'])) {
			$clause = ' uid IN (SELECT uid_foreign FROM ' . $tca['config']['MM'] . ' WHERE uid_local=' . $uid . ')';
		}
		else {
			$clause = ' uid_foreign = ' . $uid;
		}
		$clause .= ' AND ' . $tableName . '.deleted = 0';
		$clause .= t3lib_BEfunc::BEenableFields($tableName);
		return $TYPO3_DB->exec_SELECTgetRows($fields, $tca['config']['foreign_table'], $clause, '', 'uid ASC');
	}

	/**
	 * Traverses the record and transforms <b>recursively</b>the dataset:
	 * <ul>
	 *	<li>tstamp to human date</li>
	 *	<li>eval</li>
	 * </ul>
	 *
	 * @param array $dataSet
	 * @return array
	 */
	protected function formatForHumans($dataSet, $columns) {
		global $LANG, $TYPO3_DB;
		$output = array();

		// Traverses all $field and formats the date
		foreach ($dataSet as $fieldName => $value) {
			if (isset($columns[$fieldName])) {

			// Shortcuts the array
				$config = $columns[$fieldName]['config'];

				// Set default value
				$output[$fieldName] = $value;

				// TRUE when value contains a sub array. Means it should call recursively formatForHumans
				if (is_array($value) && isset($config['foreign_table'])) {
				// Gets the namespace + the columns
					$_columns = Tx_Addresses_Utility_TCA::getColumns($config['foreign_table']);
					$_records = array();
					foreach ($value as $_value) {
						$_records[] = $this->formatForHumans($_value, $_columns);
					}
					$output[$fieldName] = $_records;
				}
				// eval function
				elseif (isset($config['eval']) && $value) {

					switch ($config['eval']) {
						case 'date':
							$output[$fieldName] = date(Tx_Addresses_Utility_Configuration::getDateFormat(), $value);
							$output[$fieldName . 'Time'] = date(Tx_Addresses_Utility_Configuration::getDateFormat() . ' @ H:i:s', $value);
							break;
						case 'nbsp':
							$output[$fieldName .'_evaluated'] = str_replace(' ', '&nbsp;', $value);
							break;
					}
				}
				// eval function
				elseif ($config['type'] == 'select' && isset($config['items'])) {

				// When $value == 0, sets '' otherwise the default value is Okay.
					$output[$fieldName . '_text'] = $value == 0 ? '' : 0;

					// Tries to find out the text value
					foreach ($config['items'] as $items) {
						$_value = $LANG->sL($items[1]);
						if ($_value == $value) {
							$output[$fieldName . '_text'] = $LANG->sL($items[0]);
							break;
						}
					}

				}
				// eval function
				elseif ($config['type'] == 'select' && isset($config['foreign_table']) && isset($config['itemsProcFunc.'])) {
					$_fieldName = $config['itemsProcFunc.']['field'];
					$_tableName = $config['itemsProcFunc.']['table'];
					if ((int) $value > 0) {
						$records = $TYPO3_DB->exec_SELECTgetRows($_fieldName, $_tableName, 'deleted = 0 AND hidden= 0 AND uid = ' . $value);
						if (isset($records[0][$_fieldName])) {
							$output[$fieldName . '_text'] = $records[0][$_fieldName];
						}
						else {
							$output[$fieldName . '_text'] = '';
						}
					}
				}
				// userFuncFormat
				elseif (isset($config['userFuncFormat'])) {
					$table = $config['userFuncFormat.']['table'];
					$field = $config['userFuncFormat.']['field'];
					$output[$fieldName] = call_user_func_array($config['userFuncFormat'], array($table, $field, $value));
				}
				else {
					$output[$fieldName] = $value;
				}
			}
		}
		return $output;
	}

	/**
	 * Returns the SQL clause WHERE. Stores the clause for performance purposes.
	 *
	 * @return string
	 */
	protected function getClause() {
	//Default value of clause
		if ($this->clause == '') {

		// Builds up the clause when searching for a string
			$parameters = t3lib_div::_GET();
			if (isset($parameters['filterTxt']) && $parameters['filterTxt'] != '') {
				$search = filter_input(INPUT_GET, 'filterTxt', FILTER_SANITIZE_STRING);

				$this->clause = $this->getSearchClause($search, $this->tableName);

				// Handle a special table
				$foreignTables['be_users'] = array(
					'localField' => 'cruser_id',
					'includedFields' => array('username', 'realName', 'email'),
					'foreign_table' => 'be_users',
				);
				// Merge tables from the foreignTables
				$foreignTables = array_merge($foreignTables, $this->getForeignTables());

				// fetch other condition
				foreach ($foreignTables as $foreignTable => $data) {
				// Builds request for the 2 possible relations:
				// 1. M-M relation
				// 2. 1-M relation
					if (isset($data['MM'])) {
						$this->clause .= ' OR uid IN (SELECT uid_local FROM ' . $data['MM'] . ' WHERE tablenames = "' . $data['foreign_table'] . '" AND uid_foreign IN (SELECT uid FROM ' . $data['foreign_table'] . ' WHERE ' . $this->getSearchClause($search, $data['foreign_table']) . '))';
					}
					else {
						$includedFields = array();
						if (isset($data['includedFields'])) {
							$includedFields = $data['includedFields']; // Maybe it is a better idea to work on *exclude* fields
						}
						$message = $this->getSearchClause($search, $data['foreign_table'], $includedFields);
						$uid = isset($data['localField']) ? $data['localField'] : 'uid';
						$this->clause .= ' OR ' . $uid . ' IN (SELECT uid FROM ' . $data['foreign_table'] . ' WHERE ' . $this->getSearchClause($search, $data['foreign_table'], $includedFields) . ')';
					}
				}
				$this->clause = '(' . $this->clause . ')';
			} // end if

			$enableFields = 'deleted = 0 ';
			$enableFields .= t3lib_BEfunc::BEenableFields($this->tableName);
			$and = $this->clause == '' ? '': ' AND ';
			$this->clause = $enableFields . $and . $this->clause;
		}
		return $this->clause;
	}

	/**
	 * Returns a clause part
	 *
	 * @global t3div_DB $TYPO3_DB
	 * @param string $search
	 * @param string $tableName
	 * @param array $fields
	 * @return string
	 */
	protected function getSearchClause($search, $tableName, $fields = array()) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;

		if (empty($fields)) {
			$res = $TYPO3_DB->sql_query('SHOW COLUMNS from ' . $tableName);
			$fields = array();
			while ($row = $TYPO3_DB->sql_fetch_row($res)) {
				$fieldName = $row[0];
				$fieldType = $row[1];
				if (strpos($fieldType, 'char') !== FALSE
					|| strpos($fieldType, 'text')  !== FALSE) {
					$fields[] = $fieldName;
				}
			}
		}

		$searchClause = ' LIKE "%' . $search . '%"';
		$searchClause = implode($searchClause . ' OR ', $fields) . ' LIKE "%' . $search . '%"';
		$searchClause .= ' AND ' . $tableName . '.deleted = 0 ';
		$searchClause .= t3lib_BEfunc::BEenableFields($tableName);
		return $searchClause;
	}

	/**
	 * Returns the foreign tables.
	 *
	 * @return array
	 */
	protected function getForeignTables() {
		$result = array();
		$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);
		foreach ($columns as $fieldName => $column) {
			if (isset($column['config']['foreign_table'])) {
				$_result = array();
				$_result['foreign_table'] = $column['config']['foreign_table'];
				if (isset($column['config']['MM'])) {
					$_result['MM'] = $column['config']['MM'];
				}
				$result[$fieldName] = $_result;
			}
		}
		return $result;
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
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $data
	 * @return string
	 */
	protected function getFieldsName($columns, $tableName) {
		$fields = $this->getFields($columns, $tableName);
		return implode(',', $fields);
	}

	/**
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $data
	 * @return array
	 */
	protected function getFields($columns, $tableName) {
		global $BE_USER;
		$fields = array();
		foreach (array_keys($columns) as $fieldName) {
			if ($BE_USER->isAdmin()
				|| !isset($columns[$fieldName]['exclude'])
				|| (isset($columns[$fieldName]['exclude']) && !$columns[$fieldName]['exclude'])
				|| $BE_USER->check('non_exclude_fields', $tableName . ':' . $fieldName)) {

				$fields[] = $fieldName;

				// Stores foreign table for later use
				if (isset($columns[$fieldName]['config']['foreign_table'])) {
				// && isset($columns[$fieldName]['config']['MM'])
					$this->foreignTables[$fieldName] = $columns[$fieldName];
				}
			}
		}
		return $fields;
	}


	/**
	 * Builds up the clause e.g.uid=10 AND uid=8
	 * @param array $dataSet
	 * @return string
	 */
	protected function getUidList($dataSet) {
		$list = $separator = '';
		foreach ($dataSet as $key => $value) {
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
	 * @param array $dataSet
	 * @return string
	 */
	protected function getUidClause($dataSet) {
		$clause = $separator = '';
		foreach ($dataSet as $key => $value) {
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
	 * Delete foreign table
	 *
	 * @param array $data: the uid of the address(es)
	 * @return	boolean
	 */
	private function deleteForeignTable($dataSet) {
		global $TYPO3_DB;

		// Fetches the foreign tables
		$foreignTables = $this->getForeignTables();

		// Retireves the clause
		foreach ($dataSet as $key => $value) {
			if ((int)$value->uid > 0) {

				foreach ($foreignTables as $foreignTable) {
					if (isset($foreignTable['MM'])) {
						$tableName = $foreignTable['MM'];
						$clause = 'uid_local = ' . $value->uid;
					}
					else {
						$tableName = $foreignTable['foreign_table'];
						$clause = 'uid_foreign = ' . $value->uid;
					}

					$request = $TYPO3_DB->UPDATEquery(
						$tableName,
						$clause,
						array('deleted' => 1)
					);
					if ($this->debug) {
						t3lib_div::devLog('Delete records: ' . $request, 'addresses', -1);
					}
					$TYPO3_DB->sql_query($request);
				}
			}
		}
	}
	/**
	 * Delete the address(es)
	 *
	 * @param array $data: the uid of the address(es)
	 * @return	boolean
	 */
	public function delete($dataSet) {
		global $TYPO3_DB;

		// Deletes sub records
		$this->deleteForeignTable($dataSet);

		// Deletes main record
		$clause = $this->getUidClause($dataSet);
		$request = $TYPO3_DB->UPDATEquery(
			$this->tableName,
			$clause,
			array('deleted' => 1)
		);
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
	 * @param	array	$values
	 * @return	array	Beware: cell 'records' may return multiple records in case of multi editing
	 */
	public function save($dataSet) {
		$dataSet = t3lib_div::_GET();
		t3lib_div::loadTCA($this->tableName);
		/* @var $TYPO3_DB t3lib_DB */
		global $TCA, $LANG, $TYPO3_DB;

		// Init variables
		$fields = $foreignTables = array();

		foreach ($dataSet as $fieldName => $value) {
			$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);
			if (isset($columns[$fieldName])) {
				$tca = $columns[$fieldName];

				// Makes sure the field can be saved
				if ($this->hasPermission($tca, $fieldName)) {

				// Sanitize the value
					$value = $this->sanitizeField($tca['config'], $fieldName, $value);

					// Does some additional control
					switch ($tca['config']['type']) {
						case 'text':
							$fields[$fieldName] = $value;
							break;
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
							if (isset($tca['config']['foreign_table']) && isset($tca['config']['MM'])) {
								// Counts the number of element
								if ($value == '') {
									$fields[$fieldName] = 0;
								}
								else {
									$fields[$fieldName] = count(explode(',', $value));
									$foreignTables[$fieldName] = $value;
								}
							}
							elseif (isset($tca['config']['foreign_table'])) {
								$fields[$fieldName] = $value;
							}
							elseif ($this->validateComboboxValue($tca['config'], $value)) {
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
		if ($dataSet['uid'] != '') {
			$uids = explode(',', $dataSet['uid']);
		}

		// Checks wheter $uid are arrays
		foreach($uids as $uid) {
			if ((int) $uid < 1) {
				throw new Exception('uid field should be an integer');
			}
		}

		// TRUE means update the record
		if ((int) $uids > 0) {
		// TRUE means multiple edit
			if (count($uids) > 1) {
			// Removes empty field
				foreach ($fields as $key => &$field) {
					if ($field == '') {
						unset($fields[$key]);
					}
				}
			}
			$this->saveUpdate($uids, $fields, $foreignTables);
			$result['request'] = 'UPDATE';
		}
		else {
		// Saves in form of array. The user may update multiple records
			$uids = array($this->saveInsert($fields, $foreignTables));
			$result['request'] = 'INSERT';
		}

		// Loads the data
		$columns = Tx_Addresses_Utility_TCA::getColumns($this->tableName);
		$records = $TYPO3_DB->exec_SELECTgetRows('*', $this->tableName, $this->getUidsClause($uids));
		foreach ($records as $record) {
			$result['records'][] = $this->formatForHumans($record, $columns);
		}
		return $result;
	}

	/**
	 * Format a uid string uid = 1 OR uid = 2 etc...
	 *
	 * @param array $uids
	 * @return string
	 */
	protected function getUidsClause($uids) {
		$uidsClause = implode(' OR uid = ', $uids);
		return 'uid =' . $uidsClause;
	}

	/**
	 * Update a record
	 *
	 * @global  $BE_USER
	 * @global t3lib_DB $TYPO3_DB
	 * @param array $uids
	 * @param array $fields
	 */
	protected function saveUpdate($uids, $fields, $foreignTables) {
		/* @var $TYPO3_DB t3lib_DB */
		global $BE_USER, $TYPO3_DB;
		$fields['tstamp'] = time();
		$fields['upuser_id'] = $BE_USER->user['uid'];
		$fields['pid'] = $this->pid;
		$request = $TYPO3_DB->UPDATEquery(
			$this->tableName,
			'uid=' .implode(' OR uid=', $uids),
			$fields
		);
		if ($this->debug) {
			t3lib_div::devLog('Update record: ' . $request, 'addresses', -1);
		}
		if ($TYPO3_DB->sql_query($request)) {

			if (!empty($foreignTables)) {
				$this->saveMMRelation($uids, $foreignTables);
			}
		}
	}

	/**
	 * Insert a new record
	 *
	 * @global  $BE_USER
	 * @global t3lib_DB $TYPO3_DB
	 * @param array $fields
	 * @return int
	 */
	protected function saveInsert($fields, $foreignTables) {
		/* @var $TYPO3_DB t3lib_DB */
		global $BE_USER, $TYPO3_DB;

		$fields['pid'] = $this->pid;
		$fields['tstamp'] = time();
		$fields['crdate'] = time();
		$fields['cruser_id'] = $BE_USER->user['uid'];
		$fields['upuser_id'] = $BE_USER->user['uid'];
		$request = $TYPO3_DB->INSERTquery(
			$this->tableName,
			$fields
		);
		if ($this->debug) {
			t3lib_div::devLog('New record: ' . $request, 'addresses', -1);
		}

		if ($TYPO3_DB->sql_query($request)) {
			$uid = $TYPO3_DB->sql_insert_id();
			if (!empty($foreignTables)) {
				$this->saveMMRelation(array($uid), $foreignTables);
			}
		}
		return isset($uid) ? $uid : 0;
	}

	/**
	 * Saves multi relation
	 *
	 * @global t3lib_DB $TYPO3_DB
	 * @param array $uids
	 * @param string $foreignTables
	 */
	protected function saveMMRelation($uids, $foreignTables) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$columns = Tx_Addresses_Utility_TCA::getColumns($this->namespace);

		foreach ($foreignTables as $tableName => $values) {
			$tca = $columns[$tableName];
			if (isset($tca['config']['MM']) || isset($tca['config']['foreign_table'])) {

			// Delete all record
				$table = $tca['config']['MM'];
				foreach ($uids as $uid) {
					$TYPO3_DB->exec_DELETEquery($table, 'uid_local = ' . $uid);

					$index = 1;
					foreach ( explode(',', $values) as $value) {
						$fields_values['uid_local'] = $uid;
						$fields_values['uid_foreign'] = $value;
						$fields_values['tablenames'] = $tca['config']['foreign_table'];
						$fields_values['sorting'] = $index++;
						$TYPO3_DB->exec_INSERTquery($table, $fields_values);
					}
				}
			}
			else {
				throw new Exception('<b>Missing configuration</b> "MM" or "foreign_table" in ' . __FILE__ . ', line: ' . __LINE__);
			}
		}
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
			case 'text':
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
				throw new Exception('<b>Invalid configuration</b> in ' . __FILE__ . ', line: ' . __LINE__);
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
	protected function hasPermission(&$tca, $field) {
		global $BE_USER;
		$hasPermission = FALSE;
		if ($BE_USER->isAdmin() ||
			(isset($tca[$field]['exclude']) && !$tca[$field]['exclude']) ||
			$BE_USER->check('non_exclude_fields', $this->tableName . ':' . $field)) {
			$hasPermission = TRUE;
		}
		return $hasPermission;
	}
}

?>