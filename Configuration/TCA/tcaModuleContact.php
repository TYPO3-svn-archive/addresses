<?php
// Beware: this file is loaded only for the BE module.

$domainName = 'tx_addresses_domain_model_address';
t3lib_div::loadTCA($domainName);

// Describes the column of the grid
$TCA[$domainName]['interface']['showGridFieldList'] = array(
    'uid' => array(
        'id' => TRUE,
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.uid',
        'config' => Array (
            'type' => 'input',
            'width' => 40,
            'sortable' => TRUE,
            'hidden' => TRUE,
        )
    ),
    'pid' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.pid',
        'config' => Array (
            'type' => 'input',
            'width' => 40,
            'sortable' => TRUE,
            'eval' => 'int',
            'hidden' => TRUE,
        )
    ),
    'title' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title',
        'config' => Array (
            'type' => 'input',
            'width' => 60,
            'sortable' => TRUE,
        )
    ),
    'first_name' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.first_name',
        'config' => Array (
            'type' => 'input',
            'width' => 120,
            'sortable' => TRUE,
        )
    ),
    'last_name' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.last_name',
        'config' => Array (
            'type' => 'input',
            'width' => 120,
            'sortable' => TRUE,
        )
    ),
    'tstamp' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.tstamp',
        'config' => Array (
            'type' => 'input',
            'width' => 100,
            'sortable' => TRUE,
            'eval' => 'date',
        )
    ),
    'cruser_id' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.cruser_id',
        'config' => Array (
            'type' => 'input',
            'width' => 100,
            'sortable' => TRUE,
            'hidden' => TRUE,
        )
    ),
    'upuser_id' => array(
        'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.upuser_id',
        'config' => Array (
            'type' => 'input',
            'width' => 100,
            'sortable' => TRUE,
            'hidden' => TRUE,
        )
    ),
);

// Path to the template for the expander
$TCA[$domainName]['types']['module']['expanderTemplate'] = 'EXT:addresses/Module/Resources/Private/Templates/expander.html';

// Describes the fields of the editing window
$TCA[$domainName]['types']['module']['showitem'] = array(
	// Describes the left panel.
	array(
		'columnWidth' => 0.6,
		'xtype' => 'tabpanel',
		'activeTab' => 0,
		// Describes the tab of the left panel
		'panels' => array (
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:person',
				'fields' => array('gender', 'title', 'first_name', 'last_name', 'preferred_language', 'birth_date', 'marital_status', 'nationality', 'website'),
			),
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:addresses',
				// 2 fields on the same line
				'fields' => array('locations'),
			),
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:numbers',
				'fields' => array('numbers'),
			),
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:groups',
				'fields' => array('groups'),
			),
		),
	),
	// Describes the right panel.
	array(
		'columnWidth' => 0.4,
		'xtype' => 'panel',
		'panels' => array(
			array(
				'title' => '',
				'fields' => array('remarks'),
			),
		),
	),
);

// Overrides default TCA configuration according to ExtJS needs
$TCA[$domainName]['columns']['groups']['config']['label'] = '';
$TCA[$domainName]['columns']['gender']['config']['default'] = Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:select_value', '0');
$TCA[$domainName]['columns']['marital_status']['config']['default'] = Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:select_value', '0');
$TCA[$domainName]['columns']['numbers']['config'] = Array(
	'type' => 'user',
	'userFunc' => 'Tx_Addresses_Utility_UserTCE::getNumbersField',
	'foreign_table' => 'tx_addresses_domain_model_number',
);

$TCA[$domainName]['columns']['locations']['config'] = Array(
	'type' => 'user',
	'userFunc' => 'Tx_Addresses_Utility_UserTCE::getLocationField',
	'foreign_table' => 'tx_addresses_domain_model_location',
);

// editable combobox widget
$TCA[$domainName]['columns']['title'] = array(
    'exclude' => 1,
    'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title',
    'config' => Array (
        'type' => 'select',
        'items' => Array (
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.1', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.1'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.2', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.2'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.3', 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.title.I.3'),
        ),
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getItemsForComboBox',
        'itemsProcFunc.' => array (
            'table' => $domainName,
            'field' => 'title',
        ),
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
    )
);

// editable combobox widget
$TCA[$domainName]['columns']['preferred_language'] = array(
    'exclude' => 1,
    'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.preferred_language',
    'config' => Array (
        'type' => 'select',
        'items' => Array (
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:english','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:english'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:french','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:french'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:german','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:german'),
        ),
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getItemsForComboBox',
        'itemsProcFunc.' => array (
            'table' => $domainName,
            'field' => 'preferred_language',
        ),
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
		'editable' => TRUE,
    )
);

// editable combobox widget
$TCA[$domainName]['columns']['nationality'] = array(
    'exclude' => 1,
    'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.nationality',
    'config' => Array (
        'type' => 'select',
        'items' => Array (
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:switzerland','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:switzerland'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:germany','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:germany'),
            Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:france','LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:france'),
        ),
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getItemsForComboBox',
        'itemsProcFunc.' => array (
            'table' => $domainName,
            'field' => 'nationality',
        ),
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
		'editable' => TRUE,
    )
);
?>