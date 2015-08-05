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
 * @link       https://github.com/phpcq/coding-standard
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.BSD-3-CLAUSE BSD-3-Clause
 * @filesource
 */

/**
 * Parses and verifies the doc comments for classes and interfaces.
 *
 * This sniff is copied and modified from PEAR_Sniffs_Commenting_ClassCommentSniff.
 * Thanks for this guys!
 *
 * Verifies that :
 * <ul>
 *  <li>A doc comment exists.</li>
 *  <li>A doc comment is made by "/**"-Comments.</li>
 *  <li>A doc comment is not empty.</li>
 *  <li>There is no blank newline before the short description.</li>
 *  <li>There is a blank newline after the short description.</li>
 *  <li>There is a blank newline between the long and short description.</li>
 *  <li>There is a blank newline between the long description and tags.</li>
 * </ul>
 *
 * @SuppressWarnings(PHPMD.CamelCaseClassName)
 */
class PhpCodeQuality_Sniffs_Commenting_ClassCommentSniff extends PEAR_Sniffs_Commenting_ClassCommentSniff
{
    /**
     * We do not enforce any tags.
     *
     * @var array
     */
    protected $tags = array();
}
