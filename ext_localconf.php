<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->saveAction';


$TYPO3_CONF_VARS['FE']['eID_include']['vcard'] = 'EXT:addresses/Resources/Private/Lib/eid_vcard.php'; 

?>