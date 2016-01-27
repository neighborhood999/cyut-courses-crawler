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
}