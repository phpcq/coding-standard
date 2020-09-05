<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *     2014-2020 Christian Schiffler, Tristan Lins
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
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *             2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @link       https://github.com/phpcq/coding-standard
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @filesource
 */

namespace PhpCodeQuality\CodingStandard\Test\PhpCodeQuality\Strings;

use PhpCodeQuality\CodingStandard\Test\AbstractSniffUnitTest;

/**
 * Unit test class for the UnnecessaryStringConcat sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 */
class UnnecessaryStringConcatUnitTest extends AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='UnnecessaryStringConcatUnitTest.inc')
    {
        switch ($testFile) {
        case 'UnnecessaryStringConcatUnitTest.inc':
            return [
                    2  => 1,
                    6  => 1,
                    9  => 1,
                    12 => 1,
                    21 => 4,
                    24 => 1,
            ];
        case 'UnnecessaryStringConcatUnitTest.js':
            return [
                    1  => 1,
                    8  => 1,
                    11 => 1,
                    16 => 4,
                    19 => 1,
            ];
        default:
            return [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='UnnecessaryStringConcatUnitTest.inc')
    {
        return [];
    }
}
