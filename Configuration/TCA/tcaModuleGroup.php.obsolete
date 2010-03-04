<?php

// This section describes the columns of the grid.
$domainName = 'tx_addresses_domain_model_group';
t3lib_div::loadTCA($domainName);

$TCA[$domainName]['types']['module']['showitem'] = array(
	// Describes the left panel.
	array(
		'columnWidth' => 0.6,
		'xtype' => 'tabpanel',
		// Describes the tab of the left panel
		'panels' => array (
			array(
				'title' => 'LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:group',
				'fields' => array('title'),
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

?>