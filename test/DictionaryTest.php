<?php
/**
 * Author: Tetsuro Higuchi
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__) . '/../models/Dictionary.php';

class DictionaryTest extends PHPUnit_Framework_TestCase
{
    private $dictionary;

    public function setUp(){

    }

    public function testHoge(){
        $this->assertFalse(true, "default");
    }


}
