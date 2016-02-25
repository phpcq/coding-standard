<?php
/**
 * Ensures doc blocks follow basic formatting.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2006-2012 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Ensures doc blocks follow basic formatting.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_Commenting_DocCommentSniff extends Generic_Sniffs_Commenting_DocCommentSniff
{
    /**
     * {@inheritDoc}
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token  = $tokens[$stackPtr];
        $closer = $tokens[$token['comment_closer']];
        // Ignore inline doc comments containing only a tag.
        if (1 === count($token['comment_tags']) && ($token['line'] === $closer['line'])) {
            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }
}
