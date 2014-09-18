<?php
/**
 * Unit test class for FunctionCommentSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Unit test class for FunctionCommentSniff.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ContaoCommunityAlliance_Tests_Commenting_FunctionCommentUnitTest extends ContaoCommunityAlliance_AbstractSniffUnitTest
{


    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array<int, int>
     */
    public function getErrorList()
    {
        return array(
                 8  => 1,
                10  => 2,
                12  => 2,
                13  => 2,
                14  => 1,
                15  => 1,
                28  => 1,
                35  => 2,
                38  => 1,
                41  => 1,
                53  => 1,
                103 => 1,
                109 => 1,
                112 => 2,
                122 => 1,
                123 => 3,
                124 => 3,
                125 => 4,
                126 => 6,
                139 => 1,
                155 => 1,
                165 => 1,
                172 => 1,
                183 => 2,
                193 => 2,
                204 => 1,
                218 => 1,
                234 => 1,
                240 => 1,
                241 => 1,
               );

    }//end getErrorList()


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

    }//end getWarningList()


}//end class

?>
