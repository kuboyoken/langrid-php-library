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
        array('dictionary_records')
    );
}
