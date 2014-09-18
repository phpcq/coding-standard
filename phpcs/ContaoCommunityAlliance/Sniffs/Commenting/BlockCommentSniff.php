<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

/**
 * Verifies that block comments are used appropriately.
 *
 * This alters the check from Squiz_Sniffs_Commenting_BlockCommentSniff to ignore inline doc comments as we want to
 * allow constructs like: "@var ClassName $variable".
 */
class ContaoCommunityAlliance_Sniffs_Commenting_BlockCommentSniff extends  Squiz_Sniffs_Commenting_BlockCommentSniff
{
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The current file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // If it is an inline doc comment for type hinting, return.
        if (substr($tokens[$stackPtr]['content'], 0, 8) === '/** @var') {
            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }
}
