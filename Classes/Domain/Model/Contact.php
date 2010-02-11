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
 * A single contact
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Contact extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The contact's gender
	 *
	 * @var string
	 */
	protected $gender = '';

	/**
	 * The contact's status
	 *
	 * @var int
	 */
	protected $status = '';

	/**
	 * The contact's type
	 *
	 * @var int
	 */
	protected $type = '';

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
	 * A contact's birthDate
	 *
	 * @var DateTime
	 */
	protected $birthDate = '';

	/**
	 * A contact's birthPlace
	 *
	 * @var string
	 */
	protected $birthPlace = '';

	/**
	 * A contact's deathDate
	 *
	 * @var DateTime
	 */
	protected $deathDate = '';

	/**
	 * A contact's deathPlace
	 *
	 * @var string
	 */
	protected $deathPlace = '';

	/**
	 * A contact's nationality
	 *
	 * @var string
	 */
	protected $nationality = '';

	/**
	 * A contact's religion
	 *
	 * @var string
	 */
	protected $religion = '';

	/**
	 * A contact's orgType
	 *
	 * @var string
	 */
	protected $orgType = '';

	/**
	 * A contact's orgName
	 *
	 * @var string
	 */
	protected $orgName = '';

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
	 * The website address
	 *
	 * @var string
	 */
	protected $website = '';

	/**
	 * The address
	 *
	 * @var string
	 */
	protected $address = '';

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
	 * The locality
	 *
	 * @var string
	 */
	protected $locality = '';

	/**
	 * The postalCode code
	 *
	 * @var string
	 */
	protected $postalCode = '';

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
	 * The remarks of the contact
	 *
	 * @var string
	 */
	protected $remarks = '';

	/**
	 * The groups of the contact
	 *
	 * @var array
	 */
	protected $groups = array();

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
	 * Sets this contact's status
	 *
	 * @param string $status The contact's status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the contact's status
	 *
	 * @return string The contact's status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets this contact's type
	 *
	 * @param string $type The contact's type
	 * @return void
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * Returns the contact's type
	 *
	 * @return string The contact's type
	 */
	public function getType() {
		return $this->type;
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
	 * Sets this contact's birthDate
	 *
	 * @param DateTime $birthDate The contact's birthDate
	 * @return void
	 */
	public function setBirthDate(DateTime $birthDate) {
		$this->birthDate = $birthDate;
	}

	/**
	 * Returns the contact's birthDate
	 *
	 * @return DateTime
	 */
	public function getBirthDate() {
		return $this->birthDate;
	}

	/**
	 * Sets this contact's bearthPlace
	 *
	 * @param string $bearthPlace The contact's bearthPlace
	 * @return void
	 */
	public function setBearthPlace(DateTime $bearthPlace) {
		$this->bearthPlace = $bearthPlace;
	}

	/**
	 * Returns the contact's bearthPlace
	 *
	 * @return string
	 */
	public function getBearthPlace() {
		return $this->bearthPlace;
	}

	/**
	 * Sets this contact's deathDate
	 *
	 * @param DateTime $deathDate The contact's deathDate
	 * @return void
	 */
	public function setDeathDate(DateTime $deathDate) {
		$this->deathDate = $deathDate;
	}

	/**
	 * Returns the contact's deathDate
	 *
	 * @return DateTime
	 */
	public function getDeathDate() {
		return $this->deathDate;
	}

	/**
	 * Sets this contact's deathPlace
	 *
	 * @param string $deathPlace The contact's deathPlace
	 * @return void
	 */
	public function setDeathPlace(DateTime $deathPlace) {
		$this->deathPlace = $deathPlace;
	}

	/**
	 * Returns the contact's deathPlace
	 *
	 * @return string
	 */
	public function getDeathPlace() {
		return $this->deathPlace;
	}

	/**
	 * Sets this contact's nationality
	 *
	 * @param string $nationality The contact's nationality
	 * @return void
	 */
	public function setNationality(DateTime $nationality) {
		$this->nationality = $nationality;
	}

	/**
	 * Returns the contact's nationality
	 *
	 * @return string
	 */
	public function getNationality() {
		return $this->nationality;
	}

	/**
	 * Sets this contact's religion
	 *
	 * @param string $religion The contact's religion
	 * @return void
	 */
	public function setReligion(DateTime $religion) {
		$this->religion = $religion;
	}

	/**
	 * Returns the contact's religion
	 *
	 * @return string
	 */
	public function getReligion() {
		return $this->religion;
	}

	/**
	 * Sets this contact's orgType
	 *
	 * @param string $orgType The contact's orgType
	 * @return void
	 */
	public function setOrgType(DateTime $orgType) {
		$this->orgType = $orgType;
	}

	/**
	 * Returns the contact's orgType
	 *
	 * @return string
	 */
	public function getOrgType() {
		return $this->orgType;
	}

	/**
	 * Sets this contact's orgName
	 *
	 * @param string $orgName The contact's orgName
	 * @return void
	 */
	public function setOrgName(DateTime $orgName) {
		$this->orgName = $orgName;
	}

	/**
	 * Returns the contact's orgName
	 *
	 * @return string
	 */
	public function getOrgName() {
		return $this->orgName;
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
	 * Sets this contact's website address
	 *
	 * @param string $website The contact's website address
	 * @return void
	 */
	public function setWebsite($website) {
		$this->website = $website;
	}

	/**
	 * Returns the contact's website address
	 *
	 * @return string The contact's website address
	 */
	public function getWebsite() {
		return $this->website;
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
	 * Sets this contact's street
	 *
	 * @param string $street The contact's street
	 * @return void
	 */
	public function setStreet($street) {
		$this->street = $street;
	}

	/**
	 * Returns the contact's street
	 *
	 * @return string The contact's street
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * Sets this contact's streetNumber
	 *
	 * @param string $streetNumber The contact's street
	 * @return void
	 */
	public function setStreetNumber($streetNumber) {
		$this->streetNumber = $streetNumber;
	}

	/**
	 * Returns the contact's streetNumber
	 *
	 * @return string The contact's streetNumber
	 */
	public function getStreetNumber() {
		return $this->streetNumber;
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
	 * Sets this contact's locality
	 *
	 * @param string $locality The contact's locality
	 * @return void
	 */
	public function setLocality($locality) {
		$this->locality = $locality;
	}

	/**
	 * Returns the contact's locality
	 *
	 * @return string The contact's locality
	 */
	public function getLocality() {
		return $this->locality;
	}

	/**
	 * Sets this contact's postalCode code
	 *
	 * @param string $postalCode The contact's postalCode code
	 * @return void
	 */
	public function setPostalCode($postalCode) {
		$this->postalCode = $postalCode;
	}

	/**
	 * Returns the contact's postalCode code
	 *
	 * @return string The contact's postalCode code
	 */
	public function getPostalCode() {
		return $this->postalCode;
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
	 * Sets the remarks for the contact
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
	 * Sets the groups for the contact
	 *
	 * @param array $groups
	 * @return void
	 */
	public function setGroups(array $groups) {
		foreach ($groups as $group) {
			$this->addGroup($group);
		}
	}

	/**
	 * Returns the groups
	 *
	 * @return string
	 */
	public function getGroups() {
		return $this->groups;
	}

	/**
	 * Adds a group to this contact
	 *
	 * @param Tx_Addresses_Domain_Model_Group $group
	 * @return void
	 */
	public function addGroup(Tx_Addresses_Domain_Model_Group $group) {
		$this->groups[] = $group;
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