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
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/Configuration.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/Permission.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/TCA.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/TCE.php'));

// Check user permissions
$BE_USER->modAccess($MCONF, 1);	// This checks permissions and exits if the users has no permission for entry.
$LANG->includeLLFile('EXT:addresses/Module/Resources/Private/Language/locallang.xml');
$LANG->includeLLFile('EXT:addresses/Resources/Private/Language/locallang_db.xml');
$LANG->includeLLFile('EXT:addresses/Resources/Private/Language/locallang_tca.xml');

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
	protected $javascriptFiles = array('MultiSelect', 'ItemSelector', 'ext_expander', 'search_field', 't3_addresses_init', 't3_addresses_grid', 't3_addresses_window');

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
		$this->doc->setModuleTemplate(t3lib_extMgm::extPath('addresses') . 'Module/Resources/Private/Templates/index.html');
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

		// Defines a default ExtJS style
		$GLOBALS['TBE_STYLES']['extJS']['theme'] = $this->doc->backPath . 'contrib/extjs/resources/css/xtheme-gray.css';
	}

	/**
	 * Renders the contente of the module.
	 *
	 * @return	void
	 */
	public function render() {
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
		global $LANG;
		$content = $this->doc->startPage($LANG->getLL('title'));
		$content .= $this->doc->moduleBody(
			$this->pageRecord,
			$this->getDocHeaderButtons(),
			$this->getTemplateMarkers()
		);
		$content .= $this->doc->endPage();
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
		$this->doc->enableExtJsDebug(); // use for debug
		$this->doc->loadExtJS(true, xtheme-gray.css);

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
		$fieldsGrid = $this->getGridConfiguration();
		$fieldsStore = $this->getStoreConfiguration();
		$fieldsWindow = $this->getWindowConfiguration();

		$this->store = Tx_Addresses_Utility_TCE::getStores();
		$this->store[] = Tx_Addresses_Utility_TCE::getCustomStore('localities', 'postal_code', 'locality', 'tx_addresses_domain_model_address');
		
		$this->doc->extJScode .= '
			' . $this->namespace . '.store = {' . implode(',', $this->store) . '};
			' . $this->namespace . '.statics = ' . json_encode($this->getStaticConfiguration($fieldsWindow)) . ';
			' . $this->namespace . '.fieldsGrid = ' . Tx_Addresses_Utility_TCE::removesQuotes($this->namespace, json_encode($fieldsGrid)) . ';
			' . $this->namespace . '.fieldsStore = ' . json_encode($fieldsStore) . ';
			' . $this->namespace . '.fieldsWindow = ' . Tx_Addresses_Utility_TCE::removesQuotes($this->namespace, json_encode($fieldsWindow)) . ';
			' . $this->namespace . '.lang = ' . json_encode($this->getLabels()) . ';
			//' . $this->namespace . '.w = new Object();
			//' . $this->namespace . '.formPanel = new Object();
			//' . $this->namespace . '.form = new Object();
			' . $this->namespace . '.data = new Object();
			Addresses.initialize();' . chr(10);
	}

	/**
	 * Count the number of fields that will be displayed on the editing window.
	 * Useful for determining the height of the editing window.
	 *
	 * @param array $fieldsWindow
	 * @return int
	 */
	protected function getNumberOfFields(Array $fieldsWindow) {
		$numberOfItems = 0;
		for ($index = 0; $index < count($fieldsWindow); $index++) {
			$items = $fieldsWindow[$index];
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
	protected function getStaticConfiguration($fieldsWindow) {
		$configuration = array(
			'pagingSize' => $this->pagingSize,
			'renderTo' => 'addressesContent',
			'path' => t3lib_extMgm::extRelPath('addresses'),
			'isSSL' => t3lib_div::getIndpEnv('TYPO3_SSL'),
			'editionHeight' => 50 * $this->getNumberOfFields($fieldsWindow) + 150,
			'ajaxController' => $this->doc->backPath . 'ajax.php',
		);
		return $configuration;
	}

	/**
	 * Return configuration of array
	 *
	 * @param string the field name;
	 * @return array $configuration
	 */
	protected function getConfiguration($fieldName) {
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
						$configuration = Tx_Addresses_Utility_TCE::getItemSelector($columns, $fieldName);
					}
					else {
						$configuration = Tx_Addresses_Utility_TCE::getComboBox($columns, $fieldName);
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

	/**
	 * Returns an array containing the fields configuration
	 *
	 * @global Language $LANG
	 * @return	array
	 */
	protected function getWindowConfiguration() {
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

						$_array = $this->getConfiguration($field);
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
					$configuration = $this->getConfiguration($item);
				}

				// Add configuration whenever it is not empty
				if (!empty($configuration)) {
					$configurations[$index]['items'][] = $configuration;
					if (isset($columns[$item]['config']['foreign_table'])) {
						$configurations[$index]['items'][] = Tx_Addresses_Utility_TCE::getEditForeignTableButton($columns[$item]['config']['foreign_table']);
					}
				}
			}
		}
		return $this->sanitizeConfigurations($configurations);
	}

	/**
	 * Removes tabs that contain no fields from the tabpanel
	 *
	 * @param array $configurations
	 * @return array
	 */
	protected function sanitizeConfigurations(Array $configurations) {
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
	 * @global Language $LANG
	 * @return	array
	 */
	protected function getGridConfiguration() {
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
	protected function getStoreConfiguration() {
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
		// Regular expression to extract the necessary labels from the javascrip file
		foreach	($this->javascriptFiles as $file) {
			$content = file_get_contents($this->absolutePath . 'Module/Resources/Public/Javascript/' . $file . '.js');
			preg_match_all('/' . $this->namespace .'\.lang\.([\w]+)/is', $content, $matches, PREG_SET_ORDER); //[^ \),;\n}]
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



try {
// Make instance:
	$SOBE = t3lib_div::makeInstance('tx_addresses_module');

	// Include files?
	foreach($SOBE->include_once as $INC_FILE) {
		include_once($INC_FILE);
	}

	$SOBE->render();
	$SOBE->flush();
}
catch (Exception $e) {
	print $e->getMessage();
}
?>