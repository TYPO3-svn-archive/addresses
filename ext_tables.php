<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	// Load class for userFunc fields in TCE Forms
	require_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_addresses_tce.php');
}

/**
 * A fully configured omnipotent plugin
 */
Tx_Extbase_Utility_Plugin::registerPlugin(
	'Addresses',																	// The name of the extension in UpperCamelCase
	'Pi1',																			// A unique name of the plugin in UpperCamelCase
	'Address Management',															// A title shown in the backend dropdown field
	array(																			// An array holding the controller-action-combinations that are accessible
	'Address' => 'index,show',													// The first controller and its first action will be the default
	),
	array(
	'Address' => 'index,show',																				// An array of non-cachable controller-action-combinations (they must already be enabled)
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
	'fe_admin_fieldList' => 'pid,hidden,first_name,last_name,title,address,phone,fax,mobile,www,email,city,zip,company,country,description'
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_addresses_domain_model_address');
t3lib_extMgm::addToInsertRecords('tx_addresses_domain_model_address');
//t3lib_extMgm::addLLrefForTCAdescr('tx_addresses_domain_model_address','EXT:tt_address/locallang_csh_ttaddr.php');

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
		'header' => 'LLL:EXT:lang/locallang_general.php:LGL.city',
		'width' => 120,
		'sortable' => TRUE,
		'dataIndex' => 'city',
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

	$TCA['tx_addresses_domain_model_address']['types']['module']['showitem'] =
		'--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.type.I.0,' .
		'first_name, last_name, gender,birthday, country, marital_status, zip:0.25 / city:0.75,';
}

// Registers BE module
if (TYPO3_MODE=='BE') {
	t3lib_extMgm::addModule('user', 'txaddresses', 'bottom', t3lib_extMgm::extPath($_EXTKEY).'Module/');
}
?>