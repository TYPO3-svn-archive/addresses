<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:AddressController->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:AddressController->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:AddressController->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/AddressController.php:AddressController->saveAction';

?>