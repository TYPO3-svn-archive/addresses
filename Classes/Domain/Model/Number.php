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
 * A single number
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @valueobject
 */
class Tx_Addresses_Domain_Model_Number extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * The uid of the parent contact
	 *
	 * @var Object
	 */
	protected $contact;

	/**
	 * The type
	 *
	 * @var string
	 */
	protected $type = '';
	
	/**
	 * The nature
	 *
	 * @var string
	 */
	protected $nature = '';
	
	/**
	 * Is the number the default number?
	 *
	 * @var Bool
	 */
	protected $standard = FALSE;
	
	/**
	 * The label
	 *
	 * @var string
	 */
	protected $label = '';
	
	/**
	 * The country
	 *
	 * @var string
	 */
	protected $country = '';
	
	/**
	 * The area code
	 *
	 * @var string
	 */
	protected $areaCode = '';
	
	/**
	 * The number
	 *
	 * @var string
	 */
	protected $number = '';
	
	/**
	 * The extension
	 *
	 * @var string
	 */
	protected $extension = '';

	/**
	 * The remarks
	 *
	 * @var string
	 */
	protected $remarks = '';
	
	/**
	 * Sets the contact
	 *
	 * @param Tx_Addresses_Domain_Model_Contact $contact The contact
	 * @return void
	 */
	public function setContact(Tx_Addresses_Domain_Model_Contact $contact) {
		$this->contact = $contact;
	}

	/**
	 * Returns the contact
	 *
	 * @return Tx_Addresses_Domain_Model_Contact the contact
	 */
	public function getContact() {
		return $this->contact;
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
	 * Sets the nature
	 *
	 * @param string $nature The nature
	 * @return void
	 */
	public function setNature($nature) {
		$this->nature = $nature;
	}

	/**
	 * Returns the nature 
	 *
	 * @return string the nature
	 */
	public function getNature() {
		return $this->nature;
	}
	
	/**
	 * Sets the standard flag
	 *
	 * @param Bool $standard The standard
	 * @return void
	 */
	public function setStandard($standard) {
		$this->standard = $standard;
	}

	/**
	 * Returns the standard flag
	 *
	 * @return Bool the standard
	 */
	public function getStandard() {
		return $this->standard;
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
	 * Sets the country
	 *
	 * @param string $country The country
	 * @return void
	 */
	public function setCountry($country) {
		$this->country = $country;
	}

	/**
	 * Returns the country 
	 *
	 * @return string the country
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * Sets the areaCode
	 *
	 * @param string $areaCode The areaCode
	 * @return void
	 */
	public function setAreaCode($areaCode) {
		$this->areaCode = $areaCode;
	}

	/**
	 * Returns the areaCode 
	 *
	 * @return string the areaCode
	 */
	public function getAreaCode() {
		return $this->areaCode;
	}	
	
	/**
	 * Sets the number
	 *
	 * @param string $number The number
	 * @return void
	 */
	public function setNumber($number) {
		$this->number = $number;
	}

	/**
	 * Returns the number 
	 *
	 * @return string the number
	 */
	public function getNumber() {
		return $this->number;
	}
	
	/**
	 * Sets the extension
	 *
	 * @param string $extension The extension
	 * @return void
	 */
	public function setExtension($extension) {
		$this->extension = $extension;
	}

	/**
	 * Returns the extension 
	 *
	 * @return string the extension
	 */
	public function getExtension() {
		return $this->extension;
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
	 * Returns this address as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->website;
	}
}
?>