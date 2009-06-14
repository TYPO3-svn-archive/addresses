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
class Tx_Addresses_ViewHelpers_PagebrowserViewHelper extends Tx_Fluid_Core_ViewHelper_TagBasedViewHelper {
	
	/**
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Constructs this pagebrowser Helper
	 */
	public function __construct() {
	}

	/**
	 * renders a pagebrowser
	 *
	 * @param  int The total item count for calculating the page count
	 * @param  int The maximum amount of items to show per page
	 * @param  string The label for the "previous" link, taken from locallang
	 * @param  string The text in front of the current page count ("Page 3" [see next param])
	 * @param  string The text between the current page and the total page count ("3 out of 6")
	 * @param  string The label for the "next" link, taken from locallang
	 * @return string the rendered string
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
public function render($totalCountOfAddresses=NULL,$maxAddressesToDisplay=5, $previousLabel='previous', $pageLabel='Page', $outOfLabel='out of', $nextLabel='next') {

	$pagesTotal = ceil($totalCountOfAddresses/$maxAddressesToDisplay);
	if($this->controllerContext->getRequest()->hasArgument('currentPage')) {
		$currentPage = $this->controllerContext->getRequest()->getArgument('currentPage');
	} else {
		$currentPage = 0;
	}
	if(($currentPage+1) == $pagesTotal) {
		$next = $nextLabel;
	} else {
		$next = $this->getLink(($currentPage+1), $nextLabel);
	}
	if($currentPage == 0) {
		$previous = $previousLabel;
	} else {
		$previous = $this->getLink(($currentPage-1), $previousLabel);
	}

	$content = $previous . ' ' . $pageLabel . ' ' . ($currentPage+1)  . ' ' . $outOfLabel . ' ' . $pagesTotal . ' ' . $next;
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
		$URIBuilder = $this->controllerContext->getURIBuilder();
		//$uri = $URIBuilder->URIFor($GLOBALS['TSFE']->id, 'index', Array('currentPage' => $page), $controllerName = NULL, $extensionName = NULL, $pluginName = NULL, $pageType = 0, $noCache = FALSE, $useCacheHash = TRUE, $section = '', $linkAccessRestrictedPages = FALSE, $additionalParams = '');
		$uri = $URIBuilder->URIFor($GLOBALS['TSFE']->id, 'index', Array('currentPage' => $page));
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($linktext);

		return $this->tag->render(); 
	}
	
}

?>