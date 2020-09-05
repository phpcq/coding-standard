<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014-2020 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE.BSD-3-CLAUSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan@lins.io>
 * @author     Sven Baumann <baumann.sv@gmail.com>
 * @copyright  2014-2020 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.MIT MIT
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

namespace PhpCodeQuality\CodingStandard\Test;

use PHP_CodeSniffer\Util\Tokens;
use PhpCodeQuality\CodingStandard\PHPUnit\CodeSnifferTestSuite56;
use PhpCodeQuality\CodingStandard\PHPUnit\CodeSnifferTestSuite7x;

if (defined('PHP_CODESNIFFER_IN_TESTS') === false) {
    define('PHP_CODESNIFFER_IN_TESTS', true);
}

if (defined('PHP_CODESNIFFER_CBF') === false) {
    define('PHP_CODESNIFFER_CBF', false);
}

if (defined('PHP_CODESNIFFER_VERBOSITY') === false) {
    define('PHP_CODESNIFFER_VERBOSITY', 0);
}

include_once \dirname(\dirname(__DIR__)) . '/vendor/squizlabs/php_codesniffer/autoload.php';

$tokens = new Tokens();

if (PHP_VERSION_ID >= 70100) {
    class CodeSnifferTestSuite extends CodeSnifferTestSuite7x {}
} else {
    class CodeSnifferTestSuite extends CodeSnifferTestSuite56 {}
}
