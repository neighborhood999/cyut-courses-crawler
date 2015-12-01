<?php
require 'vendor/autoload.php';
$config = require './config/config.example.php';

use Pengjie\CyutCrawler\CyutCourse;

$cyut = new CyutCourse($config);

$body = $cyut->getCourse()['body'];
$filterBody = $cyut->crawlerResult($body);
$result = $cyut->chunckResult($filterBody);
var_dump($result);

/*
 * If you would crawling courses into your database,
 * please setting 'config.example.php' and 'config/DB.php' config,
 * then execute `$cyut->coursesCrawler($result, $cyut->getCourse()['config']);`
 */
