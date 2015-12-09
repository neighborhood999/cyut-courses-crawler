<?php

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

/**
 * Setting search courses config.
 * ------------------------------
 * h_acy   => 學年度
 * h_sem   => 上、下學期
 * h_depno => 學院代號
 * h_secid => 部別(預設為日間部)
 * h_subid => 學程制(預設為四年制)
 * h_year  => 年級
 * h_class => 班級
 */

return ([
    'URI' => 'https://admin.cyut.edu.tw/crsinfo/cur_01.asp',
    'classType'  => ['A', 'B', 'C'],
    'config' => function ($year, $sem, $dep, $grade, $classType) {
        return [
            'h_status' => 'run',
            'h_acy'    => $year,
            'h_sem'    => $sem,
            'h_depno'  => $dep,
            'h_secid'  => 1,
            'h_subid'  => 4,
            'h_year'   => $grade,
            'h_class'  => $classType
        ];
    },
]);