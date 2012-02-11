<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 18:13
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/Language.php';

class MultihopTranslationResult
{
    // Language 翻訳元の言語
    private $sourceLang;
    // Array<Language> 中間言語
    private $intermediateLangs;
    // Language 翻訳先の言語
    private $targetLang;
    // String 翻訳する文字列
    private $source;

    function __construct($sourceLang, $intermediateLangs, $targetLang, $source)
    {
        $this->setSourceLang($sourceLang);
        $this->setIntermediateLangs($intermediateLangs);
        $this->setTargetLang($targetLang);
        $this->setSource($source);
    }

    public function setIntermediateLangs($intermediateLangs)
    {
        $this->intermediateLangs = $intermediateLangs;
    }

    public function getIntermediateLangs()
    {
        return $this->intermediateLangs;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSourceLang($sourceLang)
    {
        $this->sourceLang = $sourceLang;
    }

    public function getSourceLang()
    {
        return $this->sourceLang;
    }

    public function setTargetLang($targetLang)
    {
        $this->targetLang = $targetLang;
    }

    public function getTargetLang()
    {
        return $this->targetLang;
    }
}
