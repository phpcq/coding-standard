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
 * Unit test class for the BlockComment sniff.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings are stored in this class.
 */
class PhpCodeQuality_Tests_Commenting_BlockCommentUnitTest extends PhpCodeQuality_Tests_AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     */
    public function getErrorList($testFile='BlockCommentUnitTest.inc')
    {
        $errors = array(
                   8   => 1,
                   19  => 1,
                   20  => 1,
                   24  => 1,
                   30  => 1,
                   31  => 1,
                   34  => 1,
                   40  => 1,
                   45  => 1,
                   49  => 1,
                   51  => 1,
                   53  => 1,
                   57  => 1,
                   60  => 1,
                   61  => 1,
                   63  => 1,
                   65  => 1,
                   68  => 1,
                   70  => 1,
                   75  => 1,
                   84  => 1,
                   85  => 2,
                   86  => 1,
                   87  => 1,
                   89  => 1,
                   92  => 1,
                   111 => 1,
                   159 => 1,
                  );

        // The trait tests will only work in PHP version where traits exist and
        // will throw errors in earlier versions.
        if (version_compare(PHP_VERSION, '5.4.0') < 0) {
            $errors[170] = 2;
            $errors[171] = 1;
            $errors[172] = 2;
        }

        return $errors;

    }

    /**
     * {@inheritDoc}
     */
    public function getWarningList($testFile='BlockCommentUnitTest.inc')
    {
        return array();

    }
}
