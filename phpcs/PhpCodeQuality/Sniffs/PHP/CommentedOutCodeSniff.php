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
 * @link       https://github.com/phpcq/coding-standard
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @filesource
 */

/**
 * Squiz_Sniffs_PHP_CommentedOutCodeSniff.
 *
 * Warn about commented out code.
 */
class PhpCodeQuality_Sniffs_PHP_CommentedOutCodeSniff extends Squiz_Sniffs_PHP_CommentedOutCodeSniff
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
