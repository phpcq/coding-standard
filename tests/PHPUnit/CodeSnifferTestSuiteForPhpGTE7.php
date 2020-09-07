<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014-2020 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE.BSD-3-CLAUSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan@lins.io>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.MIT MIT
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\CodingStandard\PHPUnit;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestResult;
use PHPUnit\TextUI\TestRunner;

/**
 * A test class for running all CodeSniffer related unit tests.
 */
class CodeSnifferTestSuiteForPhpGTE7 extends AbstractCodeSnifferTestSuite implements Test
{
    /**
     * Prepare the test runner.
     *
     * @return void
     */
    public static function main()
    {
        TestRunner::run(self::suite());

    }//end main()
    /**
     * {@inheritDoc}
     */
    public function run(TestResult $result = null): TestResult
    {
        return $result ?? new TestResult();
    }
}
