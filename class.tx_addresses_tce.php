<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2004 Fabien Udriot (fabien.udriot@ecodev.ch)
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
 * Class holding all functions to create user output
 * in TCE Forms for the extension 'addresses'
 *
 * @author Fabien Udriot <fabien.udriot@ecodev.ch>
 * @version $Id$
 */

class tx_addresses_tce {

	/**
	 * This function is called by the ['config']['userFunc']
	 * configuration in $TCA and creates the relationships overview.
	 *
	 * @param	array		$PA: The TYPO3 standard array
	 * @param	object		$fobj: An instance of the current TCE Forms Object
	 * @return	string		HTML for the relationships overview
	 */
	function getRecords($table, $field) {
		/* @var $TYPO3_DB t3lib_DB */
		global $TYPO3_DB;
		$_records = array();
		if (is_string($table) && is_string($field)) {
			$records = $TYPO3_DB->exec_SELECTgetRows('distinct(' . $field . ')', $table, 'deleted = 0 AND hidden = 0');
			// TRUE Means the uid of the option will be the same as the value
			if (!strpos($field, ',')) {
				foreach($records as $record) {
					$_records[] = array(
						$record[$field],
						$record[$field],
					);
				}
			}
			return $_records;
		}
	}
}
