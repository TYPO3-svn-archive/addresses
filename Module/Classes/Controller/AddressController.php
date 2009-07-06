<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Fabien Udriot <fabien.udriot@ecodev.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
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
 * Controller class for addresses
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

// Check whether the user has access to the module
global $BE_USER;
$MCONF['name'] = 'user_txaddresses';
$MCONF['access'] = 'user,group';
$BE_USER->modAccess($MCONF, 1);	// This checks makes sure the user has the permissions. Exits if that not the case.

// Pre-Include all models and views
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Controller/ControllerAbstract.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Domain/Model/AddressRepository.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/Preferences.php'));
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Utility/TCA.php'));

/**
 * Controller class for the 'addresses' extension. Handles the AJAX Requests
 *
 * @author		Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package		TYPO3
 * @subpackage	tx_addresses
 * @version 	$Id$
 */
class Tx_Addresses_Controller_AddressController extends Tx_Addresses_Controller_ControllerAbstract{
	/**
	 * Stores relevant data from extJS
	 * Example: Json format
	 * [ ["pages",1],["pages",2],["tt_content",34] ]
	 *
	 * @var	string
	 */
	protected $data;

	/**
	 * Initialize method
	 *
	 * @return void
	 */
	public function __construct() {
		$this->model = t3lib_div::makeInstance('Tx_Addresses_Domain_Model_AddressRepository');
		$this->data = json_decode(t3lib_div::_GP('data'));
	}

	/**
	 * Echoes the address
	 *
	 * @return void
	 **/
	public function indexAction() {
		try {
			$this->model = t3lib_div::makeInstance('Tx_Addresses_Domain_Model_AddressRepository');
			$message = $this->model->findAll();
			echo json_encode($message);
		}
		catch (Exception $e) {
			print $e->getMessage();
		}
	}

	/**
	 * Echoes the addresses according to the Id
	 *
	 * @return void
	 **/
	public function editAction() {
		try {
			$message['success'] = FALSE;
			if (!empty($this->data) && (int)$this->data[0]->uid > 0) {
				$message = $this->model->findById($this->data);
			}
			echo json_encode($message);
		}
		catch (Exception $e) {
			print $e->getMessage();
		}
	}

	/**
	 * Delete the address(es)
	 *
	 * @return void
	 **/
	public function deleteAction() {
		try {
			$message['success'] = FALSE;
			if (!empty($this->data)) {
				$message['success'] = $this->model->delete($this->data);
			}
			echo json_encode($message);
		}
		catch (Exception $e) {
			print $e->getMessage();
		}
	}

	/**
	 * Save the address(es)
	 *
	 * @return void
	 **/
	public function saveAction() {
		try {
			$message['success'] = FALSE;
			$requestType = $this->model->save();

			if ($requestType) {
				$message['success'] = TRUE;
				$message['request'] = $requestType;
			}
			echo json_encode($message);
		}
		catch (Exception $e) {
			print $e->getMessage();
		}
	}

/**
 * Sets data in the session of the current backend user.
 *
 * @param	string		$identifier: The identifier to be used to set the data
 * @param	string		$data: The data to be stored in the session
 * @return	void
 */
//	protected function setDataInSession($identifier, $data) {
//		$GLOBALS['BE_USER']->uc['tx_addresses'][$identifier] = $data;
//		$GLOBALS['BE_USER']->writeUC();
//	}
}

?>