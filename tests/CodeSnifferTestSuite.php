<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE.BSD-3-CLAUSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan@lins.io>
 * @copyright  2014-2015 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.MIT MIT
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

/**
 * A test class for running all CodeSniffer related unit tests.
 */
class PhpCodeQuality_CodeSnifferTestSuite
{
    /**
     * Prepare the test runner.
     *
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Add all PHP_CodeSniffer test suites into a single test suite.
     *
     * @return PHPUnit_Framework_TestSuite
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHP code quality project CodeSniffer test suite');

        // Locate the actual directory that contains the standard's tests.
        // This is individual to each standard as they could be symlinked in.
        $baseDir  = __DIR__;
        $iterator = new RecursiveDirectoryIterator(__DIR__ . '/PhpCodeQuality/Tests');
        $iterator = new RecursiveCallbackFilterIterator(
            $iterator,
            function (SplFileInfo $file, $pathname, RecursiveIterator $iterator) {
                if ($iterator->hasChildren()) {
                    return true;
                }

                if (!$file->isFile()) {
                    return false;
                }

                if (!preg_match('~^[^\.].+\.php$~', $file->getBasename())) {
                    return false;
                }

                if (preg_match('~^Abstract~', $file->getBasename())) {
                    return false;
                }

                return true;
            }
        );
        $iterator = new RecursiveIteratorIterator($iterator);

        foreach ($iterator as $file) {
            $filePath  = $file->getPathname();
            $className = str_replace($baseDir . DIRECTORY_SEPARATOR, '', $filePath);
            $className = substr($className, 0, -4);
            $className = str_replace(DIRECTORY_SEPARATOR, '_', $className);

            $class = new $className();
            $suite->addTest($class);
        }

        return $suite;
    }
}
