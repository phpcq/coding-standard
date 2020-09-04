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

use PHPUnit\Framework\TestCase;

/**
 * An abstract class that all sniff unit tests must extend.
 *
 * A sniff unit test checks a .inc file for expected violations of a single
 * coding standard. Expected errors and warnings that are not found, or
 * warnings and errors that are not expected, are considered test failures.
 */
abstract class AbstractSniffUnitTest extends TestCase
{
    /**
     * The PHP_CodeSniffer object used for testing.
     *
     * @var \PHP_CodeSniffer
     */
    protected static $phpcs;

    /**
     * Sets up this unit test.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    protected function setUp()
    {
        if (self::$phpcs === null) {
            self::$phpcs = new \PHP_CodeSniffer();
        }

        if (!\array_key_exists('PHP_CODESNIFFER_SNIFF_CODES', $GLOBALS)) {
            $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES'] = [];
        }
        if (!\array_key_exists('PHP_CODESNIFFER_FIXABLE_CODES', $GLOBALS)) {
            $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES'] = [];
        }
    }

    /**
     * Should this test be skipped for some reason.
     *
     * @return bool
     */
    protected function shouldSkipTest()
    {
        return false;
    }

    /**
     * Tests the extending classes Sniff class.
     *
     * @test
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    final protected function runTest()
    {
        // Skip this test if we can't run in this environment.
        if ($this->shouldSkipTest() === true) {
            self::markTestSkipped();
        }

        // The basis for determining file locations.
        $basename = \substr(\get_class($this), 0, -8);

        // The name of the coding standard we are testing.
        $standardName = \substr($basename, 0, \strpos($basename, '\\'));

        // The code of the sniff we are testing.
        $parts     = \explode('\\', $basename);
        $sniffCode = $parts[0].'.'.$parts[3].'.'.$parts[4];

        // The name of the dummy file we are testing.
        $testFileBase = \dirname(\dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'fixtures' .
            DIRECTORY_SEPARATOR . \str_replace('.', DIRECTORY_SEPARATOR, $sniffCode) . 'UnitTest.';

        // Get a list of all test files to check. These will have the same base
        // name but different extensions. We ignore the .php file as it is the class.
        $testFiles = [];

        $dir      = \substr($testFileBase, 0, \strrpos($testFileBase, DIRECTORY_SEPARATOR));
        $iterator = new \DirectoryIterator($dir);

        foreach ($iterator as $file) {
            $path = $file->getPathname();
            if (\substr($path, 0, \strlen($testFileBase)) === $testFileBase) {
                if ($path !== $testFileBase.'php' && \substr($path, -5) !== 'fixed') {
                    $testFiles[] = $path;
                }
            }
        }

        // Get them in order.
        \sort($testFiles);

        $srcPath = \dirname(\dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'phpcs';

        self::$phpcs->initStandard(
            $srcPath . DIRECTORY_SEPARATOR . $standardName . DIRECTORY_SEPARATOR . 'ruleset.phpunit.xml',
            array($sniffCode)
        );
        self::$phpcs->setIgnorePatterns([]);

        $failureMessages = [];
        foreach ($testFiles as $testFile) {
            $filename = \basename($testFile);
            try {
                $cliValues = $this->getCliValues($filename);
                self::$phpcs->cli->setCommandLineValues($cliValues);
                $phpcsFile = self::$phpcs->processFile($testFile);
            } catch (\Exception $e) {
                self::fail('An unexpected exception has been caught: ' . $e->getMessage());
            }

            $failures        = $this->generateFailureMessages($phpcsFile);
            $failureMessages = \array_merge($failureMessages, $failures);

            if ($phpcsFile->getFixableCount() > 0) {
                // Attempt to fix the errors.
                $phpcsFile->fixer->fixFile();
                $fixable = $phpcsFile->getFixableCount();
                if ($fixable > 0) {
                    $failureMessages[] = \sprintf('Failed to fix %s fixable violations in %s', $fixable, $filename);
                }
                // Check for a .fixed file to check for accuracy of fixes.
                $fixedFile = $testFile.'.fixed';
                if (\file_exists($fixedFile) === true) {
                    $diff = $phpcsFile->fixer->generateDiff($fixedFile);
                    if (\trim($diff) !== '') {
                        $filename          = \basename($testFile);
                        $fixedFilename     = \basename($fixedFile);
                        $failureMessages[] = \sprintf(
                            'Fixed version of %s does not match expected version in %s; the diff is%s',
                            $filename,
                            $fixedFilename,
                            PHP_EOL . $diff
                        );
                    }
                }
            }
        }

        if (empty($failureMessages) === false) {
            self::fail(implode(PHP_EOL, $failureMessages));
        }
    }

    /**
     * Generate a list of test failures for a given sniffed file.
     *
     * @param \PHP_CodeSniffer_File $file The file being tested.
     *
     * @return array
     *
     * @throws \PHP_CodeSniffer_Exception When the getErrorList() or getWarningList() return value is invalid.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function generateFailureMessages(\PHP_CodeSniffer_File $file)
    {
        $testFile = $file->getFilename();

        $foundErrors      = $file->getErrors();
        $foundWarnings    = $file->getWarnings();
        $expectedErrors   = $this->getErrorList(\basename($testFile));
        $expectedWarnings = $this->getWarningList(\basename($testFile));

        if (\is_array($expectedErrors) === false) {
            throw new \PHP_CodeSniffer_Exception('getErrorList() must return an array');
        }

        if (\is_array($expectedWarnings) === false) {
            throw new \PHP_CodeSniffer_Exception('getWarningList() must return an array');
        }

        /*
            We merge errors and warnings together to make it easier
            to iterate over them and produce the errors string. In this way,
            we can report on errors and warnings in the same line even though
            it's not really structured to allow that.
        */

        $allProblems     = [];
        $failureMessages = [];

        foreach ($foundErrors as $line => $lineErrors) {
            foreach ($lineErrors as $column => $errors) {
                if (isset($allProblems[$line]) === false) {
                    $allProblems[$line] = [
                        'expected_errors'   => 0,
                        'expected_warnings' => 0,
                        'found_errors'      => [],
                        'found_warnings'    => [],
                    ];
                }

                $foundErrorsTemp = [];
                foreach ($allProblems[$line]['found_errors'] as $foundError) {
                    $foundErrorsTemp[] = $foundError;
                }

                $errorsTemp = [];
                foreach ($errors as $foundError) {
                    $errorsTemp[] = $foundError['message'].' ('.$foundError['source'].')';
                    $source       = $foundError['source'];
                    if (\in_array($source, $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES']) === false) {
                        $GLOBALS['PHP_CODESNIFFER_SNIFF_CODES'][] = $source;
                    }
                    if ($foundError['fixable'] === true
                        && \in_array($source, $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES']) === false
                    ) {
                        $GLOBALS['PHP_CODESNIFFER_FIXABLE_CODES'][] = $source;
                    }
                }

                $allProblems[$line]['found_errors'] = \array_merge($foundErrorsTemp, $errorsTemp);
            }

            if (isset($expectedErrors[$line]) === true) {
                $allProblems[$line]['expected_errors'] = $expectedErrors[$line];
            } else {
                $allProblems[$line]['expected_errors'] = 0;
            }

            unset($expectedErrors[$line]);
        }

        foreach ($expectedErrors as $line => $numErrors) {
            if (isset($allProblems[$line]) === false) {
                $allProblems[$line] = [
                    'expected_errors'   => 0,
                    'expected_warnings' => 0,
                    'found_errors'      => [],
                    'found_warnings'    => [],
                ];
            }

            $allProblems[$line]['expected_errors'] = $numErrors;
        }

        foreach ($foundWarnings as $line => $lineWarnings) {
            foreach ($lineWarnings as $column => $warnings) {
                if (isset($allProblems[$line]) === false) {
                    $allProblems[$line] = [
                        'expected_errors'   => 0,
                        'expected_warnings' => 0,
                        'found_errors'      => [],
                        'found_warnings'    => [],
                    ];
                }

                $foundWarningsTemp = [];
                foreach ($allProblems[$line]['found_warnings'] as $foundWarning) {
                    $foundWarningsTemp[] = $foundWarning;
                }

                $warningsTemp = [];
                foreach ($warnings as $warning) {
                    $warningsTemp[] = $warning['message'].' ('.$warning['source'].')';
                }

                $allProblems[$line]['found_warnings'] = \array_merge($foundWarningsTemp, $warningsTemp);
            }

            if (isset($expectedWarnings[$line]) === true) {
                $allProblems[$line]['expected_warnings'] = $expectedWarnings[$line];
            } else {
                $allProblems[$line]['expected_warnings'] = 0;
            }

            unset($expectedWarnings[$line]);
        }

        foreach ($expectedWarnings as $line => $numWarnings) {
            if (isset($allProblems[$line]) === false) {
                $allProblems[$line] = [
                    'expected_errors'   => 0,
                    'expected_warnings' => 0,
                    'found_errors'      => [],
                    'found_warnings'    => [],
                ];
            }

            $allProblems[$line]['expected_warnings'] = $numWarnings;
        }

        // Order the messages by line number.
        \ksort($allProblems);

        foreach ($allProblems as $line => $problems) {
            $numErrors        = \count($problems['found_errors']);
            $numWarnings      = \count($problems['found_warnings']);
            $expectedErrors   = $problems['expected_errors'];
            $expectedWarnings = $problems['expected_warnings'];

            $errors      = '';
            $foundString = '';

            try {
                self::assertSame($expectedErrors, $numErrors);
            } catch (\PHPUnit_Framework_ExpectationFailedException $exception) {
                // Silence it, we dump the errors below.
            }
            try {
                self::assertSame($expectedWarnings, $numWarnings);
            } catch (\PHPUnit_Framework_ExpectationFailedException $exception) {
                // Silence it, we dump the errors below.
            }

            if ($expectedErrors !== $numErrors || $expectedWarnings !== $numWarnings) {
                $lineMessage     = \sprintf('[LINE %s]', $line);
                $expectedMessage = 'Expected ';
                $foundMessage    = 'in '.\basename($testFile).' but found ';

                if ($expectedErrors !== $numErrors) {
                    $expectedMessage .= \sprintf('%s error(s)', $expectedErrors);
                    $foundMessage    .= \sprintf('%s error(s)', $numErrors);
                    if ($numErrors !== 0) {
                        $foundString .= 'error(s)';
                        $errors      .= \implode(PHP_EOL.' -> ', $problems['found_errors']);
                    }

                    if ($expectedWarnings !== $numWarnings) {
                        $expectedMessage .= ' and ';
                        $foundMessage    .= ' and ';
                        if ($numWarnings !== 0) {
                            if ($foundString !== '') {
                                $foundString .= ' and ';
                            }
                        }
                    }
                }

                if ($expectedWarnings !== $numWarnings) {
                    $expectedMessage .= \sprintf('%s warning(s)', $expectedWarnings);
                    $foundMessage    .= \sprintf('%s warning(s)', $numWarnings);
                    if ($numWarnings !== 0) {
                        $foundString .= 'warning(s)';
                        if (empty($errors) === false) {
                            $errors .= PHP_EOL.' -> ';
                        }

                        $errors .= \implode(PHP_EOL.' -> ', $problems['found_warnings']);
                    }
                }

                $fullMessage = \sprintf('%s %s %s.', $lineMessage, $expectedMessage, $foundMessage);
                if ($errors !== '') {
                    $fullMessage .= \sprintf(' The %s found were:' . PHP_EOL.' -> %s', $foundString, $errors);
                }

                $failureMessages[] = $fullMessage;
            }
        }

        if (empty($allProblems)) {
            self::assertSame($expectedErrors, $foundErrors);
            self::assertSame($expectedWarnings, $foundWarnings);
        }

        return $failureMessages;
    }

    /**
     * Get a list of CLI values to set before the file is tested.
     *
     * @param string $filename The name of the file being tested.
     *
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getCliValues($filename)
    {
        return [];
    }

    /**
     * Returns the lines where errors should occur.
     *
     *    The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $filename The name of the file being tested.
     *
     * @return array(int => int)
     */
    abstract protected function getErrorList($filename);

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @param string $filename The name of the file being tested.
     *
     * @return array(int => int)
     */
    abstract protected function getWarningList($filename);
}
