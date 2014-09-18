<?php
/**
 * Parses and verifies the variable doc comment.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

if (class_exists('PHP_CodeSniffer_Standards_AbstractVariableSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_AbstractVariableSniff not found');
}

if (class_exists('PHP_CodeSniffer_CommentParser_MemberCommentParser', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_CommentParser_MemberCommentParser not found');
}

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
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2006-2014 Squiz Pty Ltd (ABN 77 084 670 600)
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

class ContaoCommunityAlliance_Sniffs_Commenting_VariableCommentSniff extends Squiz_Sniffs_Commenting_VariableCommentSniff
{
    /**
     * Process the var tag.
     *
     * @param int $commentStart The position in the stack where the comment started.
     * @param int $commentEnd   The position in the stack where the comment ended.
     *
     * @return void
     */
    protected function processVar($commentStart, $commentEnd)
    {
        $var = $this->commentParser->getVar();

        if ($var !== null) {
            $errorPos = ($commentStart + $var->getLine());
            $index    = array_keys($this->commentParser->getTagOrders(), 'var');

            if (count($index) > 1) {
                $error = 'Only 1 @var tag is allowed in variable comment';
                $this->currentFile->addError($error, $errorPos, 'DuplicateVar');
                return;
            }

            if ($index[0] !== 1) {
                $error = 'The @var tag must be the first tag in a variable comment';
                $this->currentFile->addError($error, $errorPos, 'VarOrder');
            }

            $content = $var->getContent();
            if (empty($content) === true) {
                $error = 'Var type missing for @var tag in variable comment';
                $this->currentFile->addError($error, $errorPos, 'MissingVarType');
                return;
            } else {
                $suggestedType = PHP_CodeSniffer::suggestType($content);
                if ($suggestedType !== $content) {
                    // Hotfix - somehow they do not like "int" and "bool".
                    switch ($content) {
                        case 'int':
                            $suggestedType = 'int';
                            break;
                        case 'bool':
                            $suggestedType = 'bool';
                            break;
                        default:
                    }
                }

                if ($content !== $suggestedType) {
                    $error = 'Expected "%s"; found "%s" for @var tag in variable comment';
                    $data  = array(
                              $suggestedType,
                              $content,
                             );
                    $this->currentFile->addError($error, $errorPos, 'IncorrectVarType', $data);
                }
            }

            $spacing = substr_count($var->getWhitespaceBeforeContent(), ' ');
            if ($spacing !== 1) {
                $error = '@var tag indented incorrectly; expected 1 space but found %s';
                $data  = array($spacing);
                $this->currentFile->addError($error, $errorPos, 'VarIndent', $data);
            }
        } else {
            $error = 'Missing @var tag in variable comment';
            $this->currentFile->addError($error, $commentEnd, 'MissingVar');
        }//end if

    }//end processVar()

}//end class
?>
