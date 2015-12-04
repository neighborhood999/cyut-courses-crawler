<?php

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