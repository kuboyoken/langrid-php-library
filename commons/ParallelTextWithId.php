<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 18:27
 * To change this template use File | Settings | File Templates.
 */

class ParallelTextWithId
{
    // String  用例対訳のID
    private $parallelTextId;
    // String 対訳元文字列
    private $source;
    // String sourceに対応する対訳文字列
    private $target;
    // Array<Category> この用例対訳が属するカテゴリ
    private $categories;

    function __construct($parallelTextId = '', $source = '', $target = '', $categories = array())
    {
        $this->setParallelTextId($parallelTextId);
        $this->setSource($source);
        $this->setTarget($target);
        $this->setCategories($categories);
    }

    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function setParallelTextId($parallelTextId)
    {
        $this->parallelTextId = $parallelTextId;
    }

    public function getParallelTextId()
    {
        return $this->parallelTextId;
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
