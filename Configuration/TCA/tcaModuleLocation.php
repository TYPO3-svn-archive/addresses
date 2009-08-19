<?php

// This section describes the columns of the grid.
$domainName = 'tx_addresses_domain_model_location';
t3lib_div::loadTCA($domainName);

$TCA[$domainName]['types']['module']['showitem'] = array(
	// Describes the left panel.
	array(
		'columnWidth' => 0.6,
		'xtype' => 'tabpanel',
		// Describes the tab of the left panel
		'panels' => array(
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:addresses',
				'fields' => array(
					'street',
					array(
						array('fieldName' => 'postal_code', 'columnWidth' => 0.25),
						array('fieldName' => 'locality', 'columnWidth' => 0.75),
					),
					'country', 'nature', 'uid_foreign',
				),
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

// editable combobox widget
$TCA[$domainName]['columns']['type']['config']['default'] = Array('LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:select_value', '0');
$TCA[$domainName]['columns']['nature'] = array(
    'exclude' => 1,
    'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.nature',
    'config' => Array (
        'type' => 'select',
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getItemsForComboBox',
        'itemsProcFunc.' => array (
            'table' => $domainName,
            'field' => 'nature',
        ),
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
		'editable' => TRUE,
    )
);

// editable combobox widget
$TCA[$domainName]['columns']['country'] = array(
    'exclude' => 1,
    'label' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:tx_addresses_domain_model_address.country',
    'config' => Array (
        'type' => 'select',
        'items' => Array (
            Array('Suisse','Suisse'),
        ),
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getItemsForComboBox',
        'itemsProcFunc.' => array (
            'table' => $domainName,
            'field' => 'country',
        ),
        'size' => 1,
        'minitems' => 0,
        'maxitems' => 1,
		'editable' => TRUE,
    )
);

?>