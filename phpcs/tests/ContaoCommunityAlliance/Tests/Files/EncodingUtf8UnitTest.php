<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

/**
 * Verifies that the current file contains only valid utf-8 content.
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */
class ContaoCommunityAlliance_Tests_Files_EncodingUtf8UnitTest extends ContaoCommunityAlliance_AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     *
     * @throws \RuntimeException When an unknown sniff fixture is encountered.
     */
    public function getErrorList()
    {
        $testFile = func_get_arg(0);
        $parts    = explode('.', $testFile);

        switch ($parts[1]) {
            case 'UTF-8':
                return array();
            case 'ISO-8859-1':
                return array(1 => 1);
            default:
        }

        throw new \RuntimeException('Unknown sniff test fixture encountered: ' . $testFile);

    }

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getWarningList()
    {
        return array();

    }
}
