<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014-2020 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE
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

namespace PhpCodeQuality\CodingStandard\PHPUnit;

/**
 * This class is for backwards compatibility only.
 */
class RecursiveCallbackFilterIterator extends \RecursiveFilterIterator
{
    private $callback;

    /**
     * {@inheritDoc}
     */
    public function __construct(\RecursiveIterator $iterator, $callback)
    {
        $this->callback = $callback;
        parent::__construct($iterator);
    }

    /**
     * {@inheritDoc}
     */
    public function accept()
    {
        $callback = $this->callback;
        return $callback(parent::current(), parent::key(), parent::getInnerIterator());
    }

    /**
     * {@inheritDoc}
     */
    public function getChildren()
    {
        return new self($this->getInnerIterator()->getChildren(), $this->callback);
    }
}
