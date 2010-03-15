<?php
$TCA['tx_addresses_domain_model_sector'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_sector']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_sector']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.upuser_id',
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
		'label' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.label',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		'name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.name',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.tags',
			'config' => array(
				'type' => 'select',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'foreign_table' => 'tx_addresses_domain_model_tag',
				'foreign_class' => 'Tx_Addresses_Domain_Model_Tag',
				'MM' => 'tx_addresses_domain_model_entity_tag_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_tag',
					'local_table' => 'tx_addresses_domain_model_sector',
				),
				'allowed' => 'tx_addresses_domain_model_tag',
				'wizards' => array(
					'suggest' => array(
					'type' => 'suggest',
					),
				),

			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_sector.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '1',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'name,remarks,tags')
	),
	'palettes' => array(

	)
);

?>