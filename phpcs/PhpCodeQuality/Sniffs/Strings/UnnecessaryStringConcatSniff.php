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

namespace PhpCodeQuality\Sniffs\Strings;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Strings\UnnecessaryStringConcatSniff as CSUnnecessaryStringConcatSniff;
use PHP_CodeSniffer\Util\Tokens;

/**
 * Checks that two strings are not concatenated together; suggests using one string instead.
 *
 * Allows concatenation to span over multiple lines and to have the php end token hack ('?' . '>') to work.
 */
class UnnecessaryStringConcatSniff extends CSUnnecessaryStringConcatSniff
{
    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int  $stackPtr  The position of the current token
     *                        in the stack passed in $tokens.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        // Work out which type of file this is for.
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$stackPtr]['code'] === T_STRING_CONCAT) {
            if ($phpcsFile->tokenizerType === 'JS') {
                return;
            }
        } else {
            if ($phpcsFile->tokenizerType === 'PHP') {
                return;
            }
        }

        $prev = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
        $next = $phpcsFile->findNext(T_WHITESPACE, ($stackPtr + 1), null, true);
        if ($prev === false || $next === false) {
            return;
        }

        $lineCurrentToken = $tokens[$stackPtr]['line'];
        $lineNextToken    = $tokens[$next]['line'];
        // String concatenation over multiple lines are allowed, so we leave the sniff here.
        if ($lineCurrentToken !== $lineNextToken) {
            return;
        }

        $stringTokens = Tokens::$stringTokens;
        if (\in_array($tokens[$prev]['code'], $stringTokens) && \in_array($tokens[$next]['code'], $stringTokens)) {
            if ($tokens[$prev]['content'][0] === $tokens[$next]['content'][0]) {
                // Before we throw an error for PHP, allow strings to be
                // combined if they would have < and ? next to each other because
                // this trick is sometimes required in PHP strings.
                if ($phpcsFile->tokenizerType === 'PHP') {
                    $prevChar = \substr($tokens[$prev]['content'], -2, 1);
                    $nextChar = $tokens[$next]['content'][1];
                    $combined = $prevChar.$nextChar;
                    if ($combined === '?'.'>' || $combined === '<'.'?') {
                        return;
                    }
                }

                $error = 'String concat is not required here; use a single string instead';
                if ($this->error === true) {
                    $phpcsFile->addError($error, $stackPtr, 'Found');
                } else {
                    $phpcsFile->addWarning($error, $stackPtr, 'Found');
                }
            }
        }
    }
}
