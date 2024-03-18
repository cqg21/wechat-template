<?php
require_once __DIR__ . '/../vendor/autoload.php';

use MillionMile\GetEnv\Env;

try {
    Env::loadFile('.env');
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
echo Env::get('test_1', 'default_value'), PHP_EOL;              //文件开头，没有在任何[xxxx]下，那么无需前缀
echo Env::get('database.hostname', 'default_value'), PHP_EOL;   //获取[database]下的hostname字段
echo Env::get('test_2', 'default_value'), PHP_EOL;              //在[database]下（不管是否换行），需要加前缀 database. 才能正确获取
echo Env::get('noexist_name', 'default_value'), PHP_EOL;        //不存在的值，获取不到，使用默认值default_value
