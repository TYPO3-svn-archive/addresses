<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Susanne Moog <typo3@susanne-moog.de>
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
 * A tag
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @valueobject
 */
class Tx_Addresses_Domain_Model_Tag extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * @var string
	 */
	protected $name;
	
	/**
	 * The alternativeName
	 *
	 * @var string
	 */
	protected $alternativeName = '';
	
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

	/*
	 * Constructs this tag
	 */
	public function __construct() {
	}

	/**
	 * Setter for name
	 *
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns this tag's name
	 *
	 * @return string This tag's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this address's alternativeName
	 *
	 * @param string $alternativeName The address's alternativeName
	 * @return void
	 */
	public function setAlternativeName($alternativeName) {
		$this->alternativeName = $alternativeName;
	}

	/**
	 * Returns the address's alternativeName
	 *
	 * @return string The address's alternativeName
	 */
	public function getAlternativeName() {
		return $this->alternativeName;
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
	 * Returns this tag as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getName();
	}
}
?>