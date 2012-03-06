<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/22
 * Time: 15:58
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__) . '/../test_settings.php';

class BackTranslationClientTest extends PHPUnit_Framework_TestCase
{
    private $client;
    protected function setUp()
    {
        parent::setUp();
        $this->client = ClientFactory::createBackTranslationClient(SERVICE_GRID_BASE_URL.'kyotou.langrid:BackTranslation');
    }

    function testBackTranslate()
    {
        try{
            if(method_exists($this->client, 'backTranslate')) {
                $result = $this->client->backTranslate(Language::get('en'), Language::get('ja'), 'Hello');
            } else {
                $this->assertFalse(true, 'method not found: backTranslate');
            }
        } catch(Exception $e) {
            $this->assertTrue(false, "unexpected exception occurred:".$e->getMessage());
        }
    }
}
