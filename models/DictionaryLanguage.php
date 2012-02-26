<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/02/26
 * Time: 10:24
 * To change this template use File | Settings | File Templates.
 */

require_once dirname(__FILE__).'/MLSModel.php';

class DictionaryLanguage extends MLSModel
{
    static $belongs_to = array(
        array('dictionary')
    );

    static $validates_presence_of = array(
        array('language')
    );

    public function validate() {
        $language = self::first(array(
            'conditions' => array('dictionary_id' => $this->dictionary_id, 'language' => $this->language)
        ));
        if($language) {
            $this->errors->add('language', 'already exists "'.$this->language.'"');
        }
    }

    public function __toString() {
        return $this->language;
    }
}
