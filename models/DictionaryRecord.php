<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/14
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/MLSModel.php';

class DictionaryRecord extends MLSModel
{
	static $belongs_to = array(
		array('dictionary')
	);

    static $has_many = array(
        array('contents', 'class_name' => 'DictionaryContent')
    );

    static function find_all_by_contents_text($parmas){

    }

    static function count_by_dictionary_id_and_language($id, /*string*/$languageCode){

    }

    static function count_by_dictionary_id_and_languages($id, array/*<String>*/$languageCodes){

    }

    public function get_contents($withAllProperty = false) {
        $result = array();
        foreach($this->contents as $content) {
            if($withAllProperty) {
                $result[$content->language] = array(
                    'text' => $content->text,
                    'created_at' => $content->created_at,
                    'updated_at' => $content->updated_at,
                    'created_by' => $content->created_by,
                    'updated_by' => $content->updated_by,
                );
            } else {
                $result[$content->language] = $content->text;
            }
        }
        return $result;
    }
}
