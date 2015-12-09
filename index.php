<?php
require 'vendor/autoload.php';
$depCode = require './config/departmentCode.php';

use Pengjie\CyutCrawler\CyutCourse;

$cyut = new CyutCourse($depCode);

// Enter `year`, `semester` and `departmentCode` into function.
$result = $cyut->crawlingDepartmentCourses(104, 2, 'TJ9');
var_dump($result);

/*
 * If you would crawling courses into your database,
 * please setting 'config/DB.php' config,
 * then you can set and execute `$cyut->coursesCrawler($data, $config)` this function.
 */
