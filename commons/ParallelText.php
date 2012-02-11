<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 18:20
 * To change this template use File | Settings | File Templates.
 */
class ParallelText
{
    // String 対訳元文字列
    private $source;
    // String sourceに対応する対訳文字列
    private $target;

    function __construct($source = '', $target = '')
    {
        $this->setSource($source);
        $this->setTarget($target);
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
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
