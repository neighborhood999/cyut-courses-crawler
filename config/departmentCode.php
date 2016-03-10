<?php

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

return [
    'URI' => 'https://admin.cyut.edu.tw/crsinfo/cur_01.asp',
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
];