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

        return $course;
    }

    // This test have some problem => `cURL error`, I will find and solve.
    // /**
    //  * @depends testCourse
    //  */
    // public function testICE($course)
    // {
    //     $result = $course->crawlingDepartmentCourses(104, 2, 'TJ9'); // 資通系

    //     $this->assertEquals(104, $result[6][0]); // 104 年度
    //     $this->assertEquals(2, $result[6][1]); // 第二學期
    //     $this->assertEquals('資通系', $result[6][2]); // 系別
    //     $this->assertEquals(4, $result[6][3]); // 4 年級
    //     $this->assertEquals('A', $result[6][4]); // A 班
    //     $this->assertInternalType('array', $result[6][5]); // 課程相關資料
    // }

    /**
     * @depends testCourse
     */
    public function testFindDepartment($course)
    {
        $getDepartment = $course->findDepartment('TJ9');
        $this->assertEquals('資通系', $getDepartment);
    }

    /**
     * @expectedException
     * @depends testCourse
     */
    public function testFindDepartmentException($course)
    {
        $getDepartment = $course->findDepartment('fuck');
    }
}