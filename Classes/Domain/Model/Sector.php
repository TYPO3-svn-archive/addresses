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
 * A single sector
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @valueobject
 */
class Tx_Addresses_Domain_Model_Sector extends Tx_Extbase_DomainObject_AbstractValueObject {

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
	 * The sector name
	 *
	 * @var string
	 */
	protected $name = '';
	
	/**
	 * Constructs this address
	 *
	 * @return
	 */
	public function __construct() {
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
	 * Sets the name
	 *
	 * @param string $name The name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the name
	 *
	 * @return string the name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Returns this address as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}
}
?>