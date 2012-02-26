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

    public function validate() {
        $content = self::first(array(
            'conditions' => array('dictionary_record_id' => $this->dictionary_record_id, 'language' => $this->language)
        ));
        if($content) {
            $this->errors->add('language', 'already exists "'.$this->language.'"');
        }
    }

}
