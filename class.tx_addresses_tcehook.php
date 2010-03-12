<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2009 Fabien Udriot (fabien.udriot@ecodev.ch)
*
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 * Handle addresses record
 *
 * @category    Configuration
 * @package     TYPO3
 * @subpackage  addresses
 * @author Fabien Udriot <fabien.udriot@ecodev.ch>
 * @license     http://www.gnu.org/copyleft/gpl.html
 * @version $Id$
 */
class tx_addresses_tcehook {

	/**
	 * Main method acting as a dispatcher for TCE hooks
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, $pObj) {

		//&& ($status == 'new' || $status == 'update')
		if($table == 'tx_addresses_domain_model_number') {
			$this->processNumber($status, $table, $id, $fieldArray, $pObj);
		}

		if($table == 'tx_addresses_domain_model_email') {
			$this->processEmail($status, $table, $id, $fieldArray, $pObj);
		}

		if($table == 'tx_addresses_domain_model_website') {
			$this->processWebsite($status, $table, $id, $fieldArray, $pObj);
		}

		if($table == 'tx_addresses_domain_model_address') {
			$this->processAddress($status, $table, $id, $fieldArray, $pObj);
		}

		if($table == 'tx_addresses_domain_model_sector') {
			$this->processSector($status, $table, $id, $fieldArray, $pObj);
		}
	}
	
	/**
	 * process label for table "tx_addresses_domain_model_number"
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	private function processNumber($status, $table, $id, &$fieldArray, $pObj) {
		$values = $pObj->datamap[$table][$id];
		$fieldArray['label'] = $values['number'];
		if (isset($values['type']) && $values['type'] != '') {
			$fieldArray['label'] = $fieldArray['label'] . ' (' . $values['type'] . ')';
		}
	}

	/**
	 * process label for table "tx_addresses_domain_model_number"
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	private function processEmail($status, $table, $id, &$fieldArray, $pObj) {
		$values = $pObj->datamap[$table][$id];
		$fieldArray['label'] = $values['email_address'];
		if (isset($values['type']) && $values['type'] != '') {
			$fieldArray['label'] = $fieldArray['label'] . ' (' . $values['type'] . ')';
		}
	}

	/**
	 * process label for table "tx_addresses_domain_model_number"
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	private function processWebsite($status, $table, $id, &$fieldArray, $pObj) {
		$values = $pObj->datamap[$table][$id];
		$fieldArray['label'] = $values['website'];
		if (isset($values['type']) && $values['type'] != '') {
			$fieldArray['label'] = $fieldArray['label'] . ' (' . $values['type'] . ')';
		}
	}

	/**
	 * process label for table "tx_addresses_domain_model_number"
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	private function processAddress($status, $table, $id, &$fieldArray, $pObj) {
		$values = $pObj->datamap[$table][$id];
		$fieldArray['label'] = $values['postal_code'] . ' ' . $values['locality'] . ', ' . $values['street'];
		#if (isset($values['type']) && $values['type'] != '') {
		#	$fieldArray['label'] = $fieldArray['label'] . ' (' . $values['type'] . ')';
		#}
		#$record = $this->getFullRecord($id, $table);
	}

	/**
	 * process label for table "tx_addresses_domain_model_number"
	 *
	 * @param	string		action status: new/update is relevant for us
	 * @param	string		db table
	 * @param	integer		record uid
	 * @param	array		record
	 * @param	object		parent object
	 * @return	void
	 */
	private function processSector($status, $table, $id, &$fieldArray, $pObj) {
		$values = $pObj->datamap[$table][$id];
		$fieldArray['label'] = $values['name'];
		#if (isset($values['type']) && $values['type'] != '') {
		#	$fieldArray['label'] = $fieldArray['label'] . ' (' . $values['type'] . ')';
		#}
		#$record = $this->getFullRecord($id, $table);
	}

	/**
	 * gets a full cuso record
	 *
	 * @param	integer	$uid: unique id of the cuso record to get
	 * @param	string	$tableName: unique id of the cuso record to get
	 * @return	array	full cuso record with associative keys
	 */
	private function getFullRecord($uid, $tableName) {
		global $TYPO3_DB;
		$row = $TYPO3_DB->exec_SELECTgetRows(
			'*',
			$tableName,
			'uid = '.$uid
		);

		return $row[0];
	}

	/**
	 * Includes the locallang file for the 'addresses' extension
	 *
	 * @return	array		The LOCAL_LANG array
	 */
#	private function includeLocalLang()	{
#		$llFile     = $GLOBALS['_SERVER']['DOCUMENT_ROOT']. '/fileadmin/templates/mailforms/registration-lang.xml';
#		$LOCAL_LANG = t3lib_div::readLLXMLfile($llFile, $GLOBALS['LANG']->lang);
#
#		return $LOCAL_LANG;
#	}
}

?>
