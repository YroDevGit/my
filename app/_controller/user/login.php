<?php //route: user/login

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Classes\Validator;
use Tables\Users;

$email = Validator::body("email")->label("Email")->required()->maxChars(60)->email()->run();
$password = Validator::body("password")->label("Password")->required()->run();

if($errors = Validator::errors()){
    Response::code(400)->errors($errors)->send();
}

$findUser = Users::findOne([
    "email"=>$email
]);

if(! $findUser){
    Response::code(401)->message("Invalid Email")->send();
}

if($findUser['active'] == 0){
    Response::code(401)->message("User doesn't have an access to login")->send();
}

$emailPass = $findUser['password'];

if($password !== $emailPass){
    Response::code(401)->message("Incorrect password")->send();
}

if($findUser['type'] == 1){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("SA");
    Ctrx::access_tools();
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 2){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("AD");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 3){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("MG");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 4){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("SU");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 5){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("DV");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 6){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("QA");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 7){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("PM");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 8){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("CS");
    Response::code(200)->message("OK")->send();
}else if($findUser['type'] == 9){
    Ctrx::set_user_data([
        "id" => $findUser['id'],
        "email" => $findUser['email']
    ]);
    Ctrx::set_user_role("VS");
    Response::code(200)->message("OK")->send();
}else{
    Response::code(400)->message("Invalid User")->send();
}

Response::code(400)->message("Login error, please contact admin")->send();