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

namespace PhpCodeQuality\Sniffs\Files;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Verifies that the current file contains only valid UTF-8 content.
 */
class EncodingUtf8Sniff implements Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizes = [
        'PHP',
        'JS',
        'CSS'
    ];

    /**
     * The list of already visited files.
     *
     * @var array
     */
    protected $visitedFiles = [];

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return [T_OPEN_TAG, T_INLINE_HTML];
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param File $phpcsFile The file being scanned.
     * @param int  $stackPtr  The position of the current token in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(File $phpcsFile, $stackPtr)
    {
        if (\in_array($phpcsFile->getFilename(), $this->visitedFiles)) {
            return;
        }

        $encoding = \mb_detect_encoding(
            \file_get_contents($phpcsFile->getFilename()),
            'UTF-8, ASCII, ISO-8859-1',
            true
        );

        if ($encoding !== 'UTF-8') {
            $error = 'Files must use UTF-8 character set; but ' . $encoding . ' found.';
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
    }
}
