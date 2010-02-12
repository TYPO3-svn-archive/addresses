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
 * A single organization
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Organization extends Tx_Addresses_Domain_Model_Contact {
	
	/**
	 * The organization's type
	 *
	 * @var string
	 */
	protected $type = 'organization';	
	
	/**
	 * The organization's name
	 *
	 * @var string
	 */
	protected $name = '';
	
	/**
	 * The organization's sector
	 *
	 * @var string
	 */
	protected $sector = '';
	
	
	/**
	 * Sets this organization's name
	 *
	 * @param string $name The organization's name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Returns the organization's name
	 *
	 * @return string The organization's name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets this organization's sector
	 *
	 * @param string $sector The organization's sector
	 * @return void
	 */
	public function setSector($sector) {
		$this->sector = $sector;
	}

	/**
	 * Returns the organization's sector
	 *
	 * @return string The organization's sector
	 */
	public function getSector() {
		return $this->sector;
	}	
}
?>