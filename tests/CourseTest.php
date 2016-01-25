<?php

use Pengjie\CyutCrawler\CyutCourse;

class CourseTest extends PHPUnit_Framework_TestCase
{
    public function testCourse()
    {
        $config = ([
            'URI' => 'https://admin.cyut.edu.tw/crsinfo/cur_01.asp',
            'classType' => ['A', 'B', 'C'],
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
        $course = new CyutCourse($config);

        $result = $course->crawlingDepartmentCourses(104, 2, 'TJ9'); // 資通系

        $this->assertEquals(104, $result[6][0]); // 104 年度
        $this->assertEquals(4, $result[6][1]); // 4 年級

    }
}