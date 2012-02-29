<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/02/29
 * Time: 23:12
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/Dictionary.php';

class DictionaryLegacyWrapper
{
    const TYPE_ID_DICTIONARY = 0;
    const TYPE_PARALLEL_TEXT = 1;

    /*
     * use instead of UserDictionaryController::doCreate
     */
    public function doCreate($params, $userId = '') {
        $dict = null;

        $typeId = $params['dictionaryTypeId'];

        if($typeId == TYPE_ID_DICTIONARY) {
            $dict = Dictionary::create_with_records(array(
                'name' => $this->escape($params['dictionaryName']),
                'languages' => $params['supportedLanguages'],
                'records' => $params['records']
            ), $userId);
        }

        if($params['deployFlag'] === true) {
            $dict->deploy();
        }

        return array(
            'status' => 'OK',
            'dictionaryId' => $dict->id
        );
    }

    /*
     * use instead of UserDictionaryController::doUpdate
     */
    public function doUpdate($params) {

    }

    /*
     * use instead of UserDictionaryController::doDownload
     */
    public function doDownload($dictionaryId) {
        $dict = Dictionary::find(intval($dictionaryId));
        $records = DictionaryRecord::find_by_dictionary_id(intval($dictionaryId));

        $lines = array();
        $languages = $dict->get_languages();
        $lines[] = implode('\t', $languages);
        foreach($dict->dictionary_records as $record) {
            $row = $record->get_contents_as_ordered_array($languages);
            $lines[] = implode('\t', $row);
        }

        $output = implode(PHP_EOL, $lines);
        $output .= PHP_EOL;

        $output = chr(255).chr(254).mb_convert_encoding($output, "UTF-16LE", "UTF-8");
        return array(
            "output" => $output,
            "name" => $this->getCleanFileName($dictionary['dictionary_name'])
        );
    }

    /*
     * use instead of UserDictionaryController::doUpload
     */
    public function doUpload($tmpFilePath, $typeId, $name, $editPermission, $readPermission, $mimeType) {
        $tmpFileLines = file($tmpFilePath);
        $code = mb_detect_encoding($tmpFileLines[0]);

        if (ord($tmpFileLines[0]{0}) == 255 && ord($tmpFileLines[0]{1}) == 254) {
            $code = "UTF-16LE";
        } else if (ord($tmpFileLines[0]{0}) == 254 && ord($tmpFileLines[0]{1}) == 255) {
            $code = "UTF-16BE";
        } else {
            $code = '';
        }
        if ($code == '') {
            $error = '_MI_DICTIONARY_ERROR_FILE_FORMAT_INVALID';
            return $this->_doUploadErrorResponse($error);
        }

        $tmpFileContent = '';
        foreach($tmpFileLines as $aline) {
            $tmpFileContent .= $aline;
        }

        $utf8content = mb_convert_encoding($tmpFileContent, 'UTF-8', $code);
        if (ord($utf8content{0}) == 0xef && ord($utf8content{1}) == 0xbb && ord($utf8content{2}) == 0xbf) {
            $utf8content = substr($utf8content, 3);
        }

        $lines = array();
        $temp = fopen('php://memory', 'rw');
        fwrite($temp, $utf8content);
        fseek($temp, 0);
        while (($cells = fgetcsv($temp, 10240, chr(0x09))) !== false) {			// chr(0x09) == \t
            $lines[] = $cells;
        }
        fclose($temp);

        $validColNums = false;
        foreach($lines as $aline){
            if ($aline == null || is_array($aline) === false || count($aline) == 0) {
                continue;
            }
            $rowArray = $aline;

            if(!$validColNums){
                $validColNums = array();
                for($i=0; $i<count($rowArray); $i++){
                    if(mb_strlen($rowArray[$i])>0){
                        $validColNums[] = $i;
                    }
                }
            }

            $tableRow = array();
            foreach($validColNums as $colNum){
                $tableRow[] = $rowArray[$colNum] ? $rowArray[$colNum] : "";
            }

            $dictTable[] = $tableRow;
        }

        $response = $this->doCreate(array(
            'dictionaryName' => $name,
            'viewPermission' => $editPermission,
            'editPermission' => $readPermission,
            'supportedLanguages' => $dictTable[0],
            'dictionaryTypeId' => $typeId,
            'records' => array_slice($dictTable, 1)
        ));

        if (strtoupper($response['status']) == 'ERROR') {
            return $this->_doUploadErrorResponse($response['message']);
        } else {
            return $this->_doUploadSuccessResponse(intval(@$response['dictionaryId']));
        }
    }

    private function _doUploadErrorResponse($error) {
        $scripts = <<<JS
			alert("{$error}");
			parent.DialogViewController.hideIndicator();
JS;
        return $this->_doUploadResponse($scripts);
    }

    private function _doUploadSuccessResponse($dictionaryId) {
        $scripts = <<<JS
			with(window.parent) {
				DialogViewController.ImportDictionary.afterImport({$dictionaryId});
			}
JS;
        return $this->_doUploadResponse($scripts);
    }

    /*
     * use instead of UserDictionaryController::doDeploy
     */
    public function deploy($dictionaryId) {
        $dict = Dictionary::find(intval($dictionaryId));
        if($dict) {
            $dict->deploy();
            return true;
        }
        return false;
    }

    /*
     * use instead of UserDictionaryController::doUndeploy
     */
    public function undeploy($dictionaryId) {
        $dict = Dictionary::find(intval($dictionaryId));
        if($dict && $dict->is_deploy()) {
            $dict->undeploy();
            return true;
        }
        return false;
    }

    /*
     * use instead of UserDictionaryController::getAllDictionariesByTypeId
     */
    public function getAllDictionariesByTypeId($typeId, $limit = 10, $offset = 0, $userId = '') {
        $resources = array();
        if($typeId == TYPE_ID_DICTIONARY) {
            $resources = Dictionary::all();
        }

        $results = array();
        foreach($resources as $dict) {
            $results[] = array(
                'supportedLanguages' => $dict->get_languages(),
                'createDateFormat' => formatTimestamp($dict->created_at, 'Y/m/d H:i'),
                'updateDateFormat' => formatTimestamp($dict->updated_at, 'Y/m/d H:i'),
                'view' => $dict->can_read($userId),
                'edit' => $dict->can_write($userId),
                'deployFlag' => $dict->is_deploy(),
                'delete' => $dict->is_owner($userId)
            );
        }
        return $results;

    }

    /*
     * use instead of UserDictionaryController::countAllDictionariesByTypeId
     */
    public function countAllDictionariesByTypeId($typeId) {
        if($typeId == TYPE_ID_DICTIONARY) {
            return Dictionary::count();
        }
        return 0;
    }

    /*
     * use instead of UserDictionaryController::getAllDictionaryContentsByDictionaryId
     */
    public function getAllDictionaryContentsByDictionaryId($dictionaryId, $limit = 10, $offset = 0) {
        $dict = Dictionary::find(intval($dictionaryId));
        $langs = $dict->get_languages();

        $langHash = array("row" => "0");
        foreach($langs as $l) $langHash[$l] = $l;

        $results = array($langHash);

        foreach($dict->dictionary_records as $record) {
            $tmprow = $record->get_contents();
            $tmprow['row'] = $record->id;
            $results[] = $tmprow;
        }

        return $results;
    }

    /*
     * use instead of UserDictionaryController::getPermission
     */
    public function getPermission($id) {

    }

    /*
     * use instead of UserDictionaryController::canChangePermission
     */
    public function canChangePermission($dictionaryId){

    }

    /*
     * use instead of UserDictionaryController::canEdit
     */
    public function canEdit($dictionaryId) {

    }

    public function getDictionary($id) {

    }

    public function countAllDictionaryContentsByDictionaryId($dictionaryId) {

    }

    public function canLoad($dictionaryId) {

    }

//    public function removeLanguagesAll($dictionaryId, $languages = array()) {
//
//    }
//
//    public function updateContentsAll($dictionaryId, $supportedLanguages, $records) {
//
//    }
//
//    public function createContentsAll($dictionaryId, $supportedLanguages, $records) {
//
//    }





    private function escape($str) {
        if ( get_magic_quotes_gpc() ) {
            $str = stripslashes( $str );
        }
        return mysql_real_escape_string($str);
    }



}
