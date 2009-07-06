<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// Address
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:Tx_Addresses_Controller_AddressController->saveAction';

// AddressGroup
$TYPO3_CONF_VARS['BE']['AJAX']['AddressGroupController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressGroupController.php:Tx_Addresses_Controller_AddressGroupController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressGroupController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressGroupController.php:Tx_Addresses_Controller_AddressGroupController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressGroupController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressGroupController.php:Tx_Addresses_Controller_AddressGroupController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['AddressGroupController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressGroupController.php:Tx_Addresses_Controller_AddressGroupController->saveAction';

// GroupAddresses
$TYPO3_CONF_VARS['FE']['eID_include']['vcard'] = 'EXT:addresses/Resources/Private/Lib/eid_vcard.php'; 

?>