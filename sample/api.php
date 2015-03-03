<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2015/02/03
 * Time: 0:11
 */
require __DIR__ . "/../vendor/autoload.php";
use Chatbox\Album\HTTP\API;

\Chatbox\PHPUtil::bootEloquent("mysql://root@127.0.0.1/misaki");
\Chatbox\PHPUtil::getEloquent()->enableQueryLog();

$config = API::config();
$config->load(__DIR__."/../appconfig.php");

$api = new API();
$api->setConfig($config)->run();


