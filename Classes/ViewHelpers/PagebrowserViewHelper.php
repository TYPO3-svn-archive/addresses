<?php

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package addresses
 * @subpackage ViewHelpers
 * @version $Id: $
 */

/**
 * This view helper implements a pagebrowser
 *
 * @package addresses
 * @subpackage ViewHelpers
 * @version $Id: $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 */
class Tx_Addresses_ViewHelpers_PagebrowserViewHelper extends Tx_Fluid_Core_AbstractViewHelper {
	
	/**
	 * An instance of tslib_cObj
	 *
	 * @var	tslib_cObj
	 */
	protected $contentObject;

	/**
	 * Constructs this pagebrowser Helper
	 */
	public function __construct() {
		$this->contentObject = t3lib_div::makeInstance('tslib_cObj');
	}

	/**
	 * renders a pagebrowser
	 *
	 * @param  int The total item count for calculating the page count
	 * @param  int The maximum amount of items to show per page
	 * @return string the rendered string
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
	public function render($items=NULL,$max=5) {
		$pagesTotal = ceil($items/$max);
		$currentPage = $_GET['tx_addresses_pi1']['page']+1;
		if($currentPage == $pagesTotal) {
			$next = 'next';
		} else {
			$next = $this->getLink($_GET['tx_addresses_pi1']['page']+1, 'next');
		}
		if($_GET['tx_addresses_pi1']['page'] == 0) {
			$previous = 'previous';
		} else {
			$previous = $this->getLink(($currentPage-2), 'previous');
		}

//debug($this->variableContainer->get('view')->getViewHelper('Tx_Fluid_ViewHelpers_TranslateViewHelper'));
	
		$content = $previous . ' Page ' . $currentPage  . ' out of ' . $pagesTotal . ' ' . $next;
		return $content;
	}
	
	/**
	 * Uses the typolink function to return a link with the corresponding GET-parameter for page browsing
	 * 
	 * @return string returns an a-tag with a link to the same page and an additional parameter for the pagebrowser
	 * @param int $page = the page to be linked by the pagebrowser (f.e. the next or previous page)
	 * @param string the text of the link (<a>text</a>)
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
	private function getLink($page,$linktext='') {
		$typolinkConfiguration = Array(
			'parameter' => $GLOBALS['TSFE']->id,
			'additionalParams' => '&tx_addresses_pi1[page]=' . $page
		);

		return $this->contentObject->typolink($linktext, $typolinkConfiguration);
	}
	
}

?>
