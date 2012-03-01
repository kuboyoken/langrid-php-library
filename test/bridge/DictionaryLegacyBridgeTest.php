<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/03/01
 * Time: 16:32
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/../test_settings.php';
require_once dirname(__FILE__).'/../DatabaseLoader.php';
require_once dirname(__FILE__).'/../../bridge/DictionaryLegacyBridge.php';

class DictionaryLegacyBridgeTest extends PHPUnit_Framework_TestCase
{
    public function setUp(){
        $this->conn = ActiveRecord\ConnectionManager::get_connection();

        $loader = new DatabaseLoader($this->conn);
        $loader->reset_table_data();
    }

    public function testGetPermission(){
        $permission = DictionaryLegacyBridge::getPermission(2);
        $this->assertEquals($permission['dictionary']['view'], 'user');
        $this->assertEquals($permission['dictionary']['edit'], 'user');
    }

    public function testGetPermission2(){
        $permission = DictionaryLegacyBridge::getPermission(3);
        $this->assertEquals($permission['dictionary']['view'], 'all');
        $this->assertEquals($permission['dictionary']['edit'], 'user');
    }

    public function testGetPermission3(){
        $permission = DictionaryLegacyBridge::getPermission(4);
        $this->assertEquals($permission['dictionary']['view'], 'user');
        $this->assertEquals($permission['dictionary']['edit'], 'all');
    }

    public function testDoCreate(){
        $result = DictionaryLegacyBridge::doCreate(array(
            'dictionaryName' => 'legacyDictName',
            'supportedLanguages' => array('ja', 'en', 'ko'),
            'records' => array(
                array('hoge', 'hoge', 'hoge'),
                array('foo', 'foo', 'foo')
            ),
            'dictionaryTypeId' => 0
        ), 5);

        $dict = Dictionary::find($result['dictionaryId']);
        $this->assertEquals($dict->name, 'legacyDictName');
        $this->assertTrue(count($dict->get_languages()) == 3);

    }

    public function testDoDownload() {
        $result = DictionaryLegacyBridge::doDownload(1);
        var_dump($result);

    }
}
