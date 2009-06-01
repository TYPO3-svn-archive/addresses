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
 * @version $Id: $
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
	}

	/**
	 * Index action for this controller. Displays a list of addresses.
	 *
	 * @param  integer The current page
	 * @return string The rendered view
	 */
	public function indexAction($currentPage = NULL) {
		$limit = ''; // used to fetch this count of addresses from the database with a given offset (example: 0,5)
		$data = Array(); // used to store the objects fetched from the repository
			
		// Stylesheet
		$this->response->addAdditionalHeaderData('<link rel="stylesheet" href="' . t3lib_extMgm::siteRelPath('addresses') . 'Resources/Public/Stylesheets/index.css" />');
		
		// TS Config transformed to shorter variable
		$this->indexSettings = $this->settings['controllers']['Address']['actions']['index'];
			
		$limit = $this->indexSettings['maxItems'] * ($currentPage) . ',' . $this->indexSettings['maxItems'];

		$data = $this->addressRepository->findLimit($limit,$this->indexSettings['sortBy']);

		$this->view->assign('maxItems', $this->indexSettings['maxItems']); 
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
	
	/**
	 * Exports a single address to vCard
	 *
	 * @param Tx_Addresses_Domain_Model_Address $address The address to show
	 * @return string The rendered view of a single address
	 */
	public function vcardAction(Tx_Addresses_Domain_Model_Address $address) {
		$this->view->assign('address', $address);
		header('Content-Type: text/x-vCard');
		header('Content-Disposition: attachment; filename= "' . $address->getFirstName() . '_' . $address->getLastName() . '.vcf"');
		echo $this->view->render();
		exit;
	}
	
	/**
	 * vCards action for this controller. Accumulates all addresses into a vcf file
	 *
	 * @return string The rendered view
	 */
	public function vcardsAction() {
		$data = Array();
		$data = $this->addressRepository->findAll(); 
		$this->view->assign('addresses', $data);
		header('Content-Type: text/x-vCard');
		header('Content-Disposition: attachment; filename= "addresses.vcf"');
		echo $this->view->render();
		exit;
	}

}

?>