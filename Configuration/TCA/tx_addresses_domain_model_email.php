<?php
$TCA['tx_addresses_domain_model_email'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_email']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,email_address,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_number']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.cruser_id',
			'config' => Array (
				'type' => 'passthrough',
				'userFuncFormat' => 'Tx_Addresses_Utility_TCE::convertUidToValue',
				'userFuncFormat.' => array (
					'table' => 'be_users',
					'field' => 'username',
				),
			),
		),
		'upuser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.upuser_id',
			'config' => Array (
				'type' => 'passthrough',
				'userFuncFormat' => 'Tx_Addresses_Utility_TCE::convertUidToValue',
				'userFuncFormat.' => array (
					'table' => 'be_users',
					'field' => 'username',
				),
			),
		),
		'hidden' => array(
			'exclude'   => 1,
			'label'     => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'    => array(
				'type'    => 'check',
				'default' => '1'
			)
		),
		// EXTJS note: *not* editable combobox widget
		'type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.type',
			'config'  => array(
				'type' => 'select',
				'items'   => array(
					Array('', ''),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:work', 'work'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:home', 'home'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:other', 'other'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)
		),
		'email_address' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.email_address',
			'config' => Array (
				'type' => 'input'
			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_email.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '1',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'type,email_address,remarks')
	),
	'palettes' => array(

	)
);
?>