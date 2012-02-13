<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/02/05
 * Time: 17:58
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__) . '/../test_settings.php';

class TranslationWithTemporalDictionaryClientTest extends PHPUnit_Framework_TestCase
{
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = ClientFactory::createTranslationWithTemporalDictionaryClient(SERVICE_GRID_BASE_URL.'kyotou.langrid:TranslationCombinedWithBilingualDictionary');
    }

    function testTranslate()
    {
        try{
            $result = $this->client->translate(Language::get('en'), Language::get('ja'), 'internet', array(new Translation('hello','こんばんは')), Language::get('ja'));
            $this->assertTrue(mb_strlen($result) > 0);
        } catch(Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
