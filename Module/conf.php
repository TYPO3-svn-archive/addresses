<?php
// DO NOT REMOVE OR CHANGE THESE 3 LINES:
define('TYPO3_MOD_PATH', '../typo3conf/ext/addresses/Module/');

preg_match('/(typo3|typo3conf)\/ext\/addresses\/Module\/index\.php$/i', $_SERVER['SCRIPT_FILENAME'], $match);

// define the $BACK_PATH... a bit tricky but necessary.
// Handle path like: 
// * http://localhost/mywebsite/
// * http://mywebsite/
if (strpos($_SERVER['SCRIPT_NAME'], 'ext/addresses/Module/index.php') !== FALSE) {
	if (empty($match)) {
		//$BACK_PATH='../../../../typo3/';
		die('ERROR: $match is empty. Try an other PATH in file ' . __FILE__ . ' on line ' . __LINE__);
	}
}
$BACK_PATH = str_replace($match[0], '', $_SERVER['SCRIPT_FILENAME']);
$BACK_PATH .= 'typo3/';

$MCONF['name'] = 'user_txaddresses';

$MCONF['access'] = 'user,group';
$MCONF['script'] = 'index.php';
//$MCONF['script'] = 'controllers/class.tx_addresses_controllers_list.php';

$MLANG['default']['tabs_images']['tab'] = 'book_open.png';
$MLANG['default']['ll_ref']='LLL:EXT:addresses/Module/locallang_mod.xml';
?>