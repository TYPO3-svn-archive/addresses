<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	// Load class for userFunc fields in TCE Forms
	require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_addresses_tce.php');
}

Tx_Extbase_Utility_Plugin::registerPlugin(
	'Addresses',																	// The name of the extension in UpperCamelCase
	'Pi1',																			// A unique name of the plugin in UpperCamelCase
	'Address Management',															// A title shown in the backend dropdown field
	array(																			// An array holding the controller-action-combinations that are accessible
		'Address' => 'index,show,vcard,vcards',										// The first controller and its first action will be the default
	),
	array(
		'Address' => 'index,show,vcard,vcards',										// An array of non-cachable controller-action-combinations (they must already be enabled)
	)
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

// This lines will changed the TCA for the BE module
if (strpos(t3lib_div::getIndpEnv('SCRIPT_NAME'), 'addresses/Module/index.php') !== FALSE
	|| strpos(t3lib_div::getIndpEnv('SCRIPT_NAME'), 'typo3/ajax.php') !== FALSE) {


// This section describes the columns of the grid.
	t3lib_div::loadTCA('tx_addresses_domain_model_address');
	$TCA['tx_addresses_domain_model_address']['interface']['showRecordFieldGrid'] = array(
		array(
			'id' => 'uid',
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.uid',
			'width' => 40,
			'sortable' => TRUE,
			'dataIndex' => 'uid',
		),
		array(
			'id' => 'pid',
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.pid',
			'width' => 40,
			'sortable' => TRUE,
			'dataIndex' => 'pid',
		),
		array(
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.first_name',
			'width' => 120,
			'sortable' => TRUE,
			'dataIndex' => 'first_name',
		),
		array(
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.last_name',
			'width' => 120,
			'sortable' => TRUE,
			'dataIndex' => 'last_name',
		),
		array(
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.address',
			'width' => 120,
			'sortable' => TRUE,
			'dataIndex' => 'address',
		),
		array(
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.postal_code',
			'width' => 120,
			'sortable' => TRUE,
			'dataIndex' => 'postal_code',
		),
		array(
			'header' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.locality',
			'width' => 120,
			'sortable' => TRUE,
			'dataIndex' => 'locality',
		),
	);

	// This section modifies some field configuration for the ExtJS purpose
	$TCA['tx_addresses_domain_model_address']['columns']['gender'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.1', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.1'),
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.2', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.2'),
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.3', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.I.3'),
			),
			'itemsProcFunc' => 'tx_addresses_tce->getRecords',
			'itemsProcFunc.' => array (
				'table' => 'tx_addresses_domain_model_address',
				'field' => 'gender',
			),
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	);

	$TCA['tx_addresses_domain_model_address']['columns']['country'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:lang/locallang_general.php:LGL.country',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('Suisse','Suisse'),
			),
			'itemsProcFunc' => 'tx_addresses_tce->getRecords',
			'itemsProcFunc.' => array (
				'table' => 'tx_addresses_domain_model_address',
				'field' => 'country',
			),
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	);
	
	$TCA['tx_addresses_domain_model_address']['columns']['preferred_language'] = array(
		'exclude' => 1,
		'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.preferred_language',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:english','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:english'),
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:french','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:french'),
				Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:german','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:german'),
			),
			'itemsProcFunc' => 'tx_addresses_tce->getRecords',
			'itemsProcFunc.' => array (
				'table' => 'tx_addresses_domain_model_address',
				'field' => 'preferred_language',
			),
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	);

	$TCA['tx_addresses_domain_model_address']['types']['module']['showitem'] =
		'--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.type.I.0,' .
		'first_name, last_name, gender,birth_date, country, marital_status, preferred_language, postal_code:0.25 | locality:0.75,';
}

$configurations = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['addresses']);
// Registers BE module
if (TYPO3_MODE=='BE' && $configurations['loadBEModule']) {
	t3lib_extMgm::addModule('user', 'txaddresses', 'bottom', t3lib_extMgm::extPath($_EXTKEY).'Module/');
}
?>