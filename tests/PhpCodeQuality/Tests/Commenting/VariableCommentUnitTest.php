<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *     2014-2015 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE.BSD-3-CLAUSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Greg Sherwood <gsherwood@squiz.net>
 * @author     Marc McIntyre <mmcintyre@squiz.net>
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan@lins.io>
 * @copyright  2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *             2014-2015 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @link       https://github.com/phpcq/coding-standard
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @filesource
 */

/**
 * Unit test class for VariableCommentSniff.
 */
class PhpCodeQuality_Tests_Commenting_VariableCommentUnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return array(
                6   => 1,
                8   => 1,
                21  => 1,
                24  => 1,
                28  => 1,
                38  => 1,
                41  => 1,
                53  => 1,
                56  => 1,
                63  => 1,
                64  => 1,
                69  => 2,
                73  => 1,
                81  => 1,
                82  => 1,
                84  => 1,
                90  => 1,
                92  => 1,
                128 => 1,
                145 => 1,
                153 => 1,
                158 => 1,
                159 => 1,
                163 => 1,
                178 => 1,
                180 => 1,
                184 => 1,
               );

    }//end getErrorList()


    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return array(
                93 => 1,
               );

    }//end getWarningList()


}//end class

?>
