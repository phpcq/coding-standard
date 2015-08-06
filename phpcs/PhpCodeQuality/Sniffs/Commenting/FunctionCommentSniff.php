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
 * Parses and verifies the doc comments for functions.
 *
 * Verifies that :
 * <ul>
 *  <li>A comment exists</li>
 *  <li>There is a blank newline after the short description</li>
 *  <li>There is a blank newline between the long and short description</li>
 *  <li>There is a blank newline between the long description and tags</li>
 *  <li>Parameter names represent those in the method</li>
 *  <li>Parameter comments are in the correct order</li>
 *  <li>Parameter comments are complete</li>
 *  <li>A type hint is provided for array and custom class</li>
 *  <li>Type hint matches the actual variable/class type</li>
 *  <li>A blank line is present before the first and after the last parameter</li>
 *  <li>A return type exists</li>
 *  <li>Any throw tag must have a comment</li>
 *  <li>The tag order and indentation are correct</li>
 * </ul>
 *
 * Modified by PHP code quality project:
 * <ul>
 * <li>allow "{@inheritDoc}" comments to be sufficient as documentation.</li>
 * <li>allow "int" and "bool" as type hints.<li>
 * <li>not strip the "&" from parameters when passing values by reference</li>
 * </ul>
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_Commenting_FunctionCommentSniff extends Squiz_Sniffs_Commenting_FunctionCommentSniff
{
    /**
     * Check if an php doc contains @inheritdoc.
     *
     * @param PHP_CodeSniffer_File $phpcsFile
     * @param int                  $stackPtr
     * @param int                  $commentStart
     *
     * @return bool
     */
    protected function isInherited(PHP_CodeSniffer_File $phpcsFile, $commentStart)
    {
        $tokens  = $phpcsFile->getTokens();
        $comment = strtolower($phpcsFile->getTokensAsString($commentStart, $tokens[$commentStart]['comment_closer']));

        // Accept inheriting of comments to be sufficient.
        return (strpos($comment, '@inheritdoc') !== false);
    }

    /**
     * Process the return comment of this function comment.
     *
     * @param PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     * @param int                  $stackPtr     The position of the current token
     *                                           in the stack passed in $tokens.
     * @param int                  $commentStart The position in the stack where the comment started.
     *
     * @return void
     */
    protected function processReturn(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $commentStart)
    {
        // Accept inheriting of comments to be sufficient.
        if ($this->isInherited($phpcsFile, $commentStart)) {
            return;
        }

        parent::processReturn($phpcsFile, $stackPtr, $commentStart);
    }

    /**
     * Process the function parameter comments.
     *
     * @param PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     * @param int                  $stackPtr     The position of the current token
     *                                           in the stack passed in $tokens.
     * @param int                  $commentStart The position in the stack where the comment started.
     *
     * @return void
     */
    protected function processParams(PHP_CodeSniffer_File $phpcsFile, $stackPtr, $commentStart)
    {
        // Accept inheriting of comments to be sufficient.
        if ($this->isInherited($phpcsFile, $commentStart)) {
            return;
        }

        $previous = PHP_CodeSniffer::$allowedTypes;

        PHP_CodeSniffer::$allowedTypes[] = 'int';
        PHP_CodeSniffer::$allowedTypes[] = 'bool';

        parent::processParams($phpcsFile, $stackPtr, $commentStart);

        PHP_CodeSniffer::$allowedTypes = $previous;
    }
}
