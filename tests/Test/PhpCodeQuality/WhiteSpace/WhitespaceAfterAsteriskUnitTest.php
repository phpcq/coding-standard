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

namespace PhpCodeQuality\CodingStandard\Test\PhpCodeQuality\WhiteSpace;

use PhpCodeQuality\CodingStandard\Test\AbstractSniffUnitTest;

/**
 * Verifies that the current file contains only valid utf-8 content.
 */
class WhitespaceAfterAsteriskUnitTest extends AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='WhitespaceAfterAsteriskUnitTest.inc')
    {
        return [
            4  => 1,
            8  => 1,
            21 => 1,
            26 => 1,
            32 => 1,
            38 => 1,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='WhitespaceAfterAsteriskUnitTest.inc')
    {
        return [];
    }
}
