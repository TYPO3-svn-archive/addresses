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
 * A single address
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class tx_addresses_domain_model_address extends Tx_Extbase_DomainObject_AbstractEntity {

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
	 * The type
	 *
	 * @var string
	 */
	protected $type = '';

	/**
	 * The nature of the address
	 *
	 * @var string
	 */
	protected $nature = '';
	
	/**
	 * The label of the address
	 *
	 * @var string
	 */
	protected $label = '';

	/**
	 * The street
	 *
	 * @var string
	 */
	protected $street = '';

	/**
	 * The streetNumber
	 *
	 * @var string
	 */
	protected $streetNumber = '';
	
	/**
	 * The building
	 *
	 * @var string
	 */
	protected $building = '';

	/**
	 * The room
	 *
	 * @var string
	 */
	protected $room = '';
	
	/**
	 * The postalCode 
	 *
	 * @var string
	 */
	protected $postalCode = '';
	
	/**
	 * The locality
	 *
	 * @var string
	 */
	protected $locality = '';
	
	/**
	 * The region
	 *
	 * @var string
	 */
	protected $region = '';
	
	/**
	 * The country
	 *
	 * @var string
	 */
	protected $country = '';
	
	/**
	 * The latitude
	 *
	 * @var string
	 */
	protected $latitude = '';
	
	/**
	 * The longitude
	 *
	 * @var string
	 */
	protected $longitude = '';

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
	 * Sets this address's type
	 *
	 * @param string $type The address's type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the address's type
	 *
	 * @return string The address's type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Sets this address's nature
	 *
	 * @param string $nature The address's nature
	 * @return void
	 */
	public function setNature($nature) {
		$this->nature = $nature;
	}

	/**
	 * Returns the address's nature
	 *
	 * @return string The address's nature
	 */
	public function getNature() {
		return $this->nature;
	}
	
	/**
	 * Sets this address's label
	 *
	 * @param string $label The address's label
	 * @return void
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Returns the address's label
	 *
	 * @return string The address's label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * Sets this address's street
	 *
	 * @param string $street The address's street
	 * @return void
	 */
	public function setStreet($street) {
		$this->street = $street;
	}

	/**
	 * Returns the address's street
	 *
	 * @return string The address's street
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * Sets this address's streetNumber
	 *
	 * @param string $streetNumber The address's street
	 * @return void
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}

	/**
	 * Returns the address's streetNumber
	 *
	 * @return string The address's streetNumber
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
	}


	/**
	 * Sets the room
	 *
	 * @param string $room The room
	 * @return void
	 */
	public function setRoom($room) {
		$this->room = $room;
	}

	/**
	 * Returns the room
	 *
	 * @return string The room
	 */
	public function getRoom() {
		return $this->room;
	}

	/**
	 * Sets the building
	 *
	 * @param string $building The building
	 * @return void
	 */
	public function setBuilding($building) {
		$this->building = $building;
	}

	/**
	 * Returns the building
	 *
	 * @return string The building
	 */
	public function getBuilding() {
		return $this->building;
	}

	/**
	 * Sets this address's postalCode code
	 *
	 * @param string $postalCode The address's postalCode code
	 * @return void
	 */
	public function setPostalCode($postalCode) {
		$this->postalCode = $postalCode;
	}

	/**
	 * Returns the address's postalCode code
	 *
	 * @return string The address's postalCode code
	 */
	public function getPostalCode() {
		return $this->postalCode;
	}

	/**
	 * Sets the locality
	 *
	 * @param string $locality The locality
	 * @return void
	 */
	public function setLocality($locality) {
		$this->locality = $locality;
	}

	/**
	 * Returns the locality
	 *
	 * @return string The locality
	 */
	public function getLocality() {
		return $this->locality;
	}
	
	/**
	 * Sets this address's region
	 *
	 * @param string $region The address's region
	 * @return void
	 */
	public function setRegion($region) {
		$this->region = $region;
	}

	/**
	 * Returns the address's region
	 *
	 * @return string The address's region
	 */
	public function getRegion() {
		return $this->region;
	}
	
	/**
	 * Sets this address's country
	 *
	 * @param string $country The address's country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the address's country
	 *
	 * @return string The address's country
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * Sets this address's latitude
	 *
	 * @param string $latitude The address's latitude
	 * @return void
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	/**
	 * Returns the address's latitude
	 *
	 * @return string The address's latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}
	
	/**
	 * Sets this address's longitude
	 *
	 * @param string $longitude The address's longitude
	 * @return void
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	/**
	 * Returns the address's longitude
	 *
	 * @return string The address's longitude
	 */
	public function getLongitude() {
		return $this->longitude;
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
		return $this->street . ', ' . $this->postalCode . ' ' . $this->locality;
	}
}
?>