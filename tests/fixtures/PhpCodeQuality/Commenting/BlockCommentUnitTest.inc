<?php

/** @var int $foo */
$foo = 0;

/**
 * Comment should be ignored.
 *
 */
final class MyClass
{
    /**
     * Comment should be ignored.
     */
    final public function test() {
        /** @var SomeClass $var */
        $var = some_function();

        /* @var SomeClass $notAllowed */
        $notAllowed = null;

        /** @anyAnnotationIsAllowed */
    }
}
