<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// Address
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->saveAction';

// Addressgroup
$TYPO3_CONF_VARS['BE']['AJAX']['AddressgroupController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressgroupController.php:Tx_Addresses_Controller_AddressgroupController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressgroupController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressgroupController.php:Tx_Addresses_Controller_AddressgroupController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressgroupController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressgroupController.php:Tx_Addresses_Controller_AddressgroupController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressgroupController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressgroupController.php:Tx_Addresses_Controller_AddressgroupController->saveAction';

// GroupAddresses
$TYPO3_CONF_VARS['FE']['eID_include']['vcard'] = 'EXT:addresses/Resources/Private/Lib/eid_vcard.php'; 

?>