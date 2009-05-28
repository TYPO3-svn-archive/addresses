<?php
// DO NOT REMOVE OR CHANGE THESE 3 LINES:
define('TYPO3_MOD_PATH', '../typo3conf/ext/addresses/Module/');
$BACK_PATH='../../../../typo3/';
$BACK_PATH= $_SERVER['DOCUMENT_ROOT'] . '/typo3/';
$MCONF['name'] = 'user_txaddresses';

$MCONF['access'] = 'user,group';
$MCONF['script'] = 'index.php';
//$MCONF['script'] = 'controllers/class.tx_addresses_controllers_list.php';

$MLANG['default']['tabs_images']['tab'] = 'book_open.png';
$MLANG['default']['ll_ref']='LLL:EXT:addresses/Module/locallang_mod.xml';
?>