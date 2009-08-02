<?php

// This section describes the columns of the grid.
$domainName = 'tx_addresses_domain_model_contactnumber';
t3lib_div::loadTCA($domainName);

$TCA[$domainName]['types']['module']['showitem'] = array(
	// Describes the left panel.
	array(
		'columnWidth' => 0.6,
		'xtype' => 'tabpanel',
		// Describes the tab of the left panel
		'panels' => array (
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:contactnumber',
				'fields' => array('uid_foreign', 'type', 'number', 'nature'),
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
        'itemsProcFunc' => 'Tx_Addresses_Utility_TCE::getArrayForSelect',
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
?>