<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 16:29
 * To change this template use File | Settings | File Templates.
 */
class BackTranslationResult
{
    // String 中間翻訳結果
    private $intermediate;
    // String 折り返し翻訳結果
    private $target;

    function __construct($intermediate = '', $target = '')
    {
        $this->intermediate = $intermediate;
        $this->target = $target;
    }

    public function setIntermediate($intermediate)
    {
        $this->intermediate = $intermediate;
    }

    public function getIntermediate()
    {
        return $this->intermediate;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getTarget()
    {
        return $this->target;
    }
}
