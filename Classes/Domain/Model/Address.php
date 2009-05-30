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
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Address extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * The contact's gender
	 *
	 * @var string
	 */
	protected $gender = '';

	/**
	 * The contact's first_name
	 *
	 * @var string
	 */
	protected $firstName = '';

	/**
	 * The contact's last_name
	 *
	 * @var string
	 */
	protected $lastName = '';

	/**
	 * The contact's marital status
	 * 
	 * @var int marital_status
	 */
	
	protected $maritalStatus = '';

	/**
	 * A contact's title
	 *
	 * @var string
	 */
	protected $title = '';
	
	/**
	 * A contact's birthday
	 *
	 * @var DateTime
	 */
	protected $birthday = '';

	/**
	 * The email address
	 *
	 * @var string
	 */
	protected $email = '';

	/**
	 * The phone number
	 *
	 * @var string
	 */
	protected $phone = '';

	/**
	 * The mobile phone number
	 * 
	 * @var string
	 */
	protected $mobile = '';

	/**
	 * The web address
	 * 
	 * @var string
	 */
	protected $www = '';

	/**
	 * The address (street and number)
	 * 
	 * @var string
	 */
	protected $address = '';

	/**
	 * The company
	 * 
	 * @var string
	 */
	protected $company = '';
	
	/**
	 * The room
	 * 
	 * @var string
	 */
	protected $room = '';
	
	/**
	 * The building
	 * 
	 * @var string
	 */
	protected $building = '';

	/**
	 * The city
	 * 
	 * @var string
	 */
	protected $city = '';

	/**
	 * The zip code
	 * 
	 * @var string
	 */
	protected $zip = '';

	/**
	 * The country
	 * 
	 * @var string
	 */
	protected $country = '';
	
	/**
	 * The preferred_language
	 * 
	 * @var string
	 */
	protected $preferredLanguage = '';
	
	
	/**
	 * The image of the contact
	 * 
	 * @var string
	 */
	protected $image = '';

	/**
	 * The fax number
	 * 
	 * @var string
	 */
	protected $fax = '';

	/**
	 * The description of the contact
	 * 
	 * @var string
	 */
	protected $description = '';
	
	/**
	 * The addressgroups of the contact
	 * 
	 * @var array
	 */
	protected $addressgroups = array();

	/**
	 * Constructs this address
	 *
	 * @return
	 */
	public function __construct() {
	}
	
	/**
	 * Sets this contact's gender
	 *
	 * @param string $gender The contact's gender
	 * @return void
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * Returns the contact's gender
	 *
	 * @return string The contact's gender
	 */
	public function getGender() {
		return $this->gender;
	}
	
	/**
	 * Sets this contact's first_name
	 *
	 * @param string $name The contact's first_name
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns the contact's name
	 *
	 * @return string The contact's name
	 */
	public function getFirstName() {
		return $this->firstName;
	}
	
	/**
	 * Sets this contact's last_name
	 *
	 * @param string $last_name The contact's last_name
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Returns the contact's last_name
	 *
	 * @return string The contact's last_name
	 */
	public function getLastName() {
		return $this->lastName;
	}
	
	/**
	 * Sets the contact's marital status
	 * 
	 * @param  integer	the contact's marital status
	 * @return void
	 */
	public function setMaritalStatus($maritalStatus) {
		$this->maritalStatus = $maritalStatus;
	}
	
	/**
	 * Returns the contact's marital status
	 * 
	 * @return integer the contact's marital status
	 */
	public function getMaritalStatus() {
		return $this->maritalStatus;
	}
	
	/**
	 * Sets this contact's title
	 *
	 * @param string $title The contact's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the contact's title
	 *
	 * @return string The contact's title
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Sets this contact's birthday
	 *
	 * @param DateTime $birthday The contact's birthday
	 * @return void
	 */
	public function setBirthday(DateTime $birthday) {
		$this->birthday = $birthday;
	}

	/**
	 * Returns the contact's birthday
	 *
	 * @return DateTime
	 */
	public function getBirthday() {
		return $this->birthday;
	}
	
	/**
	 * Sets this contact's email address
	 *
	 * @param string $email The contact's email address
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * Returns the contact's email address
	 *
	 * @return string The contact's email address
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets this contact's phone number
	 *
	 * @param string $phone The contact's phone number
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the contact's phone number
	 *
	 * @return string The contact's phone number
	 */
	public function getPhone() {
		return $this->phone;
	}
	
	/**
	 * Sets this contact's mobile
	 *
	 * @param string $mobile The contact's mobile number
	 * @return void
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
	}

	/**
	 * Returns the contact's mobile phone number
	 *
	 * @return string The contact's mobile phone number
	 */
	public function getMobile() {
		return $this->mobile;
	}

	/**
	 * Sets this contact's web address
	 *
	 * @param string $www The contact's web address
	 * @return void
	 */
	public function setWww($www) {
		$this->www = $www;
	}

	/**
	 * Returns the contact's web address
	 *
	 * @return string The contact's web address
	 */
	public function getWww() {
		return $this->www;
	}	
	
	/**
	 * Sets this contact's address (street and number)
	 *
	 * @param string $address The contact's address
	 * @return void
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	/**
	 * Returns the contact's address
	 *
	 * @return string The contact's address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets this contact's company
	 *
	 * @param string $company The contact's company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the contact's company
	 *
	 * @return string The contact's company
	 */
	public function getCompany() {
		return $this->company;
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
	 * Sets this contact's city
	 *
	 * @param string $city The contact's city
	 * @return void
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * Returns the contact's city
	 *
	 * @return string The contact's city
	 */
	public function getCity() {
		return $this->city;
	}	

	/**
	 * Sets this contact's zip code
	 *
	 * @param string $zip The contact's zip code
	 * @return void
	 */
	public function setZip($zip) {
		$this->zip = $zip;
	}

	/**
	 * Returns the contact's zip code
	 *
	 * @return string The contact's zip code
	 */
	public function getZip() {
		return $this->zip;
	}
	
	/**
	 * Sets this contact's country
	 *
	 * @param string $country The contact's country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the contact's country
	 *
	 * @return string The contact's country
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * Sets the contact's preferred_language
	 * 
	 * @param  string the contact's preferred_language
	 * @return void
	 */
	public function setPreferredLanguage($preferredLanguage) {
		$this->preferredLanguage = $preferredLanguage;
	}
	
	/**
	 * Returns the contact's marital preferred_language
	 * 
	 * @return string the contact's preferred_language
	 */
	public function getPreferredLanguage() {
		return $this->preferredLanguage;
	}

	/**
	 * Sets this contact's image
	 *
	 * @param string $image The contact's image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the contact's image
	 *
	 * @return string The contact's image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets this contact's fax number
	 *
	 * @param string $fax The contact's fax number
	 * @return void
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * Returns the contact's fax number
	 *
	 * @return string The contact's fax number
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * Sets the description for the contact
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Sets the addressgroups for the contact
	 *
	 * @param array $addressgroups
	 * @return void
	 */
	public function setAddressgroups(array $addressgroups) {
		foreach ($addressgroups as $addressgroup) {
			$this->addAddressgroup($addressgroup);			
		}
	}

	/**
	 * Returns the addressgroups
	 *
	 * @return string
	 */
	public function getAddressgroups() {
		return $this->addressgroups;
	}
	
	/**
	 * Adds a addressgroup to this contact
	 *
	 * @param Tx_Addresses_Domain_Model_Addressgroup $addressgroup
	 * @return void
	 */
	public function addAddressgroup(Tx_Addresses_Domain_Model_Addressgroup $addressgroup) {
		$this->addressgroups[] = $addressgroup;
	}

	/**
	 * Returns this address as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->firstName . ' ' . $this->lastName;
	}
}
?>