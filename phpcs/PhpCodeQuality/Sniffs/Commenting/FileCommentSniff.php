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
 */
class PhpCodeQuality_Sniffs_Commenting_FileCommentSniff extends PEAR_Sniffs_Commenting_FileCommentSniff
{
    /**
     * Tags in correct order and related info.
     *
     * @var array
     */
    protected $tags = array(
        '@category'   => array(
            'required'       => false,
            'allow_multiple' => false,
        ),
        '@package'    => array(
            'required'       => true,
            'allow_multiple' => false,
        ),
        '@subpackage' => array(
            'required'       => false,
            'allow_multiple' => false,
        ),
        '@author'     => array(
            'required'       => true,
            'allow_multiple' => true,
        ),
        '@copyright'  => array(
            'required'       => true,
            'allow_multiple' => true,
        ),
        '@license'    => array(
            'required'       => true,
            'allow_multiple' => false,
        ),
        '@version'    => array(
            'required'       => false,
            'allow_multiple' => false,
        ),
        '@link'       => array(
            'required'       => false,
            'allow_multiple' => true,
        ),
        '@see'        => array(
            'required'       => false,
            'allow_multiple' => true,
        ),
        '@since'      => array(
            'required'       => false,
            'allow_multiple' => false,
        ),
        '@deprecated' => array(
            'required'       => false,
            'allow_multiple' => false,
        ),
    );

    /**
     * Process the package tag.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param array                $tags      The tokens for these tags.
     *
     * @return void
     */
    protected function processPackage(PHP_CodeSniffer_File $phpcsFile, array $tags)
    {
        // No op - we do not check the package name as it should be the same as the github vendor/repository.
        // Sadly we do know neither here.
    }
}
