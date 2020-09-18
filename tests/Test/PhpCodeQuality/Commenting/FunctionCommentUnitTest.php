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

namespace PhpCodeQuality\CodingStandard\Test\PhpCodeQuality\Commenting;

use PhpCodeQuality\CodingStandard\Test\AbstractSniffUnitTest;

/**
 * Unit test class for FunctionCommentSniff.
 */
class FunctionCommentUnitTest extends AbstractSniffUnitTest
{
    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getErrorList($testFile = 'FunctionCommentUnitTest.inc')
    {
        $errors = [
            4   => 1,
            9   => 2,
            11  => 1,
            12  => 1,
            13  => 1,
            14  => 1,
            27  => 1,
        ];

        if (PHP_VERSION_ID >= 70000) {
            $errors[16] = 3;
            $errors[50] = 1;
            $errors[62] = 1;
        }

        return $errors;
    }

    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getWarningList($testFile = 'FunctionCommentUnitTest.inc')
    {
        return [];
    }
}
