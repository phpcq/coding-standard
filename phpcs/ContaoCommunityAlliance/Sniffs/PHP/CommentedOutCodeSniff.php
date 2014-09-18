<?php
/**
 * Squiz_Sniffs_PHP_CommentedOutCodeSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2012 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Squiz_Sniffs_PHP_CommentedOutCodeSniff.
 *
 * Warn about commented out code.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006-2012 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class ContaoCommunityAlliance_Sniffs_PHP_CommentedOutCodeSniff extends Squiz_Sniffs_PHP_CommentedOutCodeSniff
{
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        // Process whole comment blocks at once, so skip all but the first token.
        if ($stackPtr > 0 && $tokens[$stackPtr]['code'] === $tokens[($stackPtr - 1)]['code']) {
            return;
        }

        // Ignore comments at the end of code blocks.
        if (substr($tokens[$stackPtr]['content'], 0, 6) === '//end ') {
            return;
        }

        if ($phpcsFile->tokenizerType === 'PHP') {
            for ($i = $stackPtr; $i < $phpcsFile->numTokens; $i++) {
                if ($tokens[$stackPtr]['code'] !== $tokens[$i]['code']) {
                    break;
                }

                // Allow code annotations and do not interpret them as commented code.
                if (substr($tokens[$i]['content'], 0, 8) === '/** @var') {
                    return;
                }

                // Do not interpret inheritDoc as commented code.
                if (strpos(strtolower($tokens[$i]['content']), '{@inheritdoc}') !== false) {
                    return;
                }
            }
        }

        parent::process($phpcsFile, $stackPtr);
    }
}
