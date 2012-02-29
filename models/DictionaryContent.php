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

    public static function find_all_by_dictionary_id($dictionary_id) {
        return self::all(array(
            'joins' => 'LEFT JOIN dictionary_records r ON dictionary_record_id = r.id',
            'conditions' => 'r.dictionary_id ='.$dictionary_id
        ));
    }

    public static function delete_all_by_dictionary_id_and_language($dictionary_id, Language $language) {
        return self::delete_all(array(
            'conditions' => 'dictionary_contents.language = "'.$language->getTag().'" AND EXISTS(SELECT * FROM dictionary_records WHERE dictionary_id = '.$dictionary_id.' AND id=dictionary_record_id)'
        ));
    }
}
