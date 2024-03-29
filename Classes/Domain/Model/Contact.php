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
 * Abstract base class for contacts (possible children: person, organization)
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Contact extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The contact's type
	 *
	 * @var string
	 */
	protected $type = '';
	
	/**
	 * The contact's tags
	 *
	 * @var array
	 */
	protected $tags = array();
	
	/**
	 * The email addresses
	 *
	 * @var array
	 */
	protected $emailAddresses = array();
	
	/**
	 * The website address
	 *
	 * @var array
	 */
	protected $websites = array();

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
	 * Returns the contact's tags
	 *
	 * @return array The contact's tags
	 */
	public function addTag($tag) {
		$this->tags[] = $tag;
	}

}
?>