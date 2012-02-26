<?php
/**
 * Author: Tetsuro Higuchi
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/../test_settings.php';
require_once dirname(__FILE__).'/../DatabaseLoader.php';

class DictionaryTest extends PHPUnit_Framework_TestCase
{
    private $dictionary;

    public function setUp(){
        $this->conn = ActiveRecord\ConnectionManager::get_connection();

        $loader = new DatabaseLoader($this->conn);
        $loader->reset_table_data();
    }

    public function testFind(){
        $dict = Dictionary::find(1);
        $this->assertEquals('test_dict', $dict->name);
    }

    public function testFind2(){
        $dict = Dictionary::find_by_name('test_dict');
        $this->assertEquals('test_dict', $dict->name);
    }

    public function testFind3(){
        $dict = Dictionary::first(array('conditions'=> "name like 'sample%'"));
        $this->assertEquals('sample_dict', $dict->name);
    }

    public function testAll(){
        $dicts = Dictionary::all();
        $this->assertTrue(count($dicts) == 2);
    }

    public function testCreate(){
        $dict = Dictionary::create(array('name' => 'created by unittest', 'licenser' => 'created by unittest'));
        $readDict = Dictionary::find($dict->id);

        $this->assertEquals($dict->name, $readDict->name);
        $this->assertEquals($dict->licenser, $readDict->licenser);
    }

    public function testUpdate1(){
        $name = 'changed name1';
        $dict = Dictionary::create(array('name' => 'created by testUpdate', 'licenser' => 'created by testUpdate license'));
        $dict->update_attributes(array('name' => $name));
        $readDict = Dictionary::find($dict->id);
        $this->assertEquals($readDict->name, $name);
    }

    public function testUpdate2(){
        $name = 'changed name2';
        $dict = Dictionary::create(array('name' => 'created by testUpdate', 'licenser' => 'created by testUpdate license'));
        $dict->update_attribute('name', $name);
        $readDict = Dictionary::find($dict->id);
        $this->assertEquals($readDict->name, $name);
    }

    public function testUpdate3(){
        $name = 'changed name3';
        $dict = Dictionary::create(array('name' => 'created by testUpdate', 'licenser' => 'created by testUpdate license'));
        $dict->name = $name;
        $dict->save();
        $readDict = Dictionary::find($dict->id);
        $this->assertEquals($readDict->name, $name);
    }

    public function testFindInclude(){
        $dict = Dictionary::first(array(
            'include' => 'records'
        ));
        $this->assertTrue(count($dict->records) == 5);
    }

    public function testRecords_count(){
        $dict = Dictionary::find(1);
        $this->assertTrue($dict->records_count() == 5);
    }

    public function testGet_languages(){
        $dict = Dictionary::find(1);
        $this->assertTrue(count($dict->get_languages()) == 2);
        $this->assertTrue(in_array('ja', $dict->get_languages()));
        $this->assertTrue(in_array('en', $dict->get_languages()));
    }

//    public function testAdd_language(){
//        $dict = Dictionary::find(1);
//        $dict->add_language(Language::get('zh'));
//
//        $readDict = Dictionary::find(1);
//        $this->assertTrue(count($readDict->get_languages()) == 3);
//        $this->assertTrue(in_array('zh', $readDict->get_languages()));
//    }
//
//    public function testAdd_language_validate_unique(){
//        $dict = Dictionary::find(1);
//        try {
//            $dict->add_language(Language::get('en'));
//            $this->assertTrue(false, 'failure validate unique');
//        } catch(ActiveRecord\DatabaseException $e) {
//
//        }
//    }
}
