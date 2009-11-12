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

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_addressgroup');
$TCA['tx_addresses_domain_model_addressgroup'] = array (
	'ctrl' => array (
	'title'             => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:addressgroup',
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

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_contactnumber');
$TCA['tx_addresses_domain_model_contactnumber'] = array (
	'ctrl' => array (
	'title'             => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:contactnumber',
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
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleAddress.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleAddressgroup.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleContactnumber.php');
    require(t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/tcaModuleLocation.php');
}

$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
// Registers BE module
if (TYPO3_MODE=='BE' && $configurations['loadBEModule']) {
	t3lib_extMgm::addModule('user', 'txaddresses', 'bottom', t3lib_extMgm::extPath($_EXTKEY).'Module/');
}

//if (TYPO3_MODE == 'BE') {
//	Tx_MvcExtjs_Utility_Module::registerModule(
//		$_EXTKEY,
//		array(
//			'BlankModule' => 'first,second,third',
//			'SimpleForm' => 'index,genres'
//		),
//		array(
//			'access' => 'user,group',
//			'icon'   => 'EXT:mvc_extjs_samples/Resources/Public/Icons/movie_add.png',
//			'labels' => 'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_mod_blank.xml',
//		),
//		'user',	// Make Blank module a submodule of 'user'
//		'blank'
//	);
//
//
//	// ========== Legacy (SCbase) function
//
//	t3lib_extMgm::insertModuleFunction(
//		'addresses',	// Insert legacy function into function menu of Module Blank
//		'tx_mvcextjssamples_modfunc1',
//		t3lib_extMgm::extPath($_EXTKEY) . 'modfunc1/class.tx_mvcextjssamples_modfunc1.php',
//		'LLL:EXT:mvc_extjs_samples/Resources/Private/Language/locallang_db.xml:moduleFunction.tx_mvcextjssamples_modfunc1'
//	);
//}
?>