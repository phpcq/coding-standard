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
use PHPUnit\Framework\TestSuite;

/**
 * A test class for running all CodeSniffer related unit tests.
 */
class CodeSnifferTestSuite56 implements Test
{
    /**
     * Add all PHP_CodeSniffer test suites into a single test suite.
     *
     * @return TestSuite
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public static function suite()
    {
        $suite = new TestSuite('PHP code quality project CodeSniffer test suite');

        // Locate the actual directory that contains the standard's tests.
        // This is individual to each standard as they could be symlinked in.
        $baseDir  = \dirname(\realpath(__DIR__));
        $iterator = new \RecursiveDirectoryIterator($baseDir . DIRECTORY_SEPARATOR . 'Test');
        $iterator = new RecursiveCallbackFilterIterator(
            $iterator,
            function (\SplFileInfo $file, $pathname, \RecursiveIterator $iterator) {
                if ($iterator->hasChildren()) {
                    return true;
                }

                if (!$file->isFile()) {
                    return false;
                }

                if (!\preg_match('~^[^\.].+\.php$~', $file->getBasename())) {
                    return false;
                }

                if (\preg_match('~^Abstract~', $file->getBasename())) {
                    return false;
                }

                return true;
            }
        );
        $iterator = new \RecursiveIteratorIterator($iterator);

        foreach ($iterator as $file) {
            $filePath  = $file->getPathname();
            $className = \str_replace($baseDir . DIRECTORY_SEPARATOR, '', $filePath);
            $className = \substr($className, 0, -4);
            $className = 'PhpCodeQuality\\CodingStandard\\' . \str_replace(DIRECTORY_SEPARATOR, '\\', $className);

            $class = new $className();
            $suite->addTest($class);
        }

        return $suite;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        // Do nothing.
    }

    /**
     * {@inheritDoc}
     */
    public function run(\PHPUnit_Framework_TestResult $result = null)
    {
        // Do nothing.
    }
}

