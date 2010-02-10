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
$TYPO3_CONF_VARS['BE']['AJAX']['ContactController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactController.php:Tx_Addresses_Controller_ContactController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactController.php:Tx_Addresses_Controller_ContactController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactController.php:Tx_Addresses_Controller_ContactController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['ContactController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/ContactController.php:Tx_Addresses_Controller_ContactController->saveAction';

// Group
$TYPO3_CONF_VARS['BE']['AJAX']['GroupController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/GroupController.php:Tx_Addresses_Controller_GroupController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['GroupController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/GroupController.php:Tx_Addresses_Controller_GroupController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['GroupController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/GroupController.php:Tx_Addresses_Controller_GroupController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['GroupController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/GroupController.php:Tx_Addresses_Controller_GroupController->saveAction';

// Number
$TYPO3_CONF_VARS['BE']['AJAX']['NumberController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/NumberController.php:Tx_Addresses_Controller_NumberController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['NumberController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/NumberController.php:Tx_Addresses_Controller_NumberController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['NumberController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/NumberController.php:Tx_Addresses_Controller_NumberController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['NumberController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/NumberController.php:Tx_Addresses_Controller_NumberController->saveAction';

// Location
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['LocationController::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/LocationController.php:Tx_Addresses_Controller_LocationController->saveAction';

// GroupAddresses
$TYPO3_CONF_VARS['FE']['eID_include']['vcard'] = 'EXT:addresses/Resources/Private/Lib/eid_vcard.php'; 

?>