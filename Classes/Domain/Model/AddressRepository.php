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
 * A repository for Addresses
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 */
class Tx_Addresses_Domain_Model_AddressRepository extends Tx_Extbase_Persistence_Repository {
	/**
	 * Find all objects up to a certain limit with a given offset and a sorting order
	 *
	 * @param int $limit The maximum items to be displayed at once
	 * @param string $sortBy Field to sort the result set
	 * @return array An array of objects, an empty array if no objects found
	 */
	public function findLimit($limit,$sortBy='lastname') {
		//return $this->findWhere($where, $groupBy = '', $orderBy = '', $limit, $useEnableFields = TRUE);
		return $this->findWhere('', '', $sortBy, $limit);
	}
	/**
	 * Fetch objects with a certain group (doesn't work, don't know how to get mm_query)
	 * 
	 * @return array An array of objects, an empty array if no objects found
	 * @param int $group The ID of the group(s) to fetch records from
	 * @param string $limit[optional] The limit string (like 0,5) 
	 */
	public function findWithGroup($group, $limit=NULL) {
		$condition = Array('addressgroups' => $group);

		return $this->findByConditions($condition, '', '', $limit);
	}
	


}
?>