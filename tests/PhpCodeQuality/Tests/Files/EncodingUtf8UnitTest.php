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
 * Verifies that the current file contains only valid utf-8 content.
 */
class PhpCodeQuality_Tests_Files_EncodingUtf8UnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='EncodingUtf8UnitTest.inc')
    {
        $testFile = func_get_arg(0);
        $parts    = explode('.', $testFile);

        switch ($parts[1]) {
            case 'UTF-8':
                return array();
            case 'ISO-8859-1':
                return array(1 => 1);
            default:
        }

        throw new \RuntimeException('Unknown sniff test fixture encountered: ' . $testFile);
    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='EncodingUtf8UnitTest.inc')
    {
        return array();
    }
}
