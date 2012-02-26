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
        array('dictionary_contents')
    );

    static $validates_presence_of = array(
        array('dictionary_id')
    );

    public function get_contents($withAllProperty = false) {
        $result = array();
        foreach($this->dictionary_contents as $content) {
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

    public function get_contents_as_ordered_array(array $languageOrder){
        $contents = $this->get_contents();

        return array_map(function($lang) use ($contents){
            return @$contents[$lang];
        }, $languageOrder);
    }

    /*
     * $params: (language => text)
     * [example] update_contents(array('ja' => '京都', 'en' => 'Kyoto'), '1');
     */
    public function update_contents(array $params = array(), $update_user = ''){
        $dictionary_contents = $this->get_dictionary_contents_as_hash();

        foreach($params as $language => $text) {
            $parameter = array('language' => $language, 'text' => $text);

            if(@$dictionary_contents[$language]) {
                if($update_user) $parameter['updated_by'] = $update_user;
                $dictionary_contents[$language]->update_attributes($parameter);
            } else {
                if($update_user) {
                    $parameter = array_merge($parameter, array(
                        'created_by' => $update_user, 'updated_by' => $update_user)
                    );
                }
                $this->create_dictionary_contents($parameter);
            }
        }

        return $this;
    }

    private function get_dictionary_contents_as_hash(){
        $result = array();
        foreach($this->dictionary_contents as $content) {
            $result[$content->language] = $content;
        }
        return $result;
    }

    static function count_by_dictionary_id_and_language($dictionary_id, Language $languageCode){
        $counts = self::count_by_dictionary_id_and_languages($dictionary_id);
        return @$counts[$languageCode.''];
    }

    static function count_by_dictionary_id_and_languages($dictionary_id){
        $records = self::all(array(
            'select' => 'count(*) as count, language',
            'joins' => array('dictionary_contents'),
            'conditions' => array('dictionary_id' => $dictionary_id),
            'group' => 'language'
        ));

        $intermediate = array_map(function($record){ return $record->attributes(); }, $records);

        $result = array();
        foreach($intermediate as $e) {
            $result[$e['language']] = intval($e['count']);
        }
        return $result;
    }

    static function create_record($dictionary_id, array $params = array(), $create_user = '') {

        $dictionary_record = self::create(array('dictionary_id' => $dictionary_id));

        if($dictionary_record->is_invalid()) MLSException::create('validate error');

        $dictionary_record->update_contents($params, $create_user);
    }
}
