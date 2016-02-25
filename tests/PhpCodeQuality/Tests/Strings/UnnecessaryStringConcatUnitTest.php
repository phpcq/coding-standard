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
 * Unit test class for the UnnecessaryStringConcat sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 */
class PhpCodeQuality_Tests_Strings_UnnecessaryStringConcatUnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='UnnecessaryStringConcatUnitTest.inc')
    {
        switch ($testFile) {
        case 'UnnecessaryStringConcatUnitTest.inc':
            return array(
                    2  => 1,
                    6  => 1,
                    9  => 1,
                    12 => 1,
                    21 => 4,
                    24 => 1,
                   );
        case 'UnnecessaryStringConcatUnitTest.js':
            return array(
                    1  => 1,
                    8  => 1,
                    11 => 1,
                    16 => 4,
                    19 => 1,
                   );
        default:
            return array();
        }
    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList($testFile='UnnecessaryStringConcatUnitTest.inc')
    {
        return array();

    }
}
