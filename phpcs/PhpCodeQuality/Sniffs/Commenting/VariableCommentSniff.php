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

namespace PhpCodeQuality\Sniffs\Commenting;

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
 */
class VariableCommentSniff extends \PHP_CodeSniffer_Standards_AbstractVariableSniff
{
    /**
     * Add an error and automatically fix it if desired.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile  The file being scanned.
     *
     * @param string                $error      The error message.
     *
     * @param string                $code       A violation code unique to the sniff message.
     *
     * @param int                   $token      The token to replace.
     *
     * @param string                $newContent The new content for the token.
     *
     * @return void
     */
    protected function autoFix(\PHP_CodeSniffer_File $phpcsFile, $error, $code, $token, $newContent)
    {
        $tokens = $phpcsFile->getTokens();
        if ($tokens[$token]['content'] === $newContent) {
            return;
        }
        $fix = $phpcsFile->addFixableError($error, $token, $code);
        if ($fix === true) {
            $phpcsFile->fixer->beginChangeset();
            $phpcsFile->fixer->replaceToken($token, $newContent);
            $phpcsFile->fixer->endChangeset();
        }
    }

    /**
     * Ensure the first line start with capital letter and ends with full stop.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile    The file being scanned.
     *
     * @param int                   $commentStart The position in the stack where the comment started.
     *
     * @param int                   $commentEnd   The position in the stack where the comment ended.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function checkShortComment(\PHP_CodeSniffer_File $phpcsFile, $commentStart, $commentEnd)
    {
        $tokens     = $phpcsFile->getTokens();
        $shortToken = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $commentStart, $commentEnd);
        if ($shortToken === false) {
            return;
        }
        $shortContent = $tokens[$shortToken];

        // Check if short comment spans multiple lines.
        // Account for the fact that a short description might cover multiple lines.
        $shortEnd = $shortToken;
        $stopScan = $tokens[$commentStart]['comment_tags'] ? $tokens[$commentStart]['comment_tags'][0] : $commentEnd;
        for ($i = ($shortToken + 1); $i < $stopScan; $i++) {
            if ($tokens[$i]['code'] === T_DOC_COMMENT_STRING) {
                if ($tokens[$i]['line'] === ($tokens[$shortEnd]['line'] + 1)) {
                    $phpcsFile->addError('Variable short comment must be a single line', $shortToken, 'MultiLineShort');
                    return;
                } else {
                    break;
                }
            }
        }

        // No content, only tag.
        if ($tokens[$commentStart]['comment_tags'] && ($shortToken >= $tokens[$commentStart]['comment_tags'][0])) {
            return;
        }

        $this->autoFix(
            $phpcsFile,
            'Variable comment must start with a capital letter',
            'ShortCapitalLetter',
            $shortToken,
            (\utf8_encode($shortContent['content']) === $shortContent['content'])
                ? \ucfirst($shortContent['content']) : $shortContent['content']
        );

        if ('.' !== \substr($shortContent['content'], -1)) {
            $this->autoFix(
                $phpcsFile,
                'Variable comment must end with a full stop',
                'ShortFullStop',
                $shortToken,
                $shortContent['content'] . '.'
            );
        }
    }

    /**
     * Called to process class member vars.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     *
     * @param int                   $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function processMemberVar(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
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

        // Make sure the comment we have found belongs to us.
        $commentFor = $phpcsFile->findNext(array(T_VARIABLE, T_CLASS, T_INTERFACE, T_FUNCTION), ($commentEnd + 1));
        if ($commentFor !== $stackPtr) {
            $phpcsFile->addError('Missing member variable doc comment', $stackPtr, 'Missing');
            return;
        }

        if ($tokens[$commentEnd]['code'] === T_COMMENT) {
            $phpcsFile->addError('Member variable doc comment must be doc block', $commentEnd, 'NotDocBlock');
            return;
        } elseif ($tokens[$commentEnd]['code'] !== T_DOC_COMMENT_CLOSE_TAG) {
            return;
        }

        $commentStart = $tokens[$commentEnd]['comment_opener'];
        $comment      = \strtolower($phpcsFile->getTokensAsString($commentStart, ($commentEnd - $commentStart)));
        // Accept inheriting of comments to be sufficient.
        if (strpos($comment, '@inheritdoc') !== false) {
            return;
        }

        // Add well known types phpcs does not know about.
        $previous                         = \PHP_CodeSniffer::$allowedTypes;
        \PHP_CodeSniffer::$allowedTypes[] = 'int';
        \PHP_CodeSniffer::$allowedTypes[] = 'bool';


        $foundVar = null;
        foreach ($tokens[$commentStart]['comment_tags'] as $tag) {
            if ($tokens[$tag]['content'] === '@var') {
                if ($foundVar !== null) {
                    $phpcsFile->addError(
                        'Only one @var tag is allowed in a member variable comment',
                        $tag,
                        'DuplicateVar'
                    );
                } else {
                    $foundVar = $tag;
                }
            } elseif ($tokens[$tag]['content'] === '@see') {
                // Make sure the tag isn't empty.
                $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $tag, $commentEnd);
                if ($string === false || $tokens[$string]['line'] !== $tokens[$tag]['line']) {
                    $error = 'Content missing for @see tag in member variable comment';
                    $phpcsFile->addError($error, $tag, 'EmptySees');
                }
            } elseif ($tokens[$tag]['content'] === '@deprecated') {
                $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $tag, $commentEnd);
                if ($string === false || $tokens[$string]['line'] !== $tokens[$tag]['line']) {
                    $error = 'Content missing for @deprecated tag in member variable comment';
                    $phpcsFile->addError($error, $tag, 'EmptyDeprecated');
                }
            }
        }

        // The @var tag is the only one we require.
        if ($foundVar === null) {
            $error = 'Missing @var tag in member variable comment';
            $phpcsFile->addError($error, $commentEnd, 'MissingVar');
            return;
        }

        $firstTag = $tokens[$commentStart]['comment_tags'][0];
        if ($foundVar !== null && $tokens[$firstTag]['content'] !== '@var') {
            $error = 'The @var tag must be the first tag in a member variable comment';
            $phpcsFile->addError($error, $foundVar, 'VarOrder');
        }

        // Make sure the tag isn't empty and has the correct padding.
        $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $foundVar, $commentEnd);
        if ($string === false || $tokens[$string]['line'] !== $tokens[$foundVar]['line']) {
            $error = 'Content missing for @var tag in member variable comment';
            $phpcsFile->addError($error, $foundVar, 'EmptyVar');
            return;
        }

        $varType       = $tokens[($foundVar + 2)]['content'];
        $suggestedType = \PHP_CodeSniffer::suggestType($varType);
        if ($varType !== $suggestedType) {
            $error = 'Expected "%s" but found "%s" for @var tag in member variable comment';
            $data  = array(
                $suggestedType,
                $varType,
            );
            $phpcsFile->addError($error, ($foundVar + 2), 'IncorrectVarType', $data);
        }

        \PHP_CodeSniffer::$allowedTypes = $previous;

        $this->checkShortComment($phpcsFile, $commentStart, $commentEnd);
    }

    /**
     * Called to process a normal variable.
     *
     * Not required for this sniff.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The PHP_CodeSniffer file where this token was found.
     * @param int                   $stackPtr  The position where the double quoted
     *                                         string was found.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function processVariable(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
    }

    /**
     * Called to process variables found in double quoted strings.
     *
     * Not required for this sniff.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The PHP_CodeSniffer file where this token was found.
     * @param int                   $stackPtr  The position where the double quoted
     *                                         string was found.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function processVariableInString(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
    }
}
