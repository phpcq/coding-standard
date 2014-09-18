<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

/**
 * Verifies that the current file contains only valid UTF-8 content.
 */
class ContaoCommunityAlliance_Sniffs_Files_EncodingUtf8Sniff implements PHP_CodeSniffer_Sniff
{
    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizes = array(
        'PHP',
        'JS',
        'CSS'
    );

    /**
     * The list of already visited files.
     *
     * @var array
     */
    protected $visitedFiles = array();

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_OPEN_TAG, T_INLINE_HTML);
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
        if (in_array($phpcsFile->getFilename(), $this->visitedFiles)) {
            return;
        }

        $encoding = mb_detect_encoding(
            file_get_contents($phpcsFile->getFilename()),
            'UTF-8, ASCII, ISO-8859-1',
            true
        );

        if ($encoding !== 'UTF-8') {
            $error = 'Files must use UTF-8 character set; but ' . $encoding . ' found.';
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}
