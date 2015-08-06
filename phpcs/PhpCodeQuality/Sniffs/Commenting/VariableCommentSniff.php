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
 * Parses and verifies the variable doc comment.
 *
 * Verifies that :
 * <ul>
 *  <li>A variable doc comment exists.</li>
 *  <li>Short description ends with a full stop.</li>
 *  <li>There is a blank line after the short description.</li>
 *  <li>There is a blank line between the description and the tags.</li>
 *  <li>Check the order, indentation and content of each tag.</li>
 * </ul>
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_Commenting_VariableCommentSniff extends Squiz_Sniffs_Commenting_VariableCommentSniff
{
    /**
     * Ensure the first line start with capital letter and ends with full stop.
     *
     * @param PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     * @param int                  $commentStart The position in the stack where the comment started.
     * @param int                  $commentEnd   The position in the stack where the comment ended.
     *
     * @return void
     */
    protected function checkShortComment(PHP_CodeSniffer_File $phpcsFile, $commentStart, $commentEnd)
    {
        $tokens       = $phpcsFile->getTokens();
        $shortToken   = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $commentStart, $commentEnd);
        $shortContent = $tokens[$shortToken];

        // No content, only tag.
        if ($tokens[$commentStart]['comment_tags'] && ($shortToken > $tokens[$commentStart]['comment_tags'][0])) {
            return;
        }

        if ($shortContent['content'] !== ucfirst($shortContent['content'])) {
            $fix = $phpcsFile->addFixableError(
                'Variable comment must start with a capital letter "%s"',
                $shortToken,
                '',
                array($shortContent['content'])
            );
            if ($fix === true) {
                $phpcsFile->fixer->beginChangeset();
                $phpcsFile->fixer->replaceToken($shortToken, ucfirst($shortContent['content']));
                $phpcsFile->fixer->endChangeset();
            }
        }
        if ('.' !== substr($shortContent['content'], -1)) {
            $fix = $phpcsFile->addFixableError(
                'Variable comment must end with a full stop "%s"',
                $shortToken,
                '',
                array($shortContent['content'])
            );
            if ($fix === true) {
                $phpcsFile->fixer->beginChangeset();
                $phpcsFile->fixer->replaceToken($shortToken, $shortContent['content'] . '.');
                $phpcsFile->fixer->endChangeset();
            }
        }
    }

    /**
     * Called to process class member vars.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     */
    public function processMemberVar(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens       = $phpcsFile->getTokens();
        $commentToken = array(
            T_COMMENT,
            T_DOC_COMMENT_CLOSE_TAG,
        );

        $commentEnd = $phpcsFile->findPrevious($commentToken, $stackPtr);
        if ($commentEnd === false) {
            $phpcsFile->addError('Missing member variable doc comment', $stackPtr, 'Missing');
            return;
        }

        if ($tokens[$commentEnd]['code'] === T_COMMENT) {
            return;
        } elseif ($tokens[$commentEnd]['code'] !== T_DOC_COMMENT_CLOSE_TAG) {
            return;
        } else {
            // Make sure the comment we have found belongs to us.
            $commentFor = $phpcsFile->findNext(array(T_VARIABLE, T_CLASS, T_INTERFACE), ($commentEnd + 1));
            if ($commentFor !== $stackPtr) {
                return;
            }
        }

        $commentStart = $tokens[$commentEnd]['comment_opener'];
        $comment      = strtolower($phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart)));
        // Accept inheriting of comments to be sufficient.
        if (strpos($comment, '@inheritdoc') !== false) {
            return;
        }

        // Add well known types phpcs does not know about.
        $previous                        = PHP_CodeSniffer::$allowedTypes;
        PHP_CodeSniffer::$allowedTypes[] = 'int';
        PHP_CodeSniffer::$allowedTypes[] = 'bool';
        parent::processMemberVar($phpcsFile, $stackPtr);

        PHP_CodeSniffer::$allowedTypes = $previous;

        $this->checkShortComment($phpcsFile, $commentStart, $commentEnd);
    }
}
