<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *     2014-2020 Christian Schiffler, Tristan Lins
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
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *             2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\Sniffs\WhiteSpace;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Checks that one whitespace is after an asterisk in block comments.
 */
class WhitespaceAfterAsteriskSniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizes = ['PHP'];

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_DOC_COMMENT, T_COMMENT, T_DOC_COMMENT_STRING];
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int  $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $token   = $tokens[$stackPtr];
        $content = $token['content'];

        // Check if the previous is an asterisk, if so => error.
        if ($token['code'] === T_DOC_COMMENT_STRING) {
            if ($tokens[($stackPtr - 1)]['code'] === T_DOC_COMMENT_STAR) {
                $nonSpace = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 2), null, true);
                $expected = $tokens[$nonSpace]['content'].$tokens[$stackPtr]['content'];
                $found    = $phpcsFile->getTokensAsString($nonSpace, ($stackPtr - $nonSpace)) .
                            $tokens[$stackPtr]['content'];
                $data     = [$expected, $found];
                $error    = 'Whitespace must be added after the asterisk in doc comments. Expected "* ' . $content .
                         '" but "*' . $content . '" was found.';

                $fix = $phpcsFile->addFixableError($error, $stackPtr, 'WhitespaceAfterAsteriskSniff', $data);
                if ($fix === true) {
                    $phpcsFile->fixer->replaceToken($stackPtr, ' ' . $content);
                }
            }
            return;
        }

        $trimmed = \ltrim($content);
        // We ignore empty lines in doc comment.
        if ($trimmed == '*') {
            return;
        }

        if ((\strpos($trimmed, '*') === 0)
            && (\strpos($trimmed, ' ') != 1)
            && (\strpos($trimmed, '/') != 1)
            && (\strpos($trimmed, "\n") != 1)
        ) {
            $nonSpace = $phpcsFile->findPrevious(Tokens::$emptyTokens, ($stackPtr - 2), null, true);
            $expected = $tokens[$nonSpace]['content'].$tokens[$stackPtr]['content'];
            $found    = $phpcsFile->getTokensAsString($nonSpace, ($stackPtr - $nonSpace)).$tokens[$stackPtr]['content'];
            $data     = [$expected, $found];
            $asterisk = \strpos($content, '*');
            $prefix   = \substr($content, 0, ($asterisk + 1)) . ' ';
            $error    = 'Whitespace must be added after the asterisk in doc comments. Expected "' . $prefix .
                        \ltrim($trimmed, '*') . '" but "' . $content . '" was found.';
            $fix      = $phpcsFile->addFixableError($error, $stackPtr, 'WhitespaceAfterAsterisk', $data);

            if ($fix === true) {
                $replacement = $prefix . \ltrim($trimmed, '*');
                $phpcsFile->fixer->replaceToken($stackPtr, $replacement);
            }
        }
    }
}
