<?php
require 'vendor/autoload.php';

$config = require './config/config.example.php';
$depCode = require './config/departmentCode.php';

use Pengjie\CyutCrawler\CyutCourse;

// Get single coures information.
$cyut = new CyutCourse($config);
$body = $cyut->getSingleCoursesInfo()['body'];
$filterBody = $cyut->crawlerResult($body);
$result = $cyut->chunckResult($filterBody);
var_dump($result);

/*
 * Get department 1 - 4 grade courses information.
 *
 * $cyut = new CyutCourse($depCode);
 * $result = $cyut->crawlingDepartmentCourses(104, 2, 'TJ9');
 * var_dump($result);
 */

/*
 * If you would crawling courses into your database,
 * please setting 'config.example.php' and 'config/DB.php' config,
 * then execute `$cyut->coursesCrawler($result, $cyut->getCourse()['config']);`
 */
