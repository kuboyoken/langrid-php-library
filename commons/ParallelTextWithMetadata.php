<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 18:22
 * To change this template use File | Settings | File Templates.
 */
class ParallelTextWithMetadata
{
    // String 対訳元文字列
    private $source;
    // String sourceに対応する対訳文字列
    private $target;
    // Array<String> 用例対訳に付与されたメタデータ
    private $metadata;

    function __construct($source = '', $target = '', $metadata = array())
    {
        $this->setSource($source);
        $this->setTarget($target);
        $this->setMetadata($metadata);
    }

    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    public function getMetadata()
    {
        return $this->metadata;
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
