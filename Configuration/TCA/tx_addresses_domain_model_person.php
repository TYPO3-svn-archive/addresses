<?php
$TCA['tx_addresses_domain_model_person'] = Array (
	'ctrl' => $TCA['tx_addresses_domain_model_person']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'gender,first_name,last_name,birth_date,marital_status,country,preferred_language,numbers,emails,website,title,company,room,building,image,tags,region'
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
		// ExtJS note: *not* editable combobox widget
		'gender' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender',
			'config' => array (
				'type' => 'select',
				'items'   => array(
					Array('', ''),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender.male', 'male'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.gender.female', 'female')
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
		'tags' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.tags',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'foreign_table' => 'tx_addresses_domain_model_tag',
				'foreign_class' => 'Tx_Addresses_Domain_Model_Tag',
				'MM' => 'tx_addresses_domain_model_entity_tag_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_tag',
					'local_table' => 'tx_addresses_domain_model_person',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.numbers',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_number',
				'foreign_field' => 'contact',
				'foreign_label' => 'label',
			)
		),
		'emails' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.emails',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_email',
				'foreign_field' => 'contact',
				'foreign_label' => 'label',
			)
		),
		'websites' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.websites',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_website',
				'foreign_field' => 'contact',
				'foreign_label' => 'label',
			)
		),
		'addresses' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.addresses',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_addresses_domain_model_address',
				'foreign_field' => 'contact',
				'foreign_label' => 'label',
			)
		),
		// ExtJS note: *not* editable combobox widget
		'marital_status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_person.marital_status',
			'config' => Array (
				'type' => 'select',
				'items' => Array (
					Array('', ''),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:single', 'single'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:married', 'married'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:divorced', 'divorced'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:widowed', 'widowed'),
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
		'1' => Array('showitem' => 'hidden,gender,title, first_name, last_name, birth_date, marital_status, image, remarks ,
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