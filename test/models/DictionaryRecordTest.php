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

    public function testValidatePresenseDictionaryId(){
        $record = DictionaryRecord::create(array());
        $this->assertTrue($record->is_invalid(), 'failure validate presense: dictionary_id');
    }

    public function testGet_contents(){
        $records = DictionaryRecord::find(1);
        $contents = $records->get_contents();
        $this->assertEquals($contents['ja'], 'こんにちは');
        $this->assertEquals($contents['en'], 'hello');
    }

    public function testCount_by_dictionary_id_and_languages(){
        $result = DictionaryRecord::count_by_dictionary_id_and_languages(2);
        $this->assertTrue($result['ja'] == 5);
        $this->assertTrue($result['en'] == 4);
        $this->assertTrue($result['ko'] == 3);
    }

    public function testGet_contentsWithProperty(){
        $records = DictionaryRecord::find(1);
        $contents = $records->get_contents(true);
        $this->assertEquals($contents['ja']['text'], 'こんにちは');
        $this->assertEquals($contents['en']['text'], 'hello');
    }

    public function testCount_by_dictionary_id_and_language(){
        $count = DictionaryRecord::count_by_dictionary_id_and_language(1, Language::get("en"));
        $this->assertTrue($count == 5);
    }

    public function testGet_contents_as_ordered_array1(){
        $record = DictionaryRecord::find(1);
        $result = $record->get_contents_as_ordered_array(array('ja', 'en'));
        $this->assertEquals($result[0], 'こんにちは');
        $this->assertEquals($result[1], 'hello');
    }

    public function testGet_contents_as_ordered_array2(){
        $record = DictionaryRecord::find(1);
        $result = $record->get_contents_as_ordered_array(array('en', 'ja', 'zh'));
        $this->assertEquals($result[0], 'hello');
        $this->assertEquals($result[1], 'こんにちは');
        $this->assertEquals($result[2], '');
    }

    public function testUpdate_contents_basic() {
        $record = DictionaryRecord::find(2);
        $record->update_contents(array(
            'ja' => '午前'
        ));

        $readRecord = DictionaryRecord::find(2);
        $contents = $readRecord->get_contents();
        $this->assertEquals('午前', $contents['ja']);
    }

    public function testUpdate_contents_append() {
        $record = DictionaryRecord::find(6);
        $record->update_contents(array(
            'ja' => 'foo',
            'ko' => 'bar'
        ));

        $readRecord = DictionaryRecord::find(6);
        $contents = $readRecord->get_contents();
        $this->assertEquals('foo', $contents['ja']);
        $this->assertEquals('bar', $contents['ko']);
    }

    public function testUpdate_contents_basic_with_user() {
        $record = DictionaryRecord::find(2);
        $userId = '000001';
        $record->update_contents(array(
            'ja' => '午前'
        ), $userId);

        $readRecord = DictionaryRecord::find(2);
        $contents = $readRecord->get_contents(true);
        $this->assertEquals($userId, $contents['ja']['updated_by']);
    }

    public function testUpdate_contents_append_with_user() {
        $record = DictionaryRecord::find(6);
        $userId = '000002';
        $record->update_contents(array(
            'ko' => 'foobar'
        ), $userId);

        $readRecord = DictionaryRecord::find(6);
        $contents = $readRecord->get_contents(true);
        $this->assertEquals($userId, $contents['ko']['created_by']);
        $this->assertEquals($userId, $contents['ko']['updated_by']);
    }

    public function testCreateError(){
        try {
            DictionaryRecord::create_record(null, array());
            $this->assertTrue(false, 'validate exception did not occured');
        } catch(MLSException $mlse) {
            $this->assertTrue(true);
        } catch(Exception $e) {
            $this->assertTrue(false, 'unexpected exception occured'.$e->getMessage());
        }
    }
}
