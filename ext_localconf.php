<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::indexAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/class.tx_addresses_controller.php:tx_addresses_controller->indexAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::editAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/class.tx_addresses_controller.php:tx_addresses_controller->editAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::deleteAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/class.tx_addresses_controller.php:tx_addresses_controller->deleteAction';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_addresses::saveAction'] = t3lib_extMgm::extPath($_EXTKEY) . 'Module/Classes/Controller/class.tx_addresses_controller.php:tx_addresses_controller->saveAction';

?>