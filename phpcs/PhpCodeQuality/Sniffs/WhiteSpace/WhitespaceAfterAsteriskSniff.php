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

/**
 * Checks that one whitespace is after an asterisk in block comments.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_WhiteSpace_WhitespaceAfterAsteriskSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizes = array('PHP');

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_DOC_COMMENT, T_COMMENT, T_DOC_COMMENT_STRING);
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $token   = $tokens[$stackPtr];
        $content = $token['content'];

        // Check if the previous is an asterisk, if so => error.
        if ($token['code'] === T_DOC_COMMENT_STRING) {
            if ($tokens[($stackPtr - 1)]['code'] === T_DOC_COMMENT_STAR) {
                $fix = $phpcsFile->addFixableError(
                    'Whitespace must be added after the asterisk in doc comments. Expected "* ' . $content .
                    '" but "*' . $content . '" was found.',
                    $stackPtr
                );
                if ($fix === true) {
                    $phpcsFile->fixer->replaceToken($stackPtr, ' ' . $content);
                }
            }
            return;
        }

        $trimmed = ltrim($content);
        // We ignore empty lines in doc comment.
        if ($trimmed == '*') {
            return;
        }

        if ((strpos($trimmed, '*') === 0)
            && (strpos($trimmed, ' ') != 1)
            && (strpos($trimmed, '/') != 1)
            && (strpos($trimmed, "\n") != 1)
        ) {
            $asterisk = strpos($content, '*');
            $prefix   = substr($content, 0, ($asterisk + 1)) . ' ';
            $fix      = $phpcsFile->addFixableError(
                'Whitespace must be added after the asterisk in doc comments. Expected "' .
                $prefix . ltrim($trimmed, '*') .
                '" but "' . $content . '" was found.',
                $stackPtr
            );

            if ($fix === true) {
                $replacement = $prefix . ltrim($trimmed, '*');
                $phpcsFile->fixer->replaceToken($stackPtr, $replacement);
            }
        }
    }
}
