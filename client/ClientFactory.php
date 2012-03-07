<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/14
 * Time: 15:57
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__).'/ServiceClient.interface.php';
require_once dirname(__FILE__).'/impl/AdjacencyPairClientImpl.php';
require_once dirname(__FILE__).'/impl/BackTranslationClientImpl.php';
require_once dirname(__FILE__).'/impl/BackTranslationWithTemporalDictionaryClientImpl.php';
require_once dirname(__FILE__).'/impl/BilingualDictionaryClientImpl.php';
//require_once dirname(__FILE__).'/impl/BilingualDictionaryHeadwordsExtractionClientImpl.php';
require_once dirname(__FILE__).'/impl/BilingualDictionaryWithLongestMatchSearchClientImpl.php';
require_once dirname(__FILE__).'/impl/ConceptDictionaryClientImpl.php';
require_once dirname(__FILE__).'/impl/DependencyParserClientImpl.php';
//require_once dirname(__FILE__).'/impl/DictionaryClientImpl.php';
require_once dirname(__FILE__).'/impl/LanguageIdentificationClientImpl.php';
//require_once dirname(__FILE__).'/impl/MetadataForParallelTextClientImpl.php';
require_once dirname(__FILE__).'/impl/MorphologicalAnalysisClientImpl.php';
require_once dirname(__FILE__).'/impl/MultihopBackTranslationClientImpl.php';
require_once dirname(__FILE__).'/impl/MultihopTranslationClientImpl.php';
require_once dirname(__FILE__).'/impl/ParallelTextClientImpl.php';
//require_once dirname(__FILE__).'/impl/ParallelTextWithEmbeddedMetadataClientImpl.php';
require_once dirname(__FILE__).'/impl/ParaphraseClientImpl.php';
require_once dirname(__FILE__).'/impl/PictogramDictionaryClientImpl.php';
require_once dirname(__FILE__).'/impl/QualityEstimationClientImpl.php';
require_once dirname(__FILE__).'/impl/SimilarityCalculationClientImpl.php';
require_once dirname(__FILE__).'/impl/SpeechRecognitionClientImpl.php';
require_once dirname(__FILE__).'/impl/TemplateParallelTextClientImpl.php';
require_once dirname(__FILE__).'/impl/TextToSpeechClientImpl.php';
require_once dirname(__FILE__).'/impl/TranslationClientImpl.php';
require_once dirname(__FILE__).'/impl/TranslationSelectionClientImpl.php';
require_once dirname(__FILE__).'/impl/TranslationWithTemporalDictionaryClientImpl.php';


class ClientFactory
{
    private static $defaultUserId;
    private static $defaultPassword;
    private static $defaultOptions;

    public static function createClient($clientClass, $serviceClass, $serviceUrl){
    }

    /*
     * 隣接応答対サービス用のクライアントを作成する。
     * @param $url endpoint url
     */
    public static function createAdjacencyPairClient($url){
        return self::setup(new AdjacencyPairClientImpl($url));
    }

    /*
     * 折り返し翻訳サービス用のクライアントを作成する。
     * @param $url endpoint url
     */
    public static function createBackTranslationClient($url){
        return self::setup(new BackTranslationClientImpl($url));
    }

    /*
     * 一時辞書付き折り返し翻訳サービス用のクライアントを作成する。
     */
    public static function createBackTranslationWithTemporalDictionaryClient($url){
        return self::setup(new BackTranslationWithTemporalDictionaryClientImpl($url));
    }

    /*
     * 対訳辞書サービス用のクライアントを作成する。
     */
    public static function createBilingualDictionaryClient($url){
        return self::setup(new BilingualDictionaryClientImpl($url));
    }

    /*
     * extractをサポートする対訳辞書サービス用のクライアントを作成する。
     */
    public static function createBilingualDictionaryHeadwordsExtractionClient($url){
        return self::setup(new BilingualDictionaryHeadwordsExtractionClientImpl($url));
    }

    /*
     * 最適化版用の対訳辞書サービス用のクライアントを作成する。
     */
    public static function createBilingualDictionaryWithLongestMatchSearchClient($url){
        return self::setup(new BilingualDictionaryWithLongestMatchSearchClientImpl($url));
    }

    /*
     * 概念辞書サービス用のクライアントを作成する。
     */
    public static function createConceptDictionaryClient($url){
        return self::setup(new ConcptDictionaryClientImpl($url));
    }

    /*
     * 係り受け解析サービス用のクライアントを作成する。
     */
    public static function createDependencyParserClient($url){
        return self::setup(new DependencyParserClientImpl($url));
    }

    /*
     * 辞書サービス用のクライアントを作成する。
     */
    public static function createDictionaryClient($url) {}

    /*
     * 言語識別サービス用のクライアントを作成する。
     */
    public static function createLanguageIdentificationClient($url) {
        return self::setup(new LanguageIdentificationClientImpl($url));
    }

    /*
    * 用例対訳用メタデータサービス用のクライアントを作成する。
    */
    public static function createMetadataForParallelTextClient($url) {}

    /*
    * 形態素解析サービス用のクライアントを作成する。
    */
    public static function createMorphologicalAnalysisClient($url) {
        return self::setup(new MorphologicalAnalysisClientImpl($url));
    }

    /*
    * 複数ホップ折り返し翻訳サービス用のクライアントを作成する。
    */
    public static function createMultihopBackTranslationClient($url) {
        return self::setup(new MultihopBackTranslationClientImpl($url));
    }

    /*
    * 複数ホップ翻訳サービス用のクライアントを作成する。
    */
    public static function createMultihopTranslationClient($url) {
        return self::setup(new MultihopTranslationClientImpl($url));
    }

    /*
    * 用例対訳サービス用のクライアントを作成する。
    */
    public static function createParallelTextClient($url) {
        return self::setup(new ParallelTextClientImpl($url));
    }

    /*
    * ID付き用例対訳サービス用のクライアントを作成する。
    */
    public static function createParallelTextWithIdClient($url) {}

    /*
    * 内部メタデータ付き用例対訳サービス用のクライアントを作成する。
    */
    public static function createParallelTextWithMetadataClient($url) {}

    /*
    * 外部メタデータ付き用例対訳サービス用のクライアントを作成する。
    */
    public static function createParallelTextWithMetadataFromCandidateClient($url) {}

    /*
    * 言い換えサービス用のクライアントを作成する。
    */
    public static function createParaphraseClient($url) {
        return self::setup(new ParaphraseClientImpl($url));
    }

    /*
    * 絵文字辞書サービス用のクライアントを作成する。
    */
    public static function createPictogramDictionaryClient($url) {
        return self::setup(new PictogramDictionaryClientImpl($url));
    }

    /*
    * 品質評価用例サービス用のクライアントを作成する。
    */
    public static function createQualityEstimationClient($url) {
        return self::setup(new QualityEstimationClientImpl($url));
    }

    /*
    * 類似度計算サービス用のクライアントを作成する。
    */
    public static function createSimilarityCalculationClient($url) {
        return self::setup(new SimilarityCalculationClientImpl($url));
    }

    /*
    * 音声認識サービス用のクライアントを作成する。
    */
    public static function createSpeechRecognitionClient($url) {
        return self::setup(new SpeechRecognitionClientImpl($url));
    }

    /*
    * テンプレート用例サービス用のクライアントを作成する。
    */
    public static function createTemplateParallelTextClient($url) {
        return self::setup(new TemplateParallelTextClientImpl($url));
    }

    /*
    * 音声合成サービス用のクライアントを作成する。
    */
    public static function createTextToSpeechClient($url) {
        return self::setup(new TextToSpeechClientImpl($url));
    }

    /*
    * 翻訳サービス用のクライアントを作成する。
    */
    public static function createTranslationClient($url) {
        return self::setup(new TranslationClientImpl($url));
    }

    /*
    * 選択変換用例サービス用のクライアントを作成する。
    */
    public static function createTranslationSelectionClient($url) {
        return self::setup(new TranslationSelectionClientImpl($url));
    }

    /*
    * 一時辞書を使った翻訳サービス用のクライアントを作成する。
    */
    public static function createTranslationWithTemporalDictionaryClient($url) {
        return self::setup(new TranslationWithTemporalDictionaryClientImpl($url));
    }

    /*
    * 認証パスワードの初期値を設定する。
    */
    public static function setDefaultPassword($password) {
        self::$defaultPassword = $password;
    }

    /*
    * 認証ユーザIDの初期値を設定する。
    */
    public static function setDefaultUserId($userId) {
        self::$defaultUserId = $userId;
    }

    /*
     * SOAPクライアントのデフォルトオプションを設定する
     */
    public static function setDefaultSoapOptions($options = array()) {
        self::$defaultOptions = $options;
    }

    /*
     *　SOAPクライアントのデフォルトオプションを取得する。
     */
    public static function getDefaultSoapOptions() {
        return self::$defaultOptions;
    }

    /*
     * @return ServiceClient
     */
    private static function  setup(ServiceClient $serviceClient){
        if(self::$defaultUserId) {
            $serviceClient->setUserId(self::$defaultUserId);
        }
        if(self::$defaultPassword) {
            $serviceClient->setPassword(self::$defaultPassword);
        }
        return $serviceClient;
    }

}
