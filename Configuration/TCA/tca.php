<?php
$TCA['tx_addresses_domain_model_address'] = Array (
	'ctrl' => $TCA['tx_addresses_domain_model_address']['ctrl'],
	'interface' => Array (
		'showRecordFieldList' => 'gender,first_name,last_name,birth_date,marital_status,address,locality,postal_code,country,preferred_language,phone,fax,email,website,title,company,room,building,image,addressgroups,region'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_address']['feInterface'],
	'columns' => Array (
		'uid' => Array (
			'exclude' => 1,
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'pid' => Array (
			'exclude' => 1,
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.cruser_id',
			'config' => Array (
				'type' => 'passthrough',
			),
		),
		'upuser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.upuser_id',
			'config' => Array (
				'type' => 'passthrough',
			),
		),
		'hidden' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.hidden',
			'config' => Array (
				'type' => 'check'
			)
		),
		'status' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.status',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'type' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.type',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		// *not* editable combobox widget
		'gender' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender',
			'config' => array (
				'type' => 'select',
				'items'   => array(
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.m', 'm'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.gender.f', 'f')
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)

		),
		'first_name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.first_name',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'last_name' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.last_name',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'max' => '256'
			)
		),
		'title' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'birth_date' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.birth_date',
			'config'  => array (
				'type' => 'input',
				'eval' => 'date',
				'size' => '8',
				'max'  => '20'
			)
		),
		'birth_place' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.birth_place',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'death_date' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.death_date',
			'config'  => array (
				'type' => 'input',
				'eval' => 'date',
				'size' => '8',
				'max'  => '20'
			)
		),
		'death_place' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.death_place',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'nationality' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.nationality',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'religion' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.religion',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'org_type' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.org_type',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'org_name' => Array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.org_name',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '40'
			)
		),
		'address' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.address',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		'street' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.street',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		'street_number' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.street_number',
			'config' => Array (
				'type' => 'text',
				'cols' => '20',
				'rows' => '3'
			)
		),
		'phone' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.phone',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '30'
			)
		),
		'fax' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.fax',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30'
			)
		),
		'mobile' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.mobile',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '30'
			)
		),
		'website' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.website',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '80',
				'validation' => 'http://',
			)
		),
		'email' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.email',
			'config' => Array (
				'type' => 'input',
				'size' => '40',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'company' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.company',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max' => '80'
			)
		),
		'building' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.building',
			'config' => array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max'  => '15'
			)
		),
		'room' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.room',
			'config' => array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '20',
				'max'  => '15'
			)
		),
		'locality' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.locality',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '80'
			)
		),
		'postal_code' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.postal_code',
			'config' => Array (
				'type' => 'input',
				'eval' => 'trim',
				'size' => '10',
				'max' => '20'
			)
		),
		'country' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.country',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30'
			)
		),
		'region' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.region',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30'
			)
		),
		'image' => Array (
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.image',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.remarks',
			'config' => Array (
				'type' => 'text',
				'rows' => 5,
				'cols' => 48,
				'height' => 150
			)
		),
		// itemselector widget
		'addressgroups' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.addressgroup',
			'config' => array(
				'type' => 'select',
				'size' => 10,
				'minitems' => 0,
				'maxitems' => 9999,
				'autoSizeMax' => 30,
				'multiple' => 1,
				'foreign_class' => 'Tx_Addresses_Domain_Model_Addressgroup',
				'foreign_table' => 'tx_addresses_domain_model_addressgroup',
				'MM' => 'tx_addresses_address_addressgroup_mm',
				'MM_match_fields' => array(
					'tablenames' => 'tx_addresses_domain_model_addressgroup'
				),
			)
		),
		'contactnumbers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.contactnumber',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.marital_status',
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
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.preferred_language',
			'config' => Array (
				'type' => 'input',
				'size' => '20',
				'eval' => 'trim',
				'max' => '30'
			)
		),
	),
	'types' => Array (
		'1' => Array('showitem' => 'hidden;;;;1-1-1, gender, first_name, last_name;;2;;3-3-3,company;;6, address, postal_code, locality;;3, email;;5, phone;;4, image;;;;4-4-4, remarks;;;;4-4-4, addressgroups')
	),
	'palettes' => Array (
		'2' => Array('showitem' => 'title, birth_date, marital_status'),
		'3' => Array('showitem' => 'country, region, preferred_language'),
		'4' => Array('showitem' => 'mobile, fax'),
		'5' => Array('showitem' => 'website'),
		'6' => Array('showitem' => 'room, building')
	)
);

$TCA['tx_addresses_domain_model_addressgroup'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_addressgroup']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_addressgroup']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.cruser_id',
			'config' => Array (
				'type' => 'passthrough',
			),
		),
		'upuser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.upuser_id',
			'config' => Array (
				'type' => 'passthrough',
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
		'title' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.title',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2, remarks')
	),
	'palettes' => array(

	)
);

$TCA['tx_addresses_domain_model_contactnumber'] = array(
	'ctrl' => $TCA['tx_addresses_domain_model_contactnumber']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,remarks'
	),
	'feInterface' => $TCA['tx_addresses_domain_model_contactnumber']['feInterface'],
	'columns' => array(
		'uid' => Array (
			'config' => Array (
				'type' => 'passthrough'
			)
		),
		'tstamp' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.tstamp',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'crdate' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.crdate',
			'config' => Array (
				'type' => 'passthrough',
				'eval' => 'date'
			),
		),
		'cruser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.cruser_id',
			'config' => Array (
				'type' => 'passthrough',
			),
		),
		'upuser_id' => Array (
			'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.upuser_id',
			'config' => Array (
				'type' => 'passthrough',
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
		// *not* editable combobox widget
		'type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.type',
			'config'  => array(
				'type' => 'select',
				'items'   => array(
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:fixed', 'fixed'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:mobile', 'mobile'),
					Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:fax', 'fax'),
				),
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'editable' => FALSE,
			)
		),
		'number' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.number',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		// editable combobox widget
		'nature' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.nature',
			'config'  => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'remarks' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.remarks',
			'config'  => array(
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'height' => 150
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;;;1-1-1, title;;;;2-2-2, remarks')
	),
	'palettes' => array(

	)
);
?>