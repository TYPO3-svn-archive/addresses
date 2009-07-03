<?php

// This section describes the columns of the grid.
$domainName = 'tx_addresses_domain_model_addressgroup';
t3lib_div::loadTCA($domainName);

$TCA[$domainName]['types']['module']['showitem'] = <<< EOF
--div--;LLL:EXT:addresses/Resources/Private/Language/locallang_tca.xml:person,title
EOF;


?>