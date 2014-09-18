<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

/**
 * Checks that one whitespace is after an asterisk in block comments.
 */
class ContaoCommunityAlliance_Sniffs_WhiteSpace_WhitespaceAfterAsteriskSniff implements PHP_CodeSniffer_Sniff
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
        return array(T_DOC_COMMENT, T_COMMENT);
    }

    /**
     * Processes this sniff, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in
     *                                        the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens  = $phpcsFile->getTokens();
        $content = trim($tokens[$stackPtr]['content']);

        // We ignore empty lines in doc comment.
        if (trim($content) == '*') {
            return;
        }

        if ((strpos($content, '*') === 0)
            && (strpos($content, ' ') != 1)
            && (strpos($content, '/') != 1)
            && (strpos($content, "\n") != 1)
        ) {
            $phpcsFile->addError(
                'Whitespace must be added after the asterisk in doc comments. Expected "* ' . ltrim($content, '*') .
                '" but "' . $content . '" was found.',
                $stackPtr
            );
        }
    }
}
