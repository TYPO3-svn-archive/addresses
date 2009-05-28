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

if (TYPO3_MODE != 'BE') {
	die ('Access denied!');
}

// Check whether the user has access
global $BE_USER;
require(t3lib_extMgm::extPath('addresses') . 'Module/conf.php');

// Check user permissions
$BE_USER->modAccess($MCONF, 1);	// This checks permissions and exits if the users has no permission for entry.

// Pre-Include all models and views
require_once(t3lib_extMgm::extPath('addresses', 'Module/Classes/Domain/Model/class.tx_addresses_model_address.php'));

/**
 * Controller class for the 'addresses' extension. Handles the AJAX Requests
 *
 * @author		Fabien Udriot <fabien.udriot@ecodev.ch>
 * @package		TYPO3
 * @subpackage	tx_addresses
 * @version 	$Id$
 */
class tx_addresses_controller {
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
		$this->model = t3lib_div::makeInstance('tx_addresses_model_address');
		$this->data = json_decode(t3lib_div::_GP('data'));
	}

	/**
	 * Echoes the address
	 *
	 * @return void
	 **/
	public function indexAction() {
		$this->model = t3lib_div::makeInstance('tx_addresses_model_address');
		$message = $this->model->findAll();
		echo json_encode($message);
	}

	/**
	 * Echoes the addresses according to the Id
	 *
	 * @return void
	 **/
	public function editAction() {
		$message['success'] = FALSE;
		if (!empty($this->data)) {
			$message = $this->model->findById($this->data);
		}
		echo json_encode($message);
	}

	/**
	 * Delete the address(es)
	 *
	 * @return void
	 **/
	public function deleteAction() {
		$message['success'] = FALSE;
		if (!empty($this->data)) {
			$message['success'] = $this->model->delete($this->data);
		}
		echo json_encode($message);
	}

	/**
	 * Save the address(es)
	 *
	 * @return void
	 **/
	public function saveAction() {
		$message['success'] = FALSE;
		$request = $this->model->save();
		if ($request) {
			$message['success'] = TRUE;
			$message['request'] = $request;
		}
		echo json_encode($message);
	}

	/**
	 * Sets data in the session of the current backend user.
	 *
	 * @param	string		$identifier: The identifier to be used to set the data
	 * @param	string		$data: The data to be stored in the session
	 * @return	void
	 */
	protected function setDataInSession($identifier, $data) {
		$GLOBALS['BE_USER']->uc['tx_addresses'][$identifier] = $data;
		$GLOBALS['BE_USER']->writeUC();
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/Classes/controller/class.tx_addresses_controller.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/addresses/Module/Classes/controller/class.tx_addresses_controller.php']);
}

?>