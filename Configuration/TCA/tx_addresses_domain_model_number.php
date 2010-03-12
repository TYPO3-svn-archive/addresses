<?php
$TCA['tx_addresses_domain_model_number'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_number']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_number']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.upuser_id',
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
		'label' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.label',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		// ExtJS note: *not* editable combobox widget
		'type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.type',
			'config'  => array(
				'type' => 'select',
				'items'   => array(
					Array('', ''),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:work', 'work'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:home', 'home'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:mobile', 'mobile'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:main', 'main'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:fax', 'fax'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:other', 'other'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)
		),
		// ExtJS note: editable combobox widget
		'nature' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.nature',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'number' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.number',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required,nbsp',
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.tags',
			'config' => array(
				'type' => 'select',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'foreign_table' => 'tx_addresses_domain_model_tag',
				'foreign_class' => 'Tx_Addresses_Domain_Model_Tag',
				'MM' => 'tx_addresses_domain_model_component_tag_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_tag',
					'local_table' => 'tx_addresses_domain_model_number',
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
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_number.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '1',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'type,number,remarks,tags')
	),
	'palettes' => array(

	)
);

?>