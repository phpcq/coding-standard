<?php
/**
 * PHP version 5
 *
 * @author    Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @copyright 2014 Contao Community Alliance
 * @license   https://github.com/squizlabs/PHP_CodeSniffer/blob/master/licence.txt BSD Licence
 */

if (class_exists('Generic_Sniffs_PHP_ForbiddenFunctionsSniff', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class Generic_Sniffs_PHP_ForbiddenFunctionsSniff not found');
}

/**
 * Discourages the use of alias functions that are kept in PHP for compatibility with older versions.
 * Also disallows the usage of debug methods.
 */
class ContaoCommunityAlliance_Sniffs_PHP_ForbiddenFunctionsSniff extends Generic_Sniffs_PHP_ForbiddenFunctionsSniff
{
    /**
     * A list of forbidden functions with their alternatives.
     *
     * The value is NULL if no alternative exists. IE, the
     * function should just not be used.
     *
     * @var array(string => string|null)
     */
    protected $forbiddenFunctions = array(
        'sizeof'          => 'count',
        'delete'          => 'unset',
        'print'           => 'echo',
        'is_null'         => null,
        'create_function' => null,
        'print_r'         => null,
        'var_dump'        => null,
        'xdebug'          => null,
    );

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $tokens   = parent::register();
        $tokens[] = T_PRINT;
        return $tokens;
    }
}
