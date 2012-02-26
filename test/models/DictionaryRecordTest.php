<?php
/**
 * Author: Tetsuro Higuchi
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/../test_settings.php';
require_once dirname(__FILE__).'/../DatabaseLoader.php';

class DictionaryRecordTest extends PHPUnit_Framework_TestCase
{

    public function setUp(){
        $this->conn = ActiveRecord\ConnectionManager::get_connection();

        $loader = new DatabaseLoader($this->conn);
        $loader->reset_table_data();
    }

    public function testGet_ontents(){
        $records = DictionaryRecord::find(1);
        $contents = $records->get_contents();
        $this->assertEquals($contents['ja'], 'こんにちは');
        $this->assertEquals($contents['en'], 'hello');
    }

    public function testGet_contentsWithProperty(){
        $records = DictionaryRecord::find(1);
        $contents = $records->get_contents(true);
        $this->assertEquals($contents['ja']['text'], 'こんにちは');
        $this->assertEquals($contents['en']['text'], 'hello');
    }

    public function testCount_by_dictionary_id_and_language(){
        $count = DictionaryRecord::count_by_dictionary_id_and_language(1, "en");
        $this->assertTrue($count == 5);
    }
}
