<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/16
 * Time: 23:41
 * To change this template use File | Settings | File Templates.
 */
class SelectionResult
{
    // Array<EstimationResult> 品質評価結果
    private $estimationResults;

    // int 品質評価結果配列のインデックス
    private $selectedIndex;

    function __construct($estimationResults = array(), $selectedIndex = 0)
    {
        $this->setEstimationResults($estimationResults);
        $this->setSelectedIndex($selectedIndex);
    }

    public function setEstimationResults($estimationResults)
    {
        $this->estimationResults = $estimationResults;
    }

    public function getEstimationResults()
    {
        return $this->estimationResults;
    }

    public function setSelectedIndex($selectedIndex)
    {
        $this->selectedIndex = $selectedIndex;
    }

    public function getSelectedIndex()
    {
        return $this->selectedIndex;
    }

}
