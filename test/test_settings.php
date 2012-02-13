<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tetsu
 * Date: 12/01/22
 * Time: 14:33
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(__FILE__) . '/../MultiLanguageStudio.php';

ClientFactory::setDefaultUserId('clg.nict');
ClientFactory::setDefaultPassword('hvpU7bqH');

define('SERVICE_GRID_BASE_URL', 'http://langrid.nict.go.jp/service_manager/wsdl/');

error_reporting(E_ALL);