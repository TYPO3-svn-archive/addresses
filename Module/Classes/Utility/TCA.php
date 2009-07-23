<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Fabien Udriot <fabien.udriot@ecodev.ch>
*  All rights reserved
*
*  This class is a backport of the corresponding class of FLOW3. 
*  All credits go to the v5 team.
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
 * Utilities to manage the TCA of an extension
 *
 * @package Addresses
 * @subpackage addresses
 * @version $ID:$
 */
class Tx_Addresses_Utility_TCA {

	/**
	 *
	 * @var array
	 */
	protected static $TCA = array();

	/**
	 * Returns the TCA of Addresses.
	 * 
	 * @return	array
	 */
	public static function getTCA($namespace) {
		global $TCA;
		if (empty(self::$TCA['tx_addresses_domain_model_' . strtolower($namespace)])) {
			t3lib_div::loadTCA('tx_addresses_domain_model_' . strtolower($namespace));
			self::$TCA['tx_addresses_domain_model_' . strtolower($namespace)] = $TCA['tx_addresses_domain_model_' . strtolower($namespace)];
		}
		return self::$TCA['tx_addresses_domain_model_' . strtolower($namespace)];
	}

	/**
	 * Returns the fields of the grid
	 * @return array
	 */
	public static function getFieldsGrid($namespace) {
		$TCA = self::getTCA($namespace);
		return $TCA['interface']['showGridFieldList'];
	}

	/**
	 * Returns the fields of the grid
	 * @return array
	 */
	public static function getColumns($namespace) {
		$TCA = self::getTCA($namespace);
		return $TCA['columns'];
	}

	/**
	 * Returns the fields of the grid
	 * @return array
	 */
	public static function getShowItems($namespace) {
		$TCA = self::getTCA($namespace);
		return $TCA['types']['module']['showitem'];
	}
}
?>