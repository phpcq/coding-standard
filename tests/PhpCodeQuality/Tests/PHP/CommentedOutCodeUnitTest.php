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
 * Unit test class for the CommentedOutCode sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 */
class PhpCodeQuality_Tests_PHP_CommentedOutCodeUnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='CommentedOutCodeUnitTest.inc')
    {
        return array();
    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='CommentedOutCodeUnitTest.inc')
    {
        switch ($testFile) {
        case 'CommentedOutCodeUnitTest.inc':
            return array(
                    6  => 1,
                    8  => 1,
                    15 => 1,
                    19 => 1,
                   );
            break;
        case 'CommentedOutCodeUnitTest.css':
            return array(
                    7  => 1,
                    16 => 1,
                   );
            break;
        default:
            return array();
            break;
        }
    }
}
