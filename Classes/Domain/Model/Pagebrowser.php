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
 * A pagebrowser
 *
 * @version $Id:$
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 * @entity
 */
class Tx_Addresses_Domain_Model_Pagebrowser extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The total count of pages
	 *
	 * @var int
	 */
	protected $pages;

	/**
	 * The current page
	 *
	 * @var int
	 */
	protected $currentPage;

	/**
	 * The next page
	 *
	 * @var int
	 */
	protected $nextPage;
	
	/**
	 * Whether there is a next page
	 *
	 * @var int
	 */
	protected $next;

	/**
	 * The previous page
	 *
	 * @var boolean
	 */
	protected $previous;

	/**
	 * The previous page
	 *
	 * @var int
	 */
	protected $previousPage;

	
	/**
	 * Constructs this pageBrowser
	 *
	 * @return
	 */
	public function __construct() {
		
	}
	
	/**
	 * Sets the total page count
	 *
	 * @param int $pages The total page count
	 * @return void
	 */
	public function setPages($pages) {
		$this->pages = $pages;
	}

	/**
	 * Returns the total page count
	 *
	 * @return string The contact's name
	 */
	public function getPages() {
		return $this->pages;
	}
	
	/**
	 * Sets the current page
	 *
	 * @param int $currentPage The current page
	 * @return void
	 */
	public function setCurrentPage($currentPage) {
		$this->currentPage = $currentPage;
	}

	/**
	 * Returns the current page
	 *
	 * @return int The current page
	 */
	public function getCurrentPage() {
		return $this->currentPage;
	}
	
	/**
	 * Sets whether there is a next page
	 *
	 * @param boolean $next whether there is a next page
	 * @return void
	 */
	public function setNext($next) {
		$this->next = $next;
	}

	/**
	 * Returns whether there is a next page
	 *
	 * @return boolean whether there is a next page
	 */
	public function getNext() {
		return $this->next;
	}		
	
	/**
	 * Sets the next page
	 *
	 * @param int $next The next page
	 * @return void
	 */
	public function setNextPage($nextPage) {
		$this->nextPage = $nextPage;
	}

	/**
	 * Returns the next page
	 *
	 * @return int The next page
	 */
	public function getNextPage() {
		return $this->nextPage;
	}	
	
	/**
	 * Sets whether there is a previous page
	 *
	 * @param boolean $previous whether there is a previous page
	 * @return void
	 */
	public function setPrevious($previous) {
		$this->previous = $previous;
	}

	/**
	 * Returns whether there is a previous page
	 *
	 * @return boolean whether there is a previous page
	 */
	public function getPrevious() {
		return $this->previous;
	}
	
	/**
	 * Sets the previous page
	 *
	 * @param int $previousPage The previous page
	 * @return void
	 */
	public function setPreviousPage($previousPage) {
		$this->previousPage = $previousPage;
	}

	/**
	 * Returns the previous page
	 *
	 * @return int The previous page
	 */
	public function getPreviousPage() {
		return $this->previousPage;
	}

	/**
	 * Returns the current page as string
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->currentPage;
	}
}
?>