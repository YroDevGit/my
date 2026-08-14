<?php

//Middleware: g1
use Classes\Response;
use Classes\Ctrx;
use Tables\Roles;

/**
 * g1
 * Access only for Authenticated role except customer and visitors
 */

Ctrx::throttle(10);

if(! Ctrx::has_user_data()){
    Response::code(unauthorized_code)->message("Unauthorized access")->send(unauthorized_code);
}

$role = Ctrx::get_user_role();

$findRole = Roles::findOne(['role_code'=>$role, "group"=>1]);

if(! $findRole){
    Response::code(unauthorized_code)->message("Unauthorized access")->send(unauthorized_code);
}

define("myID", Ctrx::get_user_data("id"));