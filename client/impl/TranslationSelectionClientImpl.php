<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/24
 * Time: 0:34
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/ServiceClientImpl.php';
require_once dirname(__FILE__).'/../TranslationSelectionClient.interface.php';

class TranslationSelectionClientImpl extends ServiceClientImpl implements TranslationSelectionClient
{
    public function translate(Language $sourceLang, Language $targetLang, /*String*/ $source)
    {
        return $this->invoke(__FUNCTION__ ,array(
            'sourceLang' => $sourceLang,
            'targetLang' => $targetLang,
            'source' => $source
        ));
    }
}
