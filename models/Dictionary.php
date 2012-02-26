<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/14
 * Time: 16:22
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/MLSModel.php';

class Dictionary extends MLSModel
{

    static $has_many = array(
        array('records', 'class_name' => "DictionaryRecord"),
        array('dictionary_languages')
    );

    function add_language(Language $language){
        return $this->create_languages(array('language' => $language->getTag()));
    }
    
    function deploy(){

    }

    function undeploy(){

    }

    function count_records_by_language(){

    }

    function get_languages(){
        return array_map(function($lang){
            return $lang->language;
        }, $this->dictionary_languages);
    }

    function records_count(){
        return count($this->records);
    }

    function to_json(array $options=array()){
        $options = array_merge($options, array('except' => array('delete_flag','user_read','user_write','any_read','any_write')));
        return parent::to_json($options);
    }

    function to_xml(array $options=array()){
        $options = array_merge($options, array('except' => array('delete_flag','user_read','user_write','any_read','any_write')));
        return parent::to_xml($options);
    }

    // -- static -----------------------------------

    static function create_all($params){

    }

    static function count_by_id_and_language($id, $languageCodes){

    }
}
