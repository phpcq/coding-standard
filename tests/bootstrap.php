<?php

/**
 * This file is part of phpcq/coding-standard.
 *
 * (c) 2014 Christian Schiffler, Tristan Lins
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This project is provided in good faith and hope to be usable by anyone.
 *
 * @package    phpcq/coding-standard
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan@lins.io>
 * @copyright  2014-2015 Christian Schiffler <c.schiffler@cyberspectrum.de>, Tristan Lins <tristan@lins.io>
 * @license    https://github.com/phpcq/coding-standard/blob/master/LICENSE.MIT MIT
 * @link       https://github.com/phpcq/coding-standard
 * @filesource
 */

error_reporting(E_ALL);

function includeIfExists($file)
{
    return file_exists($file) ? include $file : false;
}

if ((!$loader = includeIfExists(__DIR__ . '/../vendor/autoload.php'))
    && (!$loader = includeIfExists(__DIR__ . '/../../../autoload.php'))
) {
    echo 'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'curl -sS https://getcomposer.org/installer | php' . PHP_EOL .
        'php composer.phar install' . PHP_EOL;
    exit(1);
}

if (version_compare(PHP_VERSION, '5.4', '<')) {
    /**
     * This class is for backwards compatibility only.
     */
    // @codingStandardsIgnoreStart
    class RecursiveCallbackFilterIterator extends RecursiveFilterIterator
    // @codingStandardsIgnoreEnd
    {
        /**
         * {@inheritDoc}
         */
        public function __construct(RecursiveIterator $iterator, $callback)
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
}
