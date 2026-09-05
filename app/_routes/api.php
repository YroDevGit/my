<?php

use Classes\Ctrx;
use Classes\Request;
use Classes\Response;
use Classes\Router;

//Public route
Router::group(
    makeRoute(method: "get", controller: "admin/add"),
    makeRoute(method: "get", controller: "user/add"),
    makeRoute(method: "post", controller: "user/inquire"),
    makeRoute(method: "get", controller: "inquiry_type/get"),
    makeRoute(method: "get", controller: "task/get")
);

Router::group(
    makeRoute(method:"post", controller:"email/send")
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
    makeRoute(method:"post", controller:"user/login", as:"login")
)->run(
    function(){
        Ctrx::throttle(5, 180);
    }
);


//Auth route group 1 (g1)
Router::group(
    makeRoute(method: "post", controller: "note/add"),
    makeRoute(method: "delete", controller: "inquiries/delete"),
    makeRoute(method: "get", controller: "note/get"),
    makeRoute(method: "delete", controller: "note/delete"),
    makeRoute(method: "post", controller: "project/add"),
    makeRoute(method: "get", controller: "client/get"),
    makeRoute(method: "delete", controller: "project/delete"),
    makeRoute(method: "get", controller: "project/getById"),
    makeRoute(method: "put", controller: "project/update"),
    makeRoute(method: "post", controller: "task/add"),
    makeRoute(method: "put", controller: "task/updateStatus"),
    makeRoute(method: "get", controller: "task/getById"),
    makeRoute(method: "get", controller: "task/getAssigne"),
    makeRoute(method: "delete", controller: "task/delete"),
    makeRoute(method: "put", controller: "task/update"),
    makeRoute(method: "get", controller:"user/getG1"),
    makeRoute(method: "get", controller:"user/getById"),
    makeRoute(method: "post", controller:"user/update"),
    makeRoute(method:"get", controller:"task/getRoute"),
    makeRoute(method:"post", controller:"task/sendComment"),
    makeRoute(method: "delete", controller:"task/deleteComment"),
    makeRoute(method:"post", controller:"user/add"),
    makeRoute(method:"post", controller:"chat/send"),
    makeRoute(method:"get", controller:"chat/recieve"),
    makeRoute(method:"delete", controller:"chat/delete")
)->middleware("g1");
