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
 * A single person
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Person extends Tx_Addresses_Domain_Model_Contact {

	/**
	 * The person's gender
	 *
	 * @var string
	 */
	protected $type = 'person';
	
	/**
	 * The person's gender
	 *
	 * @var string
	 */
	protected $gender = '';

	/**
	 * The person's status
	 *
	 * @var int
	 */
	protected $status = '';

	/**
	 * The person's first_name
	 *
	 * @var string
	 */
	protected $firstName = '';

	/**
	 * The person's last_name
	 *
	 * @var string
	 */
	protected $lastName = '';

	/**
	 * The person's marital status
	 *
	 * @var string marital_status
	 */

	protected $maritalStatus = '';

	/**
	 * A person's title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * A person's birthDate
	 *
	 * @var DateTime
	 */
	protected $birthDate = '';

	/**
	 * A person's birthPlace
	 *
	 * @var string
	 */
	protected $birthPlace = '';

	/**
	 * A person's deathDate
	 *
	 * @var DateTime
	 */
	protected $deathDate = '';

	/**
	 * A person's deathPlace
	 *
	 * @var string
	 */
	protected $deathPlace = '';

	/**
	 * A person's nationality
	 *
	 * @var string
	 */
	protected $nationality = '';

	/**
	 * A person's religion
	 *
	 * @var string
	 */
	protected $religion = '';


	/**
	 * The company
	 *
	 * @var string
	 */
	protected $company = '';

	/**
	 * The address
	 *
	 * @var string
	 */
	protected $address = '';

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
	 * The remarks of the contact
	 *
	 * @var string
	 */
	protected $remarks = '';

	/**
	 * Constructs this address
	 *
	 * @return
	 */
	public function __construct() {

	}

	/**
	 * Sets this person's gender
	 *
	 * @param string $gender The person's gender
	 * @return void
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	/**
	 * Returns the person's gender
	 *
	 * @return string The person's gender
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * Sets this person's status
	 *
	 * @param string $status The person's status
	 * @return void
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * Returns the person's status
	 *
	 * @return string The person's status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets this person's first_name
	 *
	 * @param string $name The person's first_name
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns the person's name
	 *
	 * @return string The person's name
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Sets this person's last_name
	 *
	 * @param string $last_name The person's last_name
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

	/**
	 * Returns the person's last_name
	 *
	 * @return string The person's last_name
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Sets the person's marital status
	 *
	 * @param  integer	the person's marital status
	 * @return void
	 */
	public function setMaritalStatus($maritalStatus) {
		$this->maritalStatus = $maritalStatus;
	}

	/**
	 * Returns the person's marital status
	 *
	 * @return integer the person's marital status
	 */
	public function getMaritalStatus() {
		return $this->maritalStatus;
	}

	/**
	 * Sets this person's title
	 *
	 * @param string $title The person's title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the person's title
	 *
	 * @return string The person's title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets this person's birthDate
	 *
	 * @param DateTime $birthDate The person's birthDate
	 * @return void
	 */
	public function setBirthDate(DateTime $birthDate) {
		$this->birthDate = $birthDate;
	}

	/**
	 * Returns the person's birthDate
	 *
	 * @return DateTime
	 */
	public function getBirthDate() {
		return $this->birthDate;
	}

	/**
	 * Sets this person's birthPlace
	 *
	 * @param string $birthPlace The person's birthPlace
	 * @return void
	 */
	public function setBirthPlace($birthPlace) {
		$this->birthPlace = $birthPlace;
	}

	/**
	 * Returns the person's birthPlace
	 *
	 * @return string
	 */
	public function getBirthPlace() {
		return $this->birthPlace;
	}

	/**
	 * Sets this person's deathDate
	 *
	 * @param DateTime $deathDate The person's deathDate
	 * @return void
	 */
	public function setDeathDate(DateTime $deathDate) {
		$this->deathDate = $deathDate;
	}

	/**
	 * Returns the person's deathDate
	 *
	 * @return DateTime
	 */
	public function getDeathDate() {
		return $this->deathDate;
	}

	/**
	 * Sets this person's deathPlace
	 *
	 * @param string $deathPlace The person's deathPlace
	 * @return void
	 */
	public function setDeathPlace($deathPlace) {
		$this->deathPlace = $deathPlace;
	}

	/**
	 * Returns the person's deathPlace
	 *
	 * @return string
	 */
	public function getDeathPlace() {
		return $this->deathPlace;
	}

	/**
	 * Sets this person's nationality
	 *
	 * @param string $nationality The person's nationality
	 * @return void
	 */
	public function setNationality($nationality) {
		$this->nationality = $nationality;
	}

	/**
	 * Returns the person's nationality
	 *
	 * @return string
	 */
	public function getNationality() {
		return $this->nationality;
	}

	/**
	 * Sets this person's religion
	 *
	 * @param string $religion The person's religion
	 * @return void
	 */
	public function setReligion($religion) {
		$this->religion = $religion;
	}

	/**
	 * Returns the person's religion
	 *
	 * @return string
	 */
	public function getReligion() {
		return $this->religion;
	}

	/**
	 * Sets this person's company
	 *
	 * @param string $company The person's company
	 * @return void
	 */
	public function setCompany($company) {
		$this->company = $company;
	}

	/**
	 * Returns the person's company
	 *
	 * @return string The person's company
	 */
	public function getCompany() {
		return $this->company;
	}

	/**
	 * Sets the person's preferred_language
	 *
	 * @param  string the person's preferred_language
	 * @return void
	 */
	public function setPreferredLanguage($preferredLanguage) {
		$this->preferredLanguage = $preferredLanguage;
	}

	/**
	 * Returns the person's marital preferred_language
	 *
	 * @return string the person's preferred_language
	 */
	public function getPreferredLanguage() {
		return $this->preferredLanguage;
	}

	/**
	 * Sets this person's image
	 *
	 * @param string $image The person's image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
	}

	/**
	 * Returns the person's image
	 *
	 * @return string The person's image
	 */
	public function getImage() {
		return $this->image;
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