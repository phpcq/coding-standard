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
class ContaoCommunityAlliance_Tests_WhiteSpace_WhitespaceAfterAsteriskUnitTest extends ContaoCommunityAlliance_AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @param string $testFile The name of the file being tested.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return array(
            4  => 1,
            8  => 1,
            21 => 1,
            26 => 1,
            32 => 1,
            38 => 1,
        );
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
