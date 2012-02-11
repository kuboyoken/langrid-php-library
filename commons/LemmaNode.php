<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 17:52
 * To change this template use File | Settings | File Templates.
 */
class LemmaNode
{
    // String nodeID
    private $nodeId;
    // String 言語
    private $language;
    // String 見出し。表記
    private $headWord;
    // String 見出し。読み
    private $pronunciation;
    // String 品詞
    private $partOfSpeech;
    // String 分野名。国語辞書での[コンピュータ]等の分野指定に対応
    private $domain;
    // Array<String> 語義番号と概念ノードIDの配列((1 C1Je1))...
    private $conceptNodes;
    // Array<String> 関係名とノードID(lemma、concept)の配列((関係名 ノードID))...
    private $relations;

    function __construct($nodeId = '', $language = '', $headWord = '', $pronunciation = '', $partOfSpeech = '',
                         $domain = '', $conceptNodes = array(), $relations = array())
    {
        $this->setNodeId($nodeId);
        $this->setLanguage($language);
        $this->setHeadWord($headWord);
        $this->setPronunciation($pronunciation);
        $this->setPartOfSpeech($partOfSpeech);
        $this->setDomain($domain);
        $this->setConceptNodes($conceptNodes);
        $this->setRelations($relations);
    }

    public function setConceptNodes($conceptNodes)
    {
        $this->conceptNodes = $conceptNodes;
    }

    public function getConceptNodes()
    {
        return $this->conceptNodes;
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setHeadWord($headWord)
    {
        $this->headWord = $headWord;
    }

    public function getHeadWord()
    {
        return $this->headWord;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setNodeId($nodeId)
    {
        $this->nodeId = $nodeId;
    }

    public function getNodeId()
    {
        return $this->nodeId;
    }

    public function setPartOfSpeech($partOfSpeech)
    {
        $this->partOfSpeech = $partOfSpeech;
    }

    public function getPartOfSpeech()
    {
        return $this->partOfSpeech;
    }

    public function setPronunciation($pronunciation)
    {
        $this->pronunciation = $pronunciation;
    }

    public function getPronunciation()
    {
        return $this->pronunciation;
    }

    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    public function getRelations()
    {
        return $this->relations;
    }
}
