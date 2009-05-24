<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2009 Susanne Moog <s.moog@neusta.de>
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
 * The address controller for the Address package
 *
 * @version $Id:$
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_Addresses_Controller_AddressController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_Addresses_Domain_Model_AddressRepository
	 */
	protected $addressRepository;

	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {		
		$this->addressRepository = t3lib_div::makeInstance('Tx_Addresses_Domain_Model_AddressRepository');	
		//$this->groupRepository = t3lib_div::makeInstance('Tx_Addresses_Domain_Model_AddressgroupRepository');	
	}

	/**
	 * Index action for this controller. Displays a list of addresses.
	 *
	 * @return string The rendered view
	 */
	public function indexAction() {
		
		// Stylesheet
		$this->response->addAdditionalHeaderData('<link rel="stylesheet" href="' . t3lib_extMgm::siteRelPath('addresses') . 'Resources/Public/Stylesheets/index.css" />');
		
		// TS Config transformed to shorter variable
		$this->indexConf = $this->settings['controllers']['Address']['actions']['index'];

		//Get the actual data to be displayed
		/*Group queries do not work (see AdressRepository for more info)
		if($this->indexConf['groups']) {
			// gets the page browser (includes initialization and logic)
			$data = $this->addressRepository->findWithGroup($this->indexConf['groups'], $limit);
		} else {
		*/
			$this->currentPage = $_GET['tx_addresses_pi1']['page'];
			$limit = $this->indexConf['maxItems'] * ($this->currentPage) . ',' . $this->indexConf['maxItems'];
	
			$data = $this->addressRepository->findLimit($limit,$this->indexConf['sortBy']);
		//}
	
		$this->view->assign('maxItems', $this->indexConf['maxItems']); 
		$this->view->assign('totalPages', count($this->addressRepository->findAll())); 
		$this->view->assign('addresses', $data);
		
	}

	/**
	 * Shows a single address
	 *
	 * @param Tx_Addresses_Domain_Model_Address $address The address to show
	 * @return string The rendered view of a single address
	 */
	public function showAction(Tx_Addresses_Domain_Model_Address $address) {
		$this->response->addAdditionalHeaderData('<link rel="stylesheet" href="' . t3lib_extMgm::siteRelPath('addresses') . 'Resources/Public/Stylesheets/show.css" />');
		$this->view->assign('address', $address);
	}

}

?>