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
 * A single addressgroup
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Addressgroup extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * The addressgroups title
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * The addressgroups description
	 *
	 * @var string
	 */
	protected $description = '';


	/**
	 * Constructs this addressgroup
	 *
	 * @return
	 */
	public function __construct() {
	}
	
	/**
	 * Sets this addressgroups title
	 *
	 * @param string $title The addressgroups title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the addressgroups title
	 *
	 * @return string The addressgroups title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the description for the addressgroup
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
	 * Returns this addressgroup as a formatted string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->title;
	}
}
?>