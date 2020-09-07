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
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\CodingStandard\Test;

use PhpCodeQuality\CodingStandard\PHPUnit\AbstractSniffUnitTestForPhpunitGTE8;
use PhpCodeQuality\CodingStandard\PHPUnit\AbstractSniffUnitTestForPhpunitLT8;
use PHPUnit\Runner\Version;

$version = (\class_exists(Version::class)) ? Version::id() : \PHPUnit_Runner_Version::id();

if (\version_compare($version, '8.0.0', '>=')) {
    abstract class AbstractSniffUnitTest extends AbstractSniffUnitTestForPhpunitGTE8 {}
} else {
    abstract class AbstractSniffUnitTest extends AbstractSniffUnitTestForPhpunitLT8 {}
}

