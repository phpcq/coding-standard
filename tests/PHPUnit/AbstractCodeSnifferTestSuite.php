<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014-2020 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.MIT MIT
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\CodingStandard\PHPUnit;

use PHP_CodeSniffer\Autoload;
use PHP_CodeSniffer\Util\Standards;
use PHPUnit\Framework\TestSuite;

/**
 * This is the abstract class for the code sniffer testsuite.
 */
abstract class AbstractCodeSnifferTestSuite
{
    /**
     * Add all sniff unit tests into a test suite.
     *
     * Sniff unit tests are found by recursing through the 'Tests' directory
     * of each installed coding standard.
     *
     * @return TestSuite
     */
    public static function suite()
    {
        $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES']      = [];
        $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES']    = [];
        $GLOBALS['PHP_CODESNIFFER_SNIFF_CASE_FILES'] = [];

        $suite = new TestSuite('PHP code quality project CodeSniffer test suite');

        // Optionally allow for ignoring the tests for one or more standards.
        $ignoreTestsForStandards = \getenv('PHPCS_IGNORE_TESTS');
        if ($ignoreTestsForStandards === false) {
            $ignoreTestsForStandards = [];
        } else {
            $ignoreTestsForStandards = \explode(',', $ignoreTestsForStandards);
        }

        $installedPaths = [\dirname(\dirname(\realpath(__DIR__))) . '/phpcs'];

        foreach ($installedPaths as $path) {
            $standards = Standards::getInstalledStandards(true, $path);

            // If the test is running PEAR installed, the built-in standards
            // are split into different directories; one for the sniffs and
            // a different file system location for tests.
            $testPath = \dirname($path) . '/tests/Test';

            foreach ($standards as $standard) {
                if (\in_array($standard, $ignoreTestsForStandards, true) === true) {
                    continue;
                }

                $standardDir = $path.DIRECTORY_SEPARATOR.$standard;
                $testsDir    = $testPath.DIRECTORY_SEPARATOR.$standard.DIRECTORY_SEPARATOR;

                if (\is_dir($testsDir) === false) {
                    continue;
                }

                $di = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($testsDir));

                foreach ($di as $file) {
                    // Skip hidden files.
                    if (\substr($file->getFilename(), 0, 1) === '.') {
                        continue;
                    }

                    // Tests must have the extension 'php'.
                    $parts = \explode('.', $file);
                    $ext   = \array_pop($parts);
                    if ($ext !== 'php') {
                        continue;
                    }

                    $className = Autoload::loadFile($file->getPathname());
                    $GLOBALS['PHP_CODESNIFFER_STANDARD_DIRS'][$className] = $standardDir;
                    $GLOBALS['PHP_CODESNIFFER_TEST_DIRS'][$className]     = $testsDir;
                    $suite->addTestSuite($className);
                }
            }//end foreach
        }//end foreach

        return $suite;

    }//end suite()

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        // Do nothing.
    }
}
