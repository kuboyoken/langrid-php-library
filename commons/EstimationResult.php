<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/16
 * Time: 23:41
 * To change this template use File | Settings | File Templates.
 */
class EstimationResult
{
    // double
    private $quality;
    // String
    private $target;

    function __construct($quality = 0.0, $target = '')
    {
        $this->setQuality($quality);
        $this->setTarget($target);
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
    }

    public function getQuality()
    {
        return $this->quality;
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
