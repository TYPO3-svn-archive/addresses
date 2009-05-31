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
 * This view helper implements an br at the end of the input in case the input is set.
 *
 * @package addresses
 * @subpackage ViewHelpers
 * @version $Id: $
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 2
 * @scope prototype
 */
class Tx_Addresses_ViewHelpers_BrIfSetViewHelper extends Tx_Fluid_Core_ViewHelper_TagBasedViewHelper {


	/**
	 * renders a <br /> after the content, if the content is not empty
	 *
	 * @param  string the variable to be checked - if it contains content, the <br /> is rendered
	 * @return string the rendered string
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
	public function render($key='') {
		$content = $this->renderChildren();
		if($key) {
			$content = $content . '<br />';
		} else {
			$content = '';
		}
		return $content;
	}
}

?>
