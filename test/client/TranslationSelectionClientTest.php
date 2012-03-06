<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/02/05
 * Time: 17:56
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__) . '/../test_settings.php';

class TranslationSelectionClientTest extends PHPUnit_Framework_TestCase
{
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = ClientFactory::createTranslationSelectionClient(SERVICE_GRID_BASE_URL.'kyotou.langrid:KyotoUCLWT');
    }

    function testTranslate()
    {
        try{
            $result = $this->client->translate(Language::get('en'), Language::get('ja'), 'hello');
            $this->assertEquals('こんにちは', $result);
        } catch(Exception $e) {
            $this->assertTrue(false, "unexpected exception occurred:".$e->getMessage());
        }
    }
}
