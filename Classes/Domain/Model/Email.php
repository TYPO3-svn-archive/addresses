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
 * A single email
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @valueobject
 */
class Tx_Addresses_Domain_Model_Email extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * The uid of the parent person
	 *
	 * @var Object
	 */
	protected $person = '';
	
	/**
	 * The uid of the parent organization
	 *
	 * @var Object
	 */
	protected $organization = '';
	
	/**
	 * The label of the sector
	 *
	 * @var string
	 */
	protected $label = '';

	/**
	 * The type
	 *
	 * @var string
	 */
	protected $type = '';
	
	/**
	 * The email address
	 *
	 * @var string
	 */
	protected $emailAddress = '';

	/**
	 * The remarks of the email address
	 *
	 * @var string
	 */
	protected $remarks = '';
	
	/**
	 * The contact's tags
	 *
	 * @var array
	 */
	protected $tags = array();
	
	/**
	 * Constructs this address
	 *
	 * @return
	 */
	public function __construct() {
	}
	
	/**
	 * Sets the person
	 *
	 * @param Tx_Addresses_Domain_Model_Person $person The person
	 * @return void
	 */
	public function setPerson(Tx_Addresses_Domain_Model_Person $person) {
		$this->person = $person;
	}

	/**
	 * Returns the person
	 *
	 * @return Tx_Addresses_Domain_Model_Person the person
	 */
	public function getPerson() {
		return $this->person;
	}
	
	/**
	 * Sets the organization
	 *
	 * @param Tx_Addresses_Domain_Model_Organization $organization The organization
	 * @return void
	 */
	public function setOrganization(Tx_Addresses_Domain_Model_Organization $organization) {
		$this->organization = $organization;
	}

	/**
	 * Returns the organization
	 *
	 * @return Tx_Addresses_Domain_Model_Organization the organization
	 */
	public function getOrganization() {
		return $this->organization;
	}
	
	/**
	 * Sets the label
	 *
	 * @param string $label The label
	 * @return void
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Returns the label 
	 *
	 * @return string the label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * Sets the type
	 *
	 * @param string $type The type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the type 
	 *
	 * @return string the type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Sets the email address
	 *
	 * @param string $emailAddress The email address
	 * @return void
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	/**
	 * Returns the email address
	 *
	 * @return string the email address
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
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
	 * Returns this address as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->emailAddress;
	}
}
?>