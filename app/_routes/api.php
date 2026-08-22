<?php

use Classes\Ctrx;
use Classes\Request;
use Classes\Response;
use Classes\Router;

//Public route
Router::group(
    ["get" => "admin/add"],
    ["get" => "user/add"],
    ["post" => "user/inquire"],
    ["get" => "inquiry_type/get"]
);

Router::group(
    ["post" => "email/send"]
)->run(function(){
    $apikey = Request::headers("apikey");
    if(! $apikey){
        Response::code(unauthorized_code)->message("apikey not found")->send(unauthorized_code);
    }
    if($apikey !== env("default_apikey")){
        Response::code(unauthorized_code)->message("invalid apikey")->send(unauthorized_code);
    }
});


//Login route
Router::group(
    ["post" => "user/login"],
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
    ["put" => "project/update"],
    ["post" => "task/add"],
    ["put" => "task/updateStatus"],
    ["get" => "task/getById"]
    
)->middleware("g1");
