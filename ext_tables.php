<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

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
		'label' => 'lastname',
		'label_alt' => 'firstname',
		'label_alt_force' => 1,
		'default_sortby' => 'ORDER BY lastname',
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
		'fe_admin_fieldList' => 'pid,hidden,firstname,lastname,title,address,phone,fax,mobile,www,email,city,zip,company,country,description'
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
?>