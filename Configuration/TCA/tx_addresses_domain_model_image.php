<?php
$TCA['tx_addresses_domain_model_image'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_image']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_image']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.upuser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.label',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		'file_name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.image',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '1000',
				'uploadfolder' => 'uploads/tx_addresses',
				'show_thumbs' => '1',
				'size' => '1',
				'maxitems' => '6',
				'minitems' => '0'
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.tags',
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
					'local_table' => 'tx_addresses_domain_model_image',
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
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_image.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '1',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'file_name,remarks,tags')
	),
	'palettes' => array(

	)
);

?>