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
 * Default index for the BE module
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @version $Id$
 */

// Default initialization of the module
unset($MCONF);
require('conf.php');
require($BACK_PATH . 'init.php');
require($BACK_PATH . 'template.php');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');

// Check user permissions
$BE_USER->modAccess($MCONF, 1);	// This checks permissions and exits if the users has no permission for entry.
$LANG->includeLLFile('EXT:addresses/Module/locallang.xml');

/**
 * Module 'addresses' for the 'addresses' extension.
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */
class  tx_addresses_module extends t3lib_SCbase {

	/**
	 * @var template
	 */
	public $doc;

	/**
	 * @var $namespace string
	 */
	protected $namespace = 'Addresses';

	/**
	 * @var $javascriptFiles array
	 */
	protected $javascriptFiles = array('ext_expander', 'search_field', 't3_addresses_init', 't3_addresses_grid', 't3_addresses_window');

	/**
	 * @var $relativePath string
	 */
	protected $relativePath;

	/**
	 * @var $pageRecord array
	 */
	protected $pageRecord = array();

	/**
	 * @var $ string
	 */
	protected $isAccessibleForCurrentUser = TRUE;

	/**
	 * @var $pagingSize string
	 */
	protected $pagingSize = 200;

	/**
	 * @var $minifyJavascript string
	 */
	protected $minifyJavascript = FALSE;

	/**
	 * @var $version string
	 */
	protected $version = '1.0.0';

	/**
	 * @var $store array
	 */
	protected $store = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::init();

		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->setModuleTemplate(t3lib_extMgm::extPath('addresses') . 'Module/template.html');
		$this->doc->backPath = '../../../../typo3/';

		//don't access in workspace
		if ($GLOBALS['BE_USER']->workspace !== 0) {
			$this->isAccessibleForCurrentUser = false;
		}

		//read configuration
		$modTS = $GLOBALS['BE_USER']->getTSConfig('mod.addresses');
		if (isset($modTS['properties']['pagingSize']) && intval($modTS['properties']['pagingSize']) > 0) {
			$this->pagingSize = intval($modTS['properties']['pagingSize']);
		}

		$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
		$this->pageSize = (int) $configurations['PAGE_SIZE'];
		$this->minifyJavascript = (boolean) $configurations['minifyJavascript'];
		$this->relativePath = t3lib_extMgm::extRelPath('addresses');
		$this->absolutePath = t3lib_extMgm::extPath('addresses');
		$this->resourcesPath = $this->relativePath . 'Module/Resources/Public/';

		// Get version number
		$_EXTKEY = 'addresses';
		require($this->absolutePath .'/ext_emconf.php');
		$this->version = $EM_CONF['addresses']['version'];
	}


	/**
	 * Initializes the Module
	 *
	 * @return	void
	 */
	public function initialize() {
		parent::init();
		$this->doc = t3lib_div::makeInstance('template');
		$this->doc->setModuleTemplate(t3lib_extMgm::extPath('addresses') . 'Module/template.html');
		$this->doc->backPath = '../../../../typo3/';
		//		$this->doc->backPath = '/typo3/';

		$this->relativePath = t3lib_extMgm::extRelPath('addresses');
		$this->absolutePath = t3lib_extMgm::extPath('addresses');
		$this->resourcesPath = $this->relativePath . 'Module/Resources/Public/';

		//don't access in workspace
		if ($GLOBALS['BE_USER']->workspace !== 0) {
			$this->isAccessibleForCurrentUser = false;
		}

		//read configuration
		$modTS = $GLOBALS['BE_USER']->getTSConfig('mod.addresses');
		if (isset($modTS['properties']['pagingSize']) && intval($modTS['properties']['pagingSize']) > 0) {
			$this->pagingSize = intval($modTS['properties']['pagingSize']);
		}
	}

	/**
	 * Renders the contente of the module.
	 *
	 * @return	void
	 */
	public function render() {
		global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;
		if ($this->isAccessibleForCurrentUser) {
			$this->loadHeaderData();
			// div container for renderTo
			$this->content .= '<div id="addressesContent"></div>';
		} else {
		// If no access or if ID == zero
			$this->content .= $this->doc->spacer(10);
		}
	}

	/**
	 * Flushes the rendered content to browser.
	 *
	 * @return	void
	 */
	public function flush() {
		$content = $this->doc->startPage($GLOBALS['LANG']->getLL('title'));
		$content.= $this->doc->moduleBody(
			$this->pageRecord,
			$this->getDocHeaderButtons(),
			$this->getTemplateMarkers()
		);
		$content.= $this->doc->endPage();
		//		$content.= $this->doc->insertStylesAndJS($this->content);

		$this->content = null;
		$this->doc = null;

		echo $content;
	}

	/**
	 * Loads ExtJS staff: JS + CSS
	 */
	protected function loadExtJSStaff() {
	// Loads extjs
		$this->doc->loadExtJS();
		//		$this->doc->enableExtJsDebug(); // use for debug

		// Load special CSS Stylesheets:
		$this->loadStylesheet($this->resourcesPath . 'Stylesheets/customExtJs.css');

		// Load special JS
		if ($this->minifyJavascript) {
			$tempFolder = PATH_site . 'typo3temp/tx_addresses/';
			$tempFileName = 'addresse-' . $this->version . '.js';
			$tempFile = $tempFolder . $tempFileName;
			if (!is_dir($tempFolder)) {
				t3lib_div::mkdir($tempFolder);
			}

			if (!is_file($tempFile)) {
				$fileContent = '';
				foreach($this->javascriptFiles as $file) {
					$filename = $this->absolutePath . 'Module/Resources/Public/Javascript/' . $file . '.js';
					$fileContent .= t3lib_div::minifyJavaScript(file_get_contents($filename));
				}
				t3lib_div::writeFileToTypo3tempDir($tempFile, $fileContent);
			}
			$this->loadJavaScript('../typo3temp/tx_addresses/' . $tempFileName);
		}
		else {
		// Load Plugins JavaScript:
			foreach($this->javascriptFiles as $file) {
				$this->loadJavaScript($this->resourcesPath . 'Javascript/' . $file . '.js');
			}
		}

	}

	/**
	 * Loads data in the HTML head section (e.g. JavaScript or stylesheet information).
	 *
	 * @return	void
	 */
	protected function loadHeaderData() {
		$this->loadExtJSStaff();

		// Integrate dynamic JavaScript such as configuration or lables:
		$fieldsColumns = $this->getFieldsColumns();
		$fieldsName = $this->getFieldsName($fieldsColumns);
		$fieldsEdition = $this->getFieldsEdition();

		$this->store[] = $this->getLocationStore();

		$this->doc->extJScode .= '
			' . $this->namespace . '.store = {' . implode(',', $this->store) . '};
			' . $this->namespace . '.statics = ' . json_encode($this->getStaticConfiguration($fieldsEdition)) . ';
			' . $this->namespace . '.fieldsColumns = ' . json_encode($fieldsColumns) . ';
			' . $this->namespace . '.fieldsName = ' . json_encode($fieldsName) . ';
			' . $this->namespace . '.fieldsEdition = ' . $this->removesQuotesAroundObject(json_encode($fieldsEdition)) . ';
			' . $this->namespace . '.lang = ' . json_encode($this->getLabels()) . ';
			Addresses.initialize();' . chr(10);
	}

	protected function getLocationStore() {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$resource = $TYPO3_DB->exec_SELECTquery('distinct(zip) , city', 'tx_addresses_domain_model_address', 'hidden=0 AND deleted=0 AND zip != "" AND city != ""');
		$records = array();
		while ($row = $TYPO3_DB->sql_fetch_row($resource)) {
			$records[] = array($row[0], $row[1]);
		}
		return '"localities": new Ext.data.SimpleStore({id:0, "fields": ["city_id", "city_text"],"data" : ' . json_encode($records) . '})';
	}

	/**
	 * Removes quotes around object e.g. "Addresses.store.blabla" becomes Addresses.store.blabla
	 *
	 * @param string $json
	 * @return string
	 */
	protected function removesQuotesAroundObject($json) {
		return preg_replace('/\"(Addresses\.store\..+)\"/isU', '$1', $json);
	}

	/**
	 * Count the number of fields. Useful for determining the height of the editing window.
	 *
	 * @param array $fieldsEdition
	 * @return int
	 */
	function getNumberOfFields(Array $fieldsEdition) {
		$numberOfItems = 0;
		for ($index = 0; $index < count($fieldsEdition); $index++) {
			$items = $fieldsEdition[$index];
			if (isset($items['items'])) {
			// decrease the number of items as there is hidden fields
				$_numberOfItems = count($items['items']);
				if ($index === 0) {
					$_numberOfItems --;
				}
				if ($_numberOfItems > $numberOfItems) {
					$numberOfItems = $_numberOfItems;
				}
			}
		}
		return $numberOfItems;
	}

	/**
	 * Loads a stylesheet by adding it to the HTML head section.
	 *
	 * @param	string		$fileName: Name of the file to be loaded
	 * @return	void
	 */
	protected function loadStylesheet($fileName) {
		$fileName = t3lib_div::resolveBackPath($this->doc->backPath . $fileName);
		$this->doc->JScode.= "\t" . '<link rel="stylesheet" type="text/css" href="' . $fileName . '" />' . "\n";
	}

	/**
	 * Loads a JavaScript file.
	 *
	 * @param	string		$fileName: Name of the file to be loaded
	 * @return	void
	 */
	protected function loadJavaScript($fileName) {
		$fileName = t3lib_div::resolveBackPath($this->doc->backPath . $fileName);
		$this->doc->JScode.= "\t" . '<script type="text/javascript" src="' . $fileName . '"></script>' . "\n";
	}

	/**
	 * Gets the JavaScript configuration for the Ext JS interface.
	 *
	 * @param	array
	 * @return	array		The JavaScript configuration
	 */
	protected function getStaticConfiguration($fieldsEdition) {
		$configuration = array(
			'pagingSize' => $this->pagingSize,
			'renderTo' => 'addressesContent',
			'path' => t3lib_extMgm::extRelPath('addresses'),
			'isSSL' => t3lib_div::getIndpEnv('TYPO3_SSL'),
			'editionHeight' => 50 * $this->getNumberOfFields($fieldsEdition) + 150,
			'ajaxController' => $this->doc->backPath . 'ajax.php',
		);
		return $configuration;
	}

	/**
	 * Return configuration of array
	 *
	 * @param array $columns that corresponds to $TCA['tx_addresses_domain_model_address']['columns']
	 * @return array $configuration
	 */
	protected function getConfiguration(&$columns, $field) {
		global $LANG, $TYPO3_CONF_VARS;

		$tca =  $columns[$field]['config'];
		$configuration = array();

		// Makes sure the user has the permission
		if ($this->checkPermission($columns, $field)) {

		// field name + label which are default values
			$configuration['name'] = $field;
			$configuration['id'] = $field;
			if (isset($columns[$field]['label'])) {
				$configuration['fieldLabel'] = $LANG->sL($columns[$field]['label']);
			}
			$configuration['selectOnFocus'] = true;

			switch($tca['type']) {
				case 'input':
				// max length
					if (isset($tca['max'])) {
						$configuration['maxLength'] = (int) $tca['max'];
					}
					if (isset($tca['default'])) {
						$configuration['value'] = $tca['default'];
					}

					// Set default xtype
					$configuration['xtype'] = 'textfield';

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
									$configuration['format'] = $TYPO3_CONF_VARS['SYS']['ddmmyy'];
									$configuration['invalidText'] = $LANG->getLL('invalidDate');
									break;
							}
						}
					}
					break;
				case 'select':
					$configuration['xtype'] = 'combo';
					$configuration['mode'] = 'local';
					$configuration['store'] = 'Addresses.store.' . $field;
					$configuration['displayField'] = $field .'_text';
					$configuration['triggerAction'] = 'all';
					$configuration['editable'] = isset($tca['editable']) ? $tca['editable'] : TRUE;

					// Add configuration for non-editable field
					if (isset($tca['editable']) && !$tca['editable']) {
						$configuration['value'] = '0'; // assume value 0 is defined in the combobox
						$configuration['valueField'] = $field;
						$configuration['hiddenName'] = $field;
						$configuration['id'] = $field . '_id'; // Must be different to avoid conflict. 2 fiels are created. One is hidden
					}

					// Fetches the value
					$options = array();
					if (isset($tca['items']) && is_array($tca['items'])) {
						foreach ($tca['items'] as $elements) {
							$options[] = array(
								$LANG->sL($elements[1]),
								$LANG->sL($elements[0]),
							);
						}
					}

					// Check wheter an external function must be called
					if (isset($tca['itemsProcFunc'])) {
						$table = $tca['itemsProcFunc.']['table'];
						$field = $tca['itemsProcFunc.']['field'];
						if ($table != '' && $field != '') {
							$records = call_user_func_array(explode('->', $tca['itemsProcFunc']), array($table, $field));
						}
						// Merges array
						$options = array_merge($options, $records);
						$options = $this->arrayUnique($options);
					}

					// Obtain a list of columns. For sorting purpose
					foreach ($options as $key => $row) {
						$values[$key] = $row[0];
					}

					// Sort the data with values options
					array_multisort($values, SORT_ASC, $options);

					// Initialize a store object
					$this->store[] = '"' . $field . '": new Ext.data.SimpleStore({id:0, "fields": ["' .  $field . '", "' . $field . '_text' . '"],"data" : ' . json_encode($options) . '})';
					break;
				default;
					t3lib_div::debug($field, '$field');
					t3lib_div::debug($tca, '$tca');
					die('Invalid field configuration');
			} //end switch
		} // end if

		return $configuration;
	}

	/**
	 * Eliminates doublon
	 *
	 * @param array $myArray
	 * @return array
	 */
	protected function arrayUnique($myArray) {

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
	 * Returns an array containing the fields configuration
	 *
	 * @return	array
	 */
	protected function getFieldsEdition() {
		t3lib_div::loadTCA('tx_addresses_domain_model_address');
		global $TCA, $LANG, $TYPO3_CONF_VARS;
		$items = explode(',', $TCA['tx_addresses_domain_model_address']['types']['module']['showitem']);
		$items = array_map('trim', $items);
		$index = -1;
		$configurations = array();
		$items = array_filter($items);
		foreach ($items as $item) {

		// Means this is normal field
			if (strpos($item, '--div--') === FALSE ) {

				if (strpos($item, '|') === FALSE ) {
					$configuration = $this->getConfiguration($TCA['tx_addresses_domain_model_address']['columns'], $item);
				}
				else {
					$fields = explode('|', $item);
					$fields = array_map('trim', $fields);

					$_configurations = $configuration = $columnWidth = array();
					$i = $j = 0;

					// Loops on the fields
					foreach ($fields as $field) {
						$_properties = explode(':', $field);
						$field = $_properties[0];

						$_array = $this->getConfiguration($TCA['tx_addresses_domain_model_address']['columns'], $field);
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
				}

				// Add configuration whenever it is not empty
				if (!empty($configuration)) {
					$configurations[$index]['items'][] = $configuration;
				}
			}
			else {
				$index++;
				$_temp = explode(';', $item);
				$configurations[$index]['title'] = $LANG->sL($_temp[1]);
				$configurations[$index]['layout'] = 'form';
				// Adds here default configuration
				$configurations[$index]['defaults'] = array(
					'anchor' => '95%',
					'blankText' => $LANG->getLL('fieldMandatory'),
					'labelSeparator' => '',
				);
				$configuration[$index]['maxLengthText'] = $LANG->getLL('maxLengthText');

				// Add uid of the record as hidden field
				if ($index === 0) {
					$configuration = array();
					$configuration['xtype'] = 'textfield';
					$configuration['id'] = 'uid';
					$configuration['name'] = 'uid';
					$configuration['hidden'] = TRUE;
					$configuration['hideLabel'] = TRUE;
					$configurations[$index]['items'][] = $configuration;
				}
			}
		}
		return $this->sanitizeConfigurations($configurations);
	}

	/**
	 * Check whether the fields is going to be displayed or not.
	 *
	 * @global Object $BE_USER
	 * @param array $tca
	 * @param string $field
	 * @return boolean
	 */
	function checkPermission(&$columns, $field) {
		global $BE_USER;
		$hasPermission = FALSE;
		if ($BE_USER->isAdmin() ||
			(isset($columns[$field]['exclude']) && !$columns[$field]['exclude']) ||
			$BE_USER->check('non_exclude_fields','tx_addresses_domain_model_address:' . $field)) {
			$hasPermission = TRUE;
		}
		return $hasPermission;
	}

	/**
	 * Removes tabs that contain no fields
	 *
	 * @param array $configurations
	 * @return array
	 */
	function sanitizeConfigurations(Array $configurations) {
		$_configurations = Array();
		foreach ($configurations as &$configuration) {
			if (isset($configuration['items'])) {
				$_configurations[] = $configuration;
			}
		}
		return $_configurations;
	}

	/**
	 * Gets the configuration for the Ext JS interface. The return array is going to be converted into JSON.
	 *
	 * @return	array
	 */
	protected function getFieldsColumns() {
		t3lib_div::loadTCA('tx_addresses_domain_model_address');
		global $TCA, $LANG;
		$configurations = $TCA['tx_addresses_domain_model_address']['interface']['showRecordFieldGrid'];
		foreach ($configurations as &$configuration) {
			$configuration['header'] = $LANG->sL($configuration['header']);
		}
		return $configurations;
	}

	/**
	 * Extracts the JavaScript configuration fields name.
	 *
	 * @param array $fields: a configuration array
	 * @return array
	 */
	protected function getFieldsName($fields) {
		$configuration = array();
		foreach ($fields as $field) {
			$configuration[] = $field['dataIndex'];
		}
		return $configuration;
	}

	/**
	 * Gets the labels to be used in JavaScript in the Ext JS interface.
	 *
	 * @return	array		The labels to be used in JavaScript
	 */
	protected function getLabels() {
		$coreLabels = array(
			'title'	=> $GLOBALS['LANG']->getLL('title'),
			'newRecord'	=> $GLOBALS['LANG']->getLL('newRecord'),
			'updateRecord'	=> $GLOBALS['LANG']->getLL('updateRecord'),
			'multipleUpdateRecord'	=> $GLOBALS['LANG']->getLL('multipleUpdateRecord'),
			'table'	=> $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.xml:labels.table'),
		);
		$extensionLabels = $this->getLabelsFromLocallang('js.', 'label_');
		return array_merge($coreLabels, $extensionLabels);
	}

	/**
	 * Gets labels to be used in JavaScript fetched from the current locallang file.
	 *
	 * @param	string		$selectionPrefix: Prefix to select the correct labels (default: 'js.')
	 * @param	string		$stripFromSelectionName: Sub-prefix to be removed from label names in the result (default: '')
	 * @return	array		Lables to be used in JavaScript of the current locallang file
	 */
	protected function getLabelsFromLocallang($selectionPrefix = 'js.', $stripFromSelectionName = '') {
		$extraction = array();
		//		$labels = array_merge(
		//			(array)$GLOBALS['LOCAL_LANG']['default'],
		//			(array)$GLOBALS['LOCAL_LANG'][$GLOBALS['LANG']->lang]
		//		);
		//
		// Regular expression to extract the necessary labels from the javascrip file
		foreach	($this->javascriptFiles as $file) {
			$content = file_get_contents($this->absolutePath . 'Module/Resources/Public/Javascript/' . $file . '.js');
			preg_match_all('/' . $this->namespace .'\.lang\.([\w]+)/is', $content, $matches, PREG_SET_ORDER);
			foreach ($matches as  $match) {
				$key = $match[1];
				$extraction[$key] = $GLOBALS['LANG']->getLL($key);
			}
		}

		return $extraction;
	}

	/**
	 * Gets the buttons that shall be rendered in the docHeader.
	 *
	 * @return	array		Available buttons for the docHeader
	 */
	protected function getDocHeaderButtons() {
		$buttons = array(
			'csh'		=> t3lib_BEfunc::cshItem('_MOD_web_func', '', $this->doc->backPath),
			'shortcut'	=> $this->getShortcutButton(),
			'save'		=> ''
		);

		// SAVE button
		$buttons['save'] = ''; //<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($this->doc->backPath, 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';

		return $buttons;
	}

	/**
	 * Gets the button to set a new shortcut in the backend (if current user is allowed to).
	 *
	 * @return	string		HTML representiation of the shortcut button
	 */
	protected function getShortcutButton() {
		$result = '';
		if ($GLOBALS['BE_USER']->mayMakeShortcut()) {
			$result = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
		}
		return $result;
	}

	/**
	 * Gets the filled markers that are used in the HTML template.
	 *
	 * @return	array		The filled marker array
	 */
	protected function getTemplateMarkers() {
		$markers = array(
			'FUNC_MENU'	=> $this->getFunctionMenu(),
			'CONTENT'	=> $this->content,
			'TITLE'		=> $GLOBALS['LANG']->getLL('title'),
		);
		return $markers;
	}

	/**
	 * Gets the function menu selector for this backend module.
	 *
	 * @return	string		The HTML representation of the function menu selector
	 */
	protected function getFunctionMenu() {
		return t3lib_BEfunc::getFuncMenu(
		0,
		'SET[function]',
		$this->MOD_SETTINGS['function'],
		$this->MOD_MENU['function']
		);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/index.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/index.php']);
}



// Make instance:
$SOBE = t3lib_div::makeInstance('tx_addresses_module');
//$SOBE->initialize();

// Include files?
foreach($SOBE->include_once as $INC_FILE) {
	include_once($INC_FILE);
}

$SOBE->render();
$SOBE->flush();
?>