<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/15
 * Time: 18:10
 * To change this template use File | Settings | File Templates.
 */
class LanguageAndEncoding
{
    // String 言語
    private $language;
    // String エンコーディング
    private $encoding;

    function __construct($language, $encoding)
    {
        $this->setLanguage($language);
        $this->setEncoding($encoding);
    }

    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    }

    public function getEncoding()
    {
        return $this->encoding;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function getLanguage()
    {
        return $this->language;
    }

}
