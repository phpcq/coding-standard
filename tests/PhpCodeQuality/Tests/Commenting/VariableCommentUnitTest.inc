<?php
class VariableCommentUnitTest
{
    protected $noComment = '';

    /**
     * short description of the member variable.
     *
     * long description of member variable. Can span over multiple
     * lines and can have multiple paragraphs.
     *
     * @var array
     * @see otherFunctions()
     * @see anotherFunctions()
     */
     public $variableName = array();


     // Not "/**" style comment.
     //
     // @var   string
     private  $_incorrectCommentStyle = '';


     protected $noComment2 = '';

    /**
     * Short comment that spans multiple
     * lines also var type is missing
     *
     * @var
     */
     public $singleLineFullStopShortComment = '';


    /**
     * Empty see tag.
     *
     * @var string
     * @see
     */
     public $singleLineEmptySees = '';


    /**
     * No full stop
     *
     * @var     string
     */
     public $noFullStop = '';

    /**
     *
     *
     */
     private $emptyVarDoc = '';

     /**
     * Var type checking (int v.s. integer).
     *
     * @var int
     */
     private $_varSimpleTypeCheck;


     /**
     * Var type checking (array(int => string) v.s. array(int => string)).
     *
     * @var array(int => string)
     */
     private $_varArrayTypeCheck;


    /**
     * @var integer
     */
     private $_varWithNoShortComment;

}//end class


/**
 * VariableCommentUnitTest2.
 *
 * Long description goes here.
 *
 */
class VariableCommentUnitTest2
{

   public $hello;

    /** Comment starts here.
     *
     * @var string
     *
     */
     private $_varCaseTypeCheck;

     /**
      * 这是一条测试评论.
      *
      * @var string
      */
     public $foo;

}//end class

class VariableCommentUnitTest3
{
    /**
     * Some short type name usage int.
     *
     * @var int
     */
    private $_varWithShortTypeInt;

    /**
     * Some short type name usage bool.
     *
     * @var bool
     */
    private $_varWithShortTypeBool;

}

?>
