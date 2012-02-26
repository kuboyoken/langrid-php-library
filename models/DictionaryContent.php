<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/14
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/MLSModel.php';

class DictionaryContent extends MLSModel
{
    static $belongs_to = array(
        array('dictionary_record')
    );

    static $validates_presence_of = array(
        array('dictionary_record_id'), array('language'), array('text')
    );

    //  can't use uniquness. because validation error occured on update too. I except that it should check only on create.
//    static $validates_uniqueness_of = array(
//        array('dictionary_record_id', 'language')
//    );

    public function validate() {

        $content = self::first(array(
            'conditions' => array('dictionary_record_id' => $this->dictionary_record_id, 'language' => $this->language)
        ));

        if($this->is_new_record() && $content) {
            $this->errors->add('language', 'already exists "'.$this->language.'"');
        }
    }

}
