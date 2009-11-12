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
class Tx_Addresses_Domain_Repository_AddressRepository extends Tx_Extbase_Persistence_Repository {
	/**
	 * Find all objects up to a certain limit with a given offset and a sorting order
	 *
	 * @param int $limit The maximum items to be displayed at once
	 * @param int $offset The offset (where to start)
	 * @param string $sortBy Field to sort the result set
	 * @return array An array of objects, an empty array if no objects found
	 */
	public function findLimit($limit, $offset, $sortBy='last_name') {
		$query = $this->createQuery();
		return  $query->setOrderings(array($sortBy => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING))
			->setLimit($limit)
			->setOffset($offset)
			->execute();
	}
	
	/**
	 * Find the count of all objects
	 *
	 * @return array An array of objects, an empty array if no objects found
	 */
	public function findTotal() {
		$query = $this->createQuery();
		return  $query->count();
	}
	/**
	 * Fetch objects with a certain group (doesn't work, don't know how to get mm_query)
	 * 
	 * @return array An array of objects, an empty array if no objects found
	 * @param int $group The ID of the group(s) to fetch records from
	 * @param string $limit[optional] The limit string (like 0,5) 
	 */
	public function findWithGroups($groups, $limit=NULL, $sortBy='last_name') {

		$select = 'tx_addresses_domain_model_address.uid';
		$local_table = 'tx_addresses_domain_model_address';
		$mm_table = 'tx_addresses_address_addressgroup_mm';
		$foreign_table = 'tx_addresses_domain_model_addressgroup';
		$whereClause = 'AND tx_addresses_domain_model_addressgroup.uid IN (' . $groups . ')';
		
		//$res = $GLOBALS['TYPO3_DB']->exec_SELECT_mm_query($select,$local_table,$mm_table,$foreign_table,$whereClause,'',$sortBy,$limit); 
		
		$rows = Array();
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$rows[] = $row['uid'];	
		}
		$foundAddressesList = implode(',', $rows);
		//return $this->findWhere('uid IN (' . $foundAddressesList . ')', '', $sortBy);
	}
	


}
?>