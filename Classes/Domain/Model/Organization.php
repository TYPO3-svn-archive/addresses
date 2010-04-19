<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Susanne Moog <s.moog@neusta.de>
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
 * A single organization
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Organization extends Tx_Addresses_Domain_Model_Contact {
	
	/**
	 * The organization's type
	 *
	 * @var string
	 */
	protected $type = 'organization';	
	
	/**
	 * The organization's name
	 *
	 * @var string
	 */
	protected $name = '';
	
	/**
	 * The remarks of the email address
	 *
	 * @var string
	 */
	protected $remarks = '';
	
	/**
	 * The contact's sectors
	 *
	 * @var array
	 */
	protected $sectors = array();
	
	/**
	 * The contact's numbers
	 *
	 * @var array
	 */
	protected $numbers = array();
	
	/**
	 * The contact's emails
	 *
	 * @var array
	 */
	protected $emails = array();
	
	/**
	 * The contact's websites
	 *
	 * @var array
	 */
	protected $websites = array();
	
	/**
	 * The contact's addresses
	 *
	 * @var array
	 */
	protected $addresses = array();
	
	/**
	 * The contact's images
	 *
	 * @var array
	 */
	protected $images = array();
	
	/**
	 * The contact's tags
	 *
	 * @var array
	 */
	protected $tags = array();

	/**
	 * Constructs this organization
	 *
	 * @return
	 */
	public function __construct() {
	}
		
	/**
	 * Sets this organization's name
	 *
	 * @param string $name The organization's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Returns the organization's name
	 *
	 * @return string The organization's name
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Sets the remarks
	 *
	 * @param string $remarks
	 * @return void
	 */
	public function setRemarks($remarks) {
		$this->remarks = $remarks;
	}

	/**
	 * Returns the remarks
	 *
	 * @return string
	 */
	public function getRemarks() {
		return $this->remarks;
	}
	
	/**
	 * Sets this contact's sectors
	 *
	 * @param array $sectors The contact's sectors
	 * @return void
	 */
	public function setSectors($sectors) {
		$this->sectors = $sectors;
	}

	/**
	 * Returns the contact's sectors
	 *
	 * @return array The contact's sectors
	 */
	public function getSectors() {
		return $this->sectors;
	}

	/**
  	 * Add the contact's sectors
	 *
	 * @param Tx_Addresses_Domain_Model_Sector The sector
	 * @return void
	 */
	public function addSector(Tx_Addresses_Domain_Model_Sector $sector) {
  		$this->sectors[] = $sector;
	}
	
	/**
	 * Sets this contact's numbers
	 *
	 * @param array $numbers The contact's numbers
	 * @return void
	 */
	public function setNumbers($numbers) {
		$this->numbers = $numbers;
	}

	/**
	 * Returns the contact's numbers
	 *
	 * @return array The contact's numbers
	 */
	public function getNumbers() {
		return $this->numbers;
	}

	/**
  	 * Add the contact's numbers
	 *
	 * @param Tx_Addresses_Domain_Model_Number The number
	 * @return void
	 */
	public function addNumber(Tx_Addresses_Domain_Model_Number $number) {
  		$this->numbers[] = $number;
	}
	
	/**
	 * Sets this contact's emails
	 *
	 * @param array $emails The contact's emails
	 * @return void
	 */
	public function setEmails($emails) {
		$this->emails = $emails;
	}

	/**
	 * Returns the contact's emails
	 *
	 * @return array The contact's emails
	 */
	public function getEmails() {
		return $this->emails;
	}

	/**
  	 * Add the contact's emails
	 *
	 * @param Tx_Addresses_Domain_Model_Email The email
	 * @return void
	 */
	public function addEmail(Tx_Addresses_Domain_Model_Email $email) {
  		$this->emails[] = $email;
	}
	
	/**
	 * Sets this contact's websites
	 *
	 * @param array $websites The contact's websites
	 * @return void
	 */
	public function setWebsites($websites) {
		$this->websites = $websites;
	}

	/**
	 * Returns the contact's websites
	 *
	 * @return array The contact's websites
	 */
	public function getWebsites() {
		return $this->websites;
	}

	/**
  	 * Add the contact's websites
	 *
	 * @param Tx_Addresses_Domain_Model_Website The Website
	 * @return void
	 */
	public function addWebsite(Tx_Addresses_Domain_Model_Website $website) {
  		$this->websites[] = $website;
	}
	
	/**
	 * Sets this contact's addresses
	 *
	 * @param array $addresses The contact's addresses
	 * @return void
	 */
	public function setAddresses($addresses) {
		$this->addresses = $addresses;
	}

	/**
	 * Returns the contact's addresses
	 *
	 * @return array The contact's addresses
	 */
	public function getAddresses() {
		return $this->addresses;
	}

	/**
  	 * Add the contact's addresses
	 *
	 * @param Tx_Addresses_Domain_Model_Addresse The addresse
	 * @return void
	 */
	public function addAddresse(Tx_Addresses_Domain_Model_Addresse $addresse) {
  		$this->addresses[] = $addresse;
	}
	
	/**
	 * Sets this contact's images
	 *
	 * @param array $images The contact's images
	 * @return void
	 */
	public function setImages($images) {
		$this->images = $images;
	}

	/**
	 * Returns the contact's images
	 *
	 * @return array The contact's images
	 */
	public function getImages() {
		return $this->images;
	}

	/**
  	 * Add the contact's images
	 *
	 * @param Tx_Addresses_Domain_Model_Image The image
	 * @return void
	 */
	public function addImage(Tx_Addresses_Domain_Model_Image $image) {
  		$this->images[] = $image;
	}
	
	/**
	 * Sets this contact's tags
	 *
	 * @param array $tags The contact's tags
	 * @return void
	 */
	public function setTags($tags) {
		$this->tags = $tags;
	}

	/**
	 * Returns the contact's tags
	 *
	 * @return array The contact's tags
	 */
	public function getTags() {
		return $this->tags;
	}

	/**
  	 * Add the contact's tags
	 *
	 * @param Tx_Addresses_Domain_Model_Tag The tag
	 * @return void
	 */
	public function addTag(Tx_Addresses_Domain_Model_Tag $tag) {
  		$this->tags[] = $tag;
	}
	
	/**
	 * Returns this tag as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getName();
	}
}
?>