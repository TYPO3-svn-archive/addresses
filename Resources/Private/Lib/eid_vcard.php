<?php

	// eID specific initialization of user and database
	tslib_eidtools::connectDB();
	tslib_eidtools::initFeUser();
	 
	// initialize TSFE
	require_once(PATH_tslib.'class.tslib_fe.php');
	require_once(PATH_t3lib.'class.t3lib_page.php');
	$temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
	$pid = inval(t3lib_div::_GET('id'));
	$GLOBALS['TSFE'] = new $temp_TSFEclassName($TYPO3_CONF_VARS, $pid, 0, true);
	$GLOBALS['TSFE']->connectToDB();
	$GLOBALS['TSFE']->initFEuser();
	$GLOBALS['TSFE']->determineId();
	$GLOBALS['TSFE']->getCompressedTCarray();
	$GLOBALS['TSFE']->initTemplate();
	$GLOBALS['TSFE']->getConfigArray();
	
	// require dispatcher and get autoloader
	require_once(t3lib_extMgm::extPath('extbase') . 'Classes/Dispatcher.php');
	spl_autoload_register(array('Tx_Extbase_Dispatcher', 'autoloadClass'));
	
	// create dispatcher and dispatch
	$eid_dispatcher = t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
	echo $eid_dispatcher->dispatch('',$GLOBALS['TSFE']->tmpl->setup['tt_content.']['list.']['20.']['addresses_pi1.']);

?>