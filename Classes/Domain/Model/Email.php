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
 * A single email
 *
 * @version $Id: $
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @valueobject
 */
class Tx_Addresses_Domain_Model_Email extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * The uid of the parent contact
	 *
	 * @var Object
	 */
	protected $contact;

	/**
	 * The email address
	 *
	 * @var string
	 */
	protected $emailAddress = '';

	/**
	 * The remarks of the email address
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
	 * Sets the email address
	 *
	 * @param string $emailAddress The email address
	 * @return void
	 */
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}

	/**
	 * Returns the email address
	 *
	 * @return string the email address
	 */
	public function getEmailAddress() {
		return $this->emailAddress;
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
		return $this->emailAddress;
	}
}
?>