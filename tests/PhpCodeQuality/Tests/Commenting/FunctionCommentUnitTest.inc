<?php
class PHP_CodeSniffer_Filetest
{
    /**
     * A simple function comment.
     *
     * long desc here
     *
     * @param int $stackPtr   The position in @ @unknown the stack of the token
     *                        that opened the scope
     * @param int $detph    How many scope levels down we are.
     * @param int    $index    The index.
     * @return
     * @throws
     */
    private function _functionCall($stackPtr, $depth=1, $index)
    {
        return $stackPtr;

    }

    // @inheritdoc
    // Sample function comment
    //
    //
    //
    public function invalidCommentStyle()
    {

    }


    /**
     * {@inheritdoc}
     *
     * This method is extending from the parent class and therefore we do not need any param desc here.
     */
    public function someInheritedMethod($stackPtr, $depth=1, $index)
    {
        return $stackPtr;
    }

    /**
     * We allow int as type.
     *
     * @param int $myInt The int.
     *
     * @return void
     */
    public function intParam($myInt)
    {

    }

    /**
     * We allow bool as type.
     *
     * @param bool $myBool The int.
     *
     * @return void
     */
    public function boolParam($myBool)
    {

    }

    /**
     * We allow bool as type.
     *
     * @return int
     */
    public function returnint()
    {
        return 0;
    }

    /**
     * We allow bool as type.
     *
     * @return bool
     */
    public function returnBool()
    {
        return false;
    }
}
