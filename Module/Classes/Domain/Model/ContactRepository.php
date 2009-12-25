<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Fabien Udriot <fabien.udriot@ecodev.ch>
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
 * Model class for the 'addresses' extension.
 *
 * @author	Fabien Udriot <fabien.udriot@ecodev.ch>
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @package	TYPO3
 * @subpackage	tx_addresses
 * @version $Id$
 */

class Tx_Addresses_Domain_Model_ContactRepository extends Tx_Addresses_Domain_Model_RepositoryAbstract {

	/**
	 *
	 * @var string
	 */
	protected $namespace = 'Contact';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct($this->namespace);
	}

	/**
	 * Get addresses for the grid
	 *
	 * @return	string
	 */
	public function findAll() {
		return parent::findAll();
	}

	/**
	 * Get address(es) for the grid
	 *
	 * @param array $data: the uid of the contact
	 * @return	array
	 */
	public function findById($dataSet) {
		return parent::findById($dataSet);
	}

	/**
	 * Delete the contact(s)
	 *
	 * @param array $data: the uid of the contact(s)
	 * @return	boolean
	 */
	public function delete($dataSet) {
		return parent::delete($dataSet);
	}

	/**
	 * Save contact(es): UPDATE or INSERT depending on the uid
	 *
	 * @param	array	$values
	 * @return	array
	 */
	public function save($dataSet) {
		return parent::save($dataSet);
	}
}

?>