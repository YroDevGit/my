<?php

use Classes\Ctrx;
use Classes\Router;

//Public route
Router::group(
    ["get" => "admin/add"],
    ["get" => "user/add"],
    ["post" => "user/inquire"],
    ["get" => "inquiry_type/get"]
);


//Login route
Router::group(
    ["post" => "user/login"]
)->run(
    function(){
        Ctrx::throttle(5, 180);
    }
);


//Auth route group 1 (g1)
Router::group(
    ["delete"=> "inquiries/delete"],
    ["post" => "note/add"],
    ["get" => "note/get"],
    ["delete" => "note/delete"],
    ["post" => "project/add"],
    ["get" => "client/get"],
    ["delete" => "project/delete"],
    ["get" => "project/getById"],
    ["put" => "project/update"]
    
)->middleware("g1");
