<?php

// This section describes the columns of the grid.
$domainName = 'tx_addresses_domain_model_addressgroup';
t3lib_div::loadTCA($domainName);

$TCA[$domainName]['types']['module']['showitem'] = array(
	// Describes the left panel.
	array(
		'width' => 0.6,
		// Describes the tab of the left panel
		'panels' => array (
			array(
				'title' => ';LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:group',
				'fields' => array('title'),
			),
		),
	),
	// Describes the right panel.
	array(
		'width' => 0.4,
		'panels' => array(
			array(
				'title' => '',
				'fields' => array('remarks'),
			),
		),
	),
);

?>