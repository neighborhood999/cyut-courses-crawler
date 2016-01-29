<?php

namespace Pengjie\Config;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB
{
    public function __construct()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'Your Database',
            'username'  => 'Your Account',
            'password'  => 'Your Password',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
    }

    public function insertToDatabase($year, $semester, $department, $grade, $className, $courses)
    {
        //
    }

    public function fetchCourses($result)
    {
        // Use `foreach` map result and get array parameter
        // `year`, `semester`, `department`, `grade`, `className`, `courses`.
        // We are use these parameters for insert to databse.
        // use `$this->insertToDatabase()` method.
    }
}