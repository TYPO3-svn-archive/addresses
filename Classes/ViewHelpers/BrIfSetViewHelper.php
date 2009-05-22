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
class Tx_Addresses_ViewHelpers_BrIfSetViewHelper extends Tx_Fluid_Core_AbstractViewHelper {


	/**
	 * renders <f:then> child if $condition is true, otherwise renders <f:else> child.
	 *
	 * @param  string asdas
	 * @return string the rendered string
	 * @author Sebastian Kurfürst <sebastian@typo3.org>
	 * @author Bastian Waidelich <bastian@typo3.org>
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
