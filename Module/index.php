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

$classes = array('ConfigurationAbstract', 'AddressConfiguration', 'AddressgroupConfiguration', 'ContactnumberConfiguration', 'LocationConfiguration','Preferences', 'Permission', 'TCA', 'TCE', 'UserTCE');
foreach ($classes as $class) {
	require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/' . $class . '.php'));
}

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
class tx_addresses_module extends t3lib_SCbase {

/**
 * @var template
 */
	public $doc;

	/**
	 * @var $namespace string
	 */
	protected $namespace = 'Addresses';

	/**
	 * @var $namespace string
	 */
	protected $namespaces = array('Address', 'Addressgroup', 'Contactnumber', 'Location');

	/**
	 * @var $namespace string
	 */
	protected $foreignFields = array('addressgroups', 'contactnumbers', 'locations');

	/**
	 * @var $javascriptFiles array
	 */
	protected $javascriptFiles = array('Ext.util', 'Message', 'MultiSelect', 'ItemSelector', 'ProgressBarPager', 'StatusBar', 'Addressgroup', 'ContactNumber', 'Location', 'ext_expander', 'search_field', 'Namespaces', 'AddressInit', 'AddressGrid', 'AddressWindow');

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
	protected $pagingSize = 50;

	/**
	 * @var $minifyJavascript string
	 */
	protected $minifyJavascript = FALSE;

	/**
	 * @var $version string
	 */
	protected $version = '1.0.0';

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
		$GLOBALS['TBE_STYLES']['extJS']['theme'] = 'sysext/t3skin/extjs/xtheme-t3skin.css';
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
		$this->doc->loadExtJS(true);

		// Load special CSS Stylesheets:
		$this->loadStylesheet($this->resourcesPath . 'Stylesheets/customExtJs.css');
		$this->loadStylesheet($this->resourcesPath . 'Stylesheets/StatusBar.css');

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

		// Gets namespaces common code. Important loop!
		foreach ($this->namespaces as $namespace) {

			$gridFields = $gridFieldsType = array();
			if ($namespace == 'Address') {
				$gridFields = call_user_func('Tx_Addresses_Utility_' . $namespace . 'Configuration::getGridConfiguration');
				$gridFieldsType = call_user_func('Tx_Addresses_Utility_' . $namespace . 'Configuration::getFieldsTypeInGrid');
			}

			// Integrate dynamic JavaScript such as configurations or labels:
			$stores = call_user_func('Tx_Addresses_Utility_' . $namespace . 'Configuration::getStores');
			$windowFields = call_user_func('Tx_Addresses_Utility_' . $namespace . 'Configuration::getWindowConfiguration');
			$layout = array('windowHeight' => Tx_Addresses_Utility_TCE::getWindowHeight($windowFields));

			$this->doc->extJScode .= '
				' . $namespace . '.stores = {' . implode(',', $stores) . '};
				' . $namespace . '.gridFields = ' . Tx_Addresses_Utility_TCE::removesQuotes($namespace, json_encode($gridFields)) . ';
				' . $namespace . '.gridFieldsType = ' . json_encode($gridFieldsType) . ';
				' . $namespace . '.windowFields = ' . Tx_Addresses_Utility_TCE::removesQuotes($namespace, json_encode($windowFields)) . ';
				' . $namespace . '.layout = ' . json_encode($layout) . ';' . chr(10);
		}

		$this->doc->extJScode .= '
			' . $this->namespace . '.statics = ' . json_encode($this->getStaticConfiguration()) . ';
			' . $this->namespace . '.lang = ' . json_encode($this->getLabels()) . ';
			' . $this->namespace . '.initialize();' . chr(10);
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
	protected function getStaticConfiguration() {
		$configuration = array(
			'pagingSize' => $this->pagingSize,
			'renderTo' => 'addressesContent',
			'path' => t3lib_extMgm::extRelPath('addresses'),
			'isSSL' => t3lib_div::getIndpEnv('TYPO3_SSL'),
			'ajaxController' => $this->doc->backPath . 'ajax.php',
			'foreignFields' => $this->foreignFields,
		);
		return $configuration;
	}

	/**
	 * Gets the labels to be used in JavaScript in the Ext JS interface.
	 *
	 * @return	array		The labels to be used in JavaScript
	 */
	protected function getLabels() {
		global $LANG;
		$coreLabels = array(
			'title'	=> $LANG->getLL('title'),
			'newRecord'	=> $LANG->getLL('newRecord'),
			'updateRecord'	=> $LANG->getLL('updateRecord'),
			'multipleUpdateRecord'	=> $LANG->getLL('multipleUpdateRecord'),
			'table'	=> $LANG->sL('LLL:EXT:lang/locallang_core.xml:labels.table'),
			'addNewElement'	=> $LANG->getLL('addNewElement'),
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