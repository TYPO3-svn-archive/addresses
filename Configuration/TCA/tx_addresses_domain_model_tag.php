<?php

$TCA['tx_addresses_domain_model_tag'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_tag']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,name,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_tag']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_tag.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_tag.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_tag.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_tag.upuser_id',
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
				'default' => '0',
			)
		),
		'name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.name',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_tag.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'name')
	),
	'palettes' => array(

	)
);

?>