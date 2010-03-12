<?php
$TCA['tx_addresses_domain_model_organization'] = Array (
	'ctrl' => $TCA['tx_addresses_domain_model_organization']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'gender,first_name,last_name,birth_date,marital_status,country,preferred_language,numbers,emails,website,title,company,room,building,image,tags,region'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_organization']['feInterface'],
	'columns' => Array (
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'pid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.upuser_id',
			'config' => Array (
				'type' => 'passthrough',
				'userFuncFormat' => 'Tx_Addresses_Utility_TCE::convertUidToValue',
				'userFuncFormat.' => array (
					'table' => 'be_users',
					'field' => 'username',
				),
			),
		),
		'hidden' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.hidden',
			'config' => Array (
				'type' => 'check'
			)
		),
		'name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.name',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'logo' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.logo',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '1000',
				'uploadfolder' => 'uploads/pics',
				'show_thumbs' => '1',
				'size' => '3',
				'maxitems' => '6',
				'minitems' => '0'
			)
		),
		'remarks' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.remarks',
			'config' => Array (
				'type' => 'text',
				'rows' => 5,
				'cols' => 48,
				'height' => 150
			)
		),
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.tags',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'foreign_table' => 'tx_addresses_domain_model_tag',
				'foreign_class' => 'Tx_Addresses_Domain_Model_Tag',
				'MM' => 'tx_addresses_domain_model_component_tag_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_tag',
					'local_table' => 'tx_addresses_domain_model_organization',
				),
				'allowed' => 'tx_addresses_domain_model_tag',
				'wizards' => array(
					'suggest' => array(
					'type' => 'suggest',
					),
				),

			)
		),
		'numbers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.numbers',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_number',
				'foreign_field' => 'organization',
				'foreign_label' => 'label',
			)
		),
		'emails' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.emails',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_email',
				'foreign_field' => 'organization',
				'foreign_label' => 'label',
			)
		),
		'websites' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.websites',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_website',
				'foreign_field' => 'organization',
				'foreign_label' => 'label',
			)
		),
		'addresses' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.addresses',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_address',
				'foreign_field' => 'organization',
				'foreign_label' => 'label',
			)
		),
		'sectors' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_organization.sectors',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_sector',
				'foreign_field' => 'organization',
				'foreign_label' => 'label',
			)
		),
	),
	'types' => Array (
		'1' => Array('showitem' => 'hidden, name, logo, sectors, remarks ,
									--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tabs.contactInfo, numbers, emails, websites,
									--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tabs.addresses, addresses,
									--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tabs.tags, tags,
									'),
	),
	'palettes' => Array (
		'2' => Array('showitem' => 'title, birth_date, marital_status'),
		'3' => Array('showitem' => 'region, preferred_language'),
		'5' => Array('showitem' => 'website'),
	)
);

?>