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

    static $has_one = array(
        array('deployment', 'class_name' => 'DictionaryDeployment')
    );

    function remove($force = false) {
        if($force) {
            $this->delete();
        } else {
            $this->delete_flag = true;
            $this->save();
        }
    }

    function add_language(Language $language){
        $dictionary_language = $this->create_dictionary_languages(array('language' => $language->getTag()));
        if($dictionary_language->is_invalid()) MLSException::create($dictionary_language->errors->on('language'));
        return $dictionary_language;
    }

    function get_languages(){
        return array_map(function($lang){
            return $lang->language;
        }, $this->dictionary_languages);
    }

    function remove_language(Language $language, $force = false) {
        foreach($this->dictionary_languages as $dictionary_language) {
            if($dictionary_language->language == $language) {
                $dictionary_language->delete();
            }
        }

        if($force) {
            DictionaryContent::delete_all($this->id, $language);
        }
        $this->reload();
    }

    /*
     * $languages: (array<string>) [array of language code
     */
    function update_languages(array $languages = array(), $force_on_delete = false) {
        if(!$languages || count($languages) <= 1) {
            MLSException::create('languages need more than 2 language');
        }
        $creates = array_diff($languages, $this->get_languages());
        foreach($creates as $l) {
            $this->add_language(Language::get($l));
        }

        $deletes = array_diff($this->get_languages(), $languages);
        foreach($deletes as $l) {
            $this->remove_language(Language::get($l), $force_on_delete);
        }
    }

    function is_deploy() {
        return $this->deployment != null;
    }
    
    function deploy(){
        $this->create_deployment();
    }

    function undeploy(){
        if($this->is_deploy()) {
            $this->deployment->delete();
            $this->reload();
        }
    }

    /*
     * $params: (array<string, string>) {language => value}
     * $create_user: create user ID
     */
    function add_record($params = array(), $create_user = null) {
        $new_dictionary_record = $this->create_records();
        $new_dictionary_record->update_contents($params, $create_user);
        return $new_dictionary_record;
    }

    function records_count(){
        return count($this->records);
    }

    function list_records(/* ... */) {
        $options = static::extract_and_validate_options(func_get_args());
        if(!@$options['limit']) $options['limit'] = 2;
        if(!@$options['offset']) $options['offset'] = 3;
        return DictionaryRecord::find_all_by_dictionary_id($this->id, $options);
    }

    function count_records_each_language(){
        return DictionaryRecord::count_by_dictionary_id_each_languages($this->id);
    }

    function count_records_by_language(Language $language){
        return DictionaryRecord::count_by_dictionary_id_and_language($this->id, $language);
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
    /*
     * $params: {name => (string) name value,
     *           licenser => (string) <optional> licenser value,
     *           languages => (array<string>) languages codes,
     *           records => (array<array>) }
     * return: instance of Dictionary
     *
     * [example]
     * $dict = Dictionary::create_with_records(
     *      'name' => 'Dictionary Name'
     *      'licenser' => '',
     *      'languages' => array('ja', 'en'),
     *      'records' => array(
     *          array('こんにちは', 'hello'),
     *          array('今日', 'today'),
     *          array('京都', 'Kyoto'),
     *      )
     * );
     */
    static function create_with_records($params, $create_user = null){
        $dict = null;
        Dictionary::transaction(function() use ($params, $create_user, &$dict){
            $dict = Dictionary::create(array(
                'name' => $params['name'],
                'licenser' => @$params['licenser'],
                'created_by' => $create_user,
                'updated_by' => $create_user
            ));

            $dict->update_languages($params['languages']);

            foreach($params['records'] as $record) {
                if(count($record) > count($params['languages'])) {
                    MLSException::create('record count is many than language count. do rollback.');
                }
                $i = 0;
                $hash = array();
                foreach($record as $word) {
                    $language = $params['languages'][$i++];
                    if($word) {
                        $hash[$language] = $word;
                    }
                }

                if(count($hash)) {
                    $dict->add_record($hash, $create_user);
                }
            }
        });
        return $dict;
    }

    public static function first() {
        $options = self::add_args_delete_flag_off(func_get_args());
        return call_user_func_array('parent::'.__FUNCTION__, array($options));
    }

    public static function last() {
        $options = self::add_args_delete_flag_off(func_get_args());
        return call_user_func_array('parent::'.__FUNCTION__, array($options));
    }

    public static function all(/* ... */) {
        $options = self::add_args_delete_flag_off(func_get_args());
        return call_user_func_array('parent::'.__FUNCTION__, array($options));
    }

    public static function count(/* ... */) {
        $options = self::add_args_delete_flag_off(func_get_args());
        return call_user_func_array('parent::'.__FUNCTION__, array($options));
    }

    public static function first_with_deleted() {
        return call_user_func_array('parent::first', func_get_args());
    }

    public static function last_with_deleted() {
        return call_user_func_array('parent::last', func_get_args());
    }

    public static function all_with_deleted(/* ... */) {
        return call_user_func_array('parent::all', func_get_args());
    }

    public static function count_with_deleted(/* ... */) {
        return call_user_func_array('parent::count', func_get_args());
    }

    protected static function add_args_delete_flag_off($options) {
        $options = static::extract_and_validate_options($options);

        $conditions = @$options['conditions'];
        if($conditions) {
            if(is_string($conditions)) {
                $conditions .= ' AND delete_flag = 0';
            } else if(is_array($conditions)) {
                $conditions = array('delete_flag' => 0);
            }
            $options['conditions'] = $conditions;

        } else {
            $options['conditions'] = array('delete_flag' => 0);
        }
        return $options;
    }
}
