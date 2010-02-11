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
 * A single location
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Location extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The type
	 *
	 * @var int
	 */
	protected $type = '';

	/**
	 * The nature of the location
	 *
	 * @var string
	 */
	protected $nature = '';
	
	/**
	 * The label of the location
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
	 * The address
	 *
	 * @var string
	 */
	protected $address = '';
	
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
	 * The city
	 *
	 * @var string
	 */
	protected $city = '';
	
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
	 * The remarks of the location
	 *
	 * @var string
	 */
	protected $remarks = '';


	/**
	 * Constructs this location
	 *
	 * @return
	 */
	public function __construct() {
	}


	/**
	 * Sets this location's type
	 *
	 * @param string $type The location's type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the location's type
	 *
	 * @return string The location's type
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * Sets this location's nature
	 *
	 * @param string $nature The location's nature
	 * @return void
	 */
	public function setNature($nature) {
		$this->nature = $nature;
	}

	/**
	 * Returns the location's nature
	 *
	 * @return string The location's nature
	 */
	public function getNature() {
		return $this->nature;
	}
	
	/**
	 * Sets this location's label
	 *
	 * @param string $label The location's label
	 * @return void
	 */
	public function setLabel($label) {
		$this->label = $label;
	}

	/**
	 * Returns the location's label
	 *
	 * @return string The location's label
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * Sets this location's street
	 *
	 * @param string $street The location's street
	 * @return void
	 */
	public function setStreet($street) {
		$this->street = $street;
	}

	/**
	 * Returns the location's street
	 *
	 * @return string The location's street
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * Sets this location's streetNumber
	 *
	 * @param string $streetNumber The location's street
	 * @return void
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}

	/**
	 * Returns the location's streetNumber
	 *
	 * @return string The location's streetNumber
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
	}

	/**
	 * Sets this location's address (street and number)
	 *
	 * @param string $address The location's address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the location's address
	 *
	 * @return string The location's address
	 */
	public function getAddress() {
		return $this->address;
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
	 * Sets this location's postalCode code
	 *
	 * @param string $postalCode The location's postalCode code
	 * @return void
	 */
	public function setPostalCode($postalCode) {
		$this->postalCode = $postalCode;
	}

	/**
	 * Returns the location's postalCode code
	 *
	 * @return string The location's postalCode code
	 */
	public function getPostalCode() {
		return $this->postalCode;
	}

	/**
	 * Sets the city
	 *
	 * @param string $city The city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the city
	 *
	 * @return string The city
	 */
	public function getCity() {
		return $this->city;
	}
	
	/**
	 * Sets this location's region
	 *
	 * @param string $region The location's region
	 * @return void
	 */
	public function setRegion($region) {
		$this->region = $region;
	}

	/**
	 * Returns the location's region
	 *
	 * @return string The location's region
	 */
	public function getRegion() {
		return $this->region;
	}
	
	/**
	 * Sets this location's country
	 *
	 * @param string $country The location's country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the location's country
	 *
	 * @return string The location's country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the remarks for the location
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
	 * Returns this address as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->street . ' ' . $this->streetNumber . ',' . $this->postalCode . ' ' . $this->city;
	}
}
?>