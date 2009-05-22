<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 3 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @package addresses
 * @subpackage ViewHelpers
 * @version $Id:$
 */
require_once(t3lib_extMgm::extPath('extbase', 'Tests/Base_testcase.php'));
class Tx_Addresses_ViewHelpers_Format_BrIfSetViewHelperTest_testcase extends Tx_Extbase_Base_testcase {

	/**
	 * @test
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
	public function test_viewHelperDoesReturnNothingIfValueIsNotSet() {
		$viewHelper = $this->getMock('Tx_Addresses_ViewHelpers_BrIfSetViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue(''));
		$actualResult = $viewHelper->render();
		$this->assertEquals('', $actualResult);
	}

	/**
	 * @test
	 * @author Susanne Moog <typo3@susanne-moog.de>
	 */
	public function test_viewHelperInsertsBrTagIfValueIsSet() {
		$viewHelper = $this->getMock('Tx_Addresses_ViewHelpers_BrIfSetViewHelper', array('renderChildren'));
		$viewHelper->expects($this->once())->method('renderChildren')->will($this->returnValue('some text'));
		$actualResult = $viewHelper->render('test');
		$this->assertEquals('some text<br />', $actualResult);
	}
}
?>
