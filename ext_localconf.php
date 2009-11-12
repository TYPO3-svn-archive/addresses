<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

/**
 * Configure the Plugin to call the
 * right combination of Controller and Action according to
 * the user input (default settings, FlexForm, URL etc.)
 */
Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',		
	array(																			
		'Address' => 'index,show,vcard,vcards',	
		),
	array(																			
		'Address' => 'index,show,vcard,vcards',	
		)
);


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

// Contactnumber
$TYPO3_CONF_VARS['BE']['AJAX']['ContactnumberController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactnumberController.php:Tx_Addresses_Controller_ContactnumberController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactnumberController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactnumberController.php:Tx_Addresses_Controller_ContactnumberController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactnumberController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactnumberController.php:Tx_Addresses_Controller_ContactnumberController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactnumberController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactnumberController.php:Tx_Addresses_Controller_ContactnumberController->saveAction';

// Location
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->saveAction';

// GroupAddresses
$TYPO3_CONF_VARS['FE']['eID_include']['vcard'] = 'EXT:addresses/Resources/Private/Lib/eid_vcard.php'; 

?>