<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,// The extension name (in UpperCamelCase) or the extension key (in lower_underscore)
	'Pi1',				// A unique name of the plugin in UpperCamelCase
	'Addresses Ultimate Edition'	// A title shown in the backend dropdown field
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Addresses');

$TCA['tx_addresses_domain_model_address'] = Array (
	'ctrl' => Array (
		'label' => 'last_name',
		'label_alt' => 'first_name',
		'label_alt_force' => 1,
		'default_sortby' => 'ORDER BY last_name',
		'tstamp' => 'tstamp',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
		'delete' => 'deleted',
		'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:address',
		'enablecolumns' => Array (
			'disabled' => 'hidden'
		),
		'thumbnail' => 'image',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Private/Icons/icon_tx_addresses_domain_model_address.gif'
		),
		'feInterface' => Array (
		'fe_admin_fieldList' => 'pid,hidden,first_name,last_name,title,address,phone,fax,mobile,website,email,locality,postal_code,company,country,remarks'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_address');
t3lib_extMgm::addToInsertRecords('tx_addresses_domain_model_address');

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_group');
$TCA['tx_addresses_domain_model_group'] = array (
	'ctrl' => array (
	'title'             => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:group',
	'label'				=> 'title',
	'tstamp'            => 'tstamp',
	'crdate'            => 'crdate',
	'delete'            => 'deleted',
	'enablecolumns'     => array (
		'disabled' => 'hidden'
	),
	'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
	'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Private/Icons/icon_tx_addresses_domain_model_address.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_number');
$TCA['tx_addresses_domain_model_number'] = array (
	'ctrl' => array (
	'title'             => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:number',
	'label'				=> 'title',
	'tstamp'            => 'tstamp',
	'crdate'            => 'crdate',
	'delete'            => 'deleted',
	'enablecolumns'     => array (
		'disabled' => 'hidden'
	),
	'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
	'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Private/Icons/icon_tx_addresses_domain_model_address.gif'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_location');
$TCA['tx_addresses_domain_model_location'] = array (
	'ctrl' => array (
	'title'             => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:location',
	'label'				=> 'title',
	'tstamp'            => 'tstamp',
	'crdate'            => 'crdate',
	'delete'            => 'deleted',
	'enablecolumns'     => array (
		'disabled' => 'hidden'
	),
	'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tca.php',
	'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Private/Icons/icon_tx_addresses_domain_model_address.gif'
	)
);

// This lines will changed the TCA for the BE module
if (strpos(t3lib_div::getIndpEnv('SCRIPT_NAME'), 'addresses/Module/index.php') !== FALSE
	|| strpos(t3lib_div::getIndpEnv('SCRIPT_NAME'), 'typo3/ajax.php') !== FALSE) {
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleContact.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleGroup.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleNumber.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleLocation.php');
}

$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
// Registers BE module
if (TYPO3_MODE=='BE' && $configurations['loadBEModule']) {
	#t3lib_extMgm::addModule('user', 'txaddresses', 'bottom', t3lib_extMgm::extPath($_EXTKEY).'Module/');

	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'user',			// Make Blank module a submodule of 'user'
		'manager',	// Submodule key
		'bottom',		// Position
		array(
			'BackendContact' => 'index',
			'BackendGroup' => 'index',
			'BackendNumber' => 'index',
			'BackendLocation' => 'index',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:addresses/Resources/Public/Icons/book_open.png',
			'labels' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_module.xml',
		)
	);
}

?>