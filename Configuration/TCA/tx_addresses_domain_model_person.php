<?php
$TCA['tx_addresses_domain_model_person'] = Array (
	'ctrl' => $TCA['tx_addresses_domain_model_person']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'gender,first_name,last_name,birth_date,marital_status,address,locality,postal_code,country,preferred_language,numbers,emails,website,title,company,room,building,image,tags,region'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_person']['feInterface'],
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.cruser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.upuser_id',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.hidden',
			'config' => Array (
				'type' => 'check'
			)
		),
		'status' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.status',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'type' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.type',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		// *not* editable combobox widget
		'gender' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender',
			'config' => array (
				'type' => 'select',
				'items'   => array(
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender.m', 'm'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender.f', 'f')
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)

		),
		'first_name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.first_name',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'last_name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.last_name',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'title' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.title',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'birth_date' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.birth_date',
			'config'  => array (
				'type' => 'input',
				'eval' => 'date',
				'size' => '8',
				'max'  => '20'
			)
		),
		'birth_place' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.birth_place',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'death_date' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.death_date',
			'config'  => array (
				'type' => 'input',
				'eval' => 'date',
				'size' => '8',
				'max'  => '20'
			)
		),
		'death_place' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.death_place',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'nationality' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.nationality',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'religion' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.religion',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'org_type' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.org_type',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'org_name' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.org_name',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'website' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.website',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '80',
				'validation' => 'http://',
			)
		),
		'company' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.company',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '80'
			)
		),
		'image' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.image',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.remarks',
			'config' => Array (
				'type' => 'text',
				'rows' => 5,
				'cols' => 48,
				'height' => 150
			)
		),
		// itemselector widget
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.group',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 1,
				'foreign_class' => 'Tx_Addresses_Domain_Model_Tag',
				'foreign_table' => 'tx_addresses_domain_model_tag',
				'MM' => 'tx_addresses_domain_model_contact_tag_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_tag'
				),
			)
		),
		'numbers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.number',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_addresses_domain_model_number',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'emails' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.email',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_email',
				'foreign_field' => 'contact',
				'foreign_label' => 'email_address',
			)
		),
		'locations' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.locations',
			'config' => array(
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30',
			)
		),
		// *not* editable combobox widget
		'marital_status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.marital_status',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:single', '1'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:married', '2'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:divorced', '3'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:widowed', '4'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)
		),
		'preferred_language' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.preferred_language',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30'
			)
		),
	),
	'types' => Array (
		'1' => Array('showitem' => 'hidden, gender, first_name, last_name,company, address, postal_code, locality, numbers, emails, image, remarks, tags')
	),
	'palettes' => Array (
		'2' => Array('showitem' => 'title, birth_date, marital_status'),
		'3' => Array('showitem' => 'region, preferred_language'),
		'5' => Array('showitem' => 'website'),
	)
);

?>