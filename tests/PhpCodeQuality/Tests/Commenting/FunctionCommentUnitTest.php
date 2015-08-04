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
 * Unit test class for FunctionCommentSniff.
 */
class PhpCodeQuality_Tests_Commenting_FunctionCommentUnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='FunctionCommentUnitTest.inc')
    {
        return array(
                 8  => 1,
                10  => 2,
                12  => 2,
                13  => 2,
                14  => 1,
                15  => 1,
                28  => 1,
                35  => 2,
                38  => 1,
                41  => 1,
                53  => 1,
                103 => 1,
                109 => 1,
                112 => 2,
                122 => 1,
                123 => 3,
                124 => 3,
                125 => 4,
                126 => 6,
                139 => 1,
                155 => 1,
                165 => 1,
                172 => 1,
                183 => 2,
                193 => 2,
                204 => 1,
                218 => 1,
                234 => 1,
                240 => 1,
                241 => 1,
               );

    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='FunctionCommentUnitTest.inc')
    {
        return array();

    }
}
