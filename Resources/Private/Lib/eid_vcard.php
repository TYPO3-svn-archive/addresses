<?php

	// eID specific initialization of user and database
	tslib_eidtools::connectDB();
	tslib_eidtools::initFeUser();
	 
	// initialize TSFE
	$temp_TSFEclassName = t3lib_div::makeInstanceClassName('tslib_fe');
	$pid = intval(t3lib_div::_GET('id'));
	$GLOBALS['TSFE'] = new $temp_TSFEclassName($TYPO3_CONF_VARS, $pid, 0, true);
	$GLOBALS['TSFE']->connectToDB();
	$GLOBALS['TSFE']->initFEuser();
	$GLOBALS['TSFE']->determineId();
	$GLOBALS['TSFE']->getCompressedTCarray();
	$GLOBALS['TSFE']->initTemplate();
	$GLOBALS['TSFE']->getConfigArray();
    	debug($GLOBALS['TSFE']->tmpl->setup['tt_content.']['list.']['20.']['addresses_pi1.']);
	// create dispatcher and dispatch
	$eid_dispatcher = t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
	$eid_dispatcher->cObj = t3lib_div::makeInstance('tslib_cObj');    // Local cObj.
	echo $eid_dispatcher->dispatch('', $GLOBALS['TSFE']->tmpl->setup['tt_content.']['list.']['20.']['addresses_pi1.']);

?>