<?php

use Classes\Ctrx;
use Classes\Page;
use Classes\Routing;
use Tables\Roles;
use Tables\Users;

Ctrx::role_filtering(); // Default role validation


Routing::group_page("user/login", function(){
    if(Ctrx::has_user_data()){
        $role = Ctrx::get_user_role();
        $findRedirect = Roles::findOne(["role_code"=>$role]);
        if($findRedirect){
            $redirect = $findRedirect['redirect'];
            redirect($redirect);
        }
    }
});

Routing::group_page("auth/*", function(){
    js("_auth/all");
    if(! Ctrx::has_user_data()){
        redirect_logout();
    }
});