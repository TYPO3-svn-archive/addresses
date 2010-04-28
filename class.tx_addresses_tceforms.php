<?php
/***************************************************************
*  Copyright notice
*
*  (c)  2009 Fabien Udriot (fabien.udriot@ecodev.ch)
*
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
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
 * TCE Form handling
 *
 * @category    Configuration
 * @package     TYPO3
 * @subpackage  addresses
 * @author Fabien Udriot <fabien.udriot@ecodev.ch>
 * @version $Id$
 */
class tx_addresses_tceforms {

	/**
	 * This method renders fields necessary for editing fe_user
	 *
	 * @param	array			$PA: information related to the field
	 * @param	t3lib_tceform	$fobj: reference to calling TCEforms object
	 *
	 * @return	string	The HTML for the form field
	 */
	public function renderFeUser($PA, $fobj) {
		$result = $this->getLL('tx_addresses_domain_model_person.fe_user_no_data');
		if ($PA['row']['fe_user'] != '') {
			$result = 'asdf';
		}
		return $result;
	}

	/**
	 * This method renders fields necessary for editing fe_user
	 *
	 * @param	array			$PA: information related to the field
	 * @param	t3lib_tceform	$fobj: reference to calling TCEforms object
	 *
	 * @return	string	The HTML for the form field
	 */
	public function renderBeUser($PA, $fobj) {
		$result = $this->getLL('tx_addresses_domain_model_person.be_user_no_data');
		if ($PA['row']['be_user'] > 0) {
			$result = 'asdf';
		}
		return $result;
	}

	/**
	 * Return the translated string according to the key
	 *
	 * @param string key of label
	 */
	private function getLL($key){
		$langReference = 'LLL:EXT:addresses/Resources/Private/Language/locallang_db.xml:';
		return $GLOBALS['LANG']->sL($langReference . $key);
	}
}

?>
