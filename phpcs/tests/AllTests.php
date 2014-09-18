<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014, Contao Community Alliance
 * @license   LGPL-3+
 */

/**
 * A test class for running all unit tests.
 *
 * Usage: phpunit AllTests.php
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014, Contao Community Alliance
 */
class ContaoCommunityAlliance_CodeSniffer_AllTests
{
    /**
     * Include a file if it exists.
     *
     * @param string $file The file to include.
     *
     * @return Autoloader|false
     */
    private static function includeIfExists($file)
    {
        return file_exists($file) ? include $file : false;
    }

    /**
     * Load composer autoloader.
     *
     * @return void
     */
    private static function loadAutoloader()
    {
        if (defined('PHP_CODESNIFFER_IN_TESTS')) {
            return;
        }

        define('PHP_CODESNIFFER_IN_TESTS', true);

        error_reporting(E_ALL);

        if ((!$loader = self::includeIfExists(__DIR__.'/../vendor/autoload.php'))
            && (!$loader = self::includeIfExists(__DIR__.'/../../../autoload.php'))
        ) {
            echo 'You must set up the project dependencies, run the following commands:'.PHP_EOL.
                'curl -sS https://getcomposer.org/installer | php'.PHP_EOL.
                'php composer.phar install'.PHP_EOL;
            exit(1);
        }
    }

    /**
     * Prepare the test runner.
     *
     * @return void
     */
    public static function main()
    {
        self::loadAutoloader();
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }


    /**
     * Add all PHP_CodeSniffer test suites into a single test suite.
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        self::loadAutoloader();

        $suite = new PHPUnit_Framework_TestSuite('PHP CodeSniffer Standards');

        // Locate the actual directory that contains the standard's tests.
        // This is individual to each standard as they could be symlinked in.
        $baseDir  = __DIR__;
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(__DIR__ . '/ContaoCommunityAlliance/Tests')
        );

        foreach ($iterator as $file) {
            // Skip hidden files.
            if (substr($file->getFilename(), 0, 1) === '.') {
                continue;
            }

            // Tests must have the extension 'php'.
            $parts = explode('.', $file);
            $ext   = array_pop($parts);
            if ($ext !== 'php') {
                continue;
            }

            $filePath  = $file->getPathname();
            $className = str_replace($baseDir.DIRECTORY_SEPARATOR, '', $filePath);
            $className = substr($className, 0, -4);
            $className = str_replace(DIRECTORY_SEPARATOR, '_', $className);

            $class = new $className();
            $suite->addTest($class);
        }

        return $suite;
    }
}
