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
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2006-2015 Squiz Pty Ltd (ABN 77 084 670 600),
 *             2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\Sniffs\Commenting;

/**
 * Ensures doc blocks follow basic formatting.
 */
class DocCommentSniff extends \Generic_Sniffs_Commenting_DocCommentSniff
{
    /**
     * {@inheritDoc}
     */
    public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $token  = $tokens[$stackPtr];
        $closer = $tokens[$token['comment_closer']];
        // Ignore inline doc comments containing only a tag.
        if (1 === \count($token['comment_tags']) && ($token['line'] === $closer['line'])) {
            return;
        }

        parent::process($phpcsFile, $stackPtr);
    }
}
