<?php
require 'vendor/autoload.php';
$config = require './config/departmentCode.php';

use Pengjie\CyutCrawler\CyutCourse;
use Pengjie\Config\DB;

/*
|--------------------------------------------------------------------------
| 各學院代號總覽
|--------------------------------------------------------------------------
|
| 資訊學院：
| 資通系 - TJ9
| 資工系 - TJ4
| 資管系 - TJ2
|
| 管理學院：
| 財金系 - TC6
| 企管系 - TC7
| 保險系 - TC8
| 會計系 - TC9
| 休閒系 - TCA
| 行銷系 - TCJ
| 銀髮系 - TCL
|
| 理工學院：
| 營建系 - TD4
| 工管系 - TD5
| 應化系 - TD6
| 環管系 - TD7
|
| 設計學院：
| 建築系 - TE2
| 工設系 - TE3
| 視傳系 - TE4
| 景都系 - TE5
|
| 人文學院：
| 傳播系 - TF1
| 應英系 - TF2
| 幼保系 - TF3
| 社工系 - TF4
|
*/

$cyut = new CyutCourse($config);

// Enter `year`, `semester` and `departmentCode` into function.
$result = $cyut->crawlingDepartmentCourses(104, 2, 'TJ9');
r($result); // see result.

// Instance DB class and use `fetchCourses` method insert course to database.
// $db = new DB;
// r($db->fetchCourses($result));
