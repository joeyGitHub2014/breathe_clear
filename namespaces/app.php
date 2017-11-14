<?php

namespace App;

include "project.php";

use Project\A as ProjectA;

class A {
    public static function get(){
        echo "App.A.get \n";
    }
}

class B
{
    public static function get()
    {
        echo "App.B.get \n";
    }

};

ProjectA::get();

A::get();

B::get();




