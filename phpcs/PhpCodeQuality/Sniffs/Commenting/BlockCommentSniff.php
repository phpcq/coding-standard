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
 * Verifies that block comments are used appropriately.
 *
 * This alters the check from Squiz_Sniffs_Commenting_BlockCommentSniff to ignore inline doc comments as we want to
 * allow constructs like: "/** @annotation ..." in any doc block.
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_Commenting_BlockCommentSniff extends Squiz_Sniffs_Commenting_BlockCommentSniff
{
    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The current file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $commentEnd = $phpcsFile->findNext(T_DOC_COMMENT_CLOSE_TAG, $stackPtr);
        $content    = $phpcsFile->getTokensAsString($stackPtr, ($commentEnd - $stackPtr));

        // If it is an inline doc comment for type hinting etc., return.
        if (substr($content, 0, 5) === '/** @') {
            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }
}
