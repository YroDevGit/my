<?php //route: user/add

//Add codes here...

use Classes\DB;
use Classes\Mail;
use Classes\Random;
use Classes\Response;
use Classes\Validator;
use Tables\Roles;
use Tables\Users;

DB::bundle(function () {

    $roleTable = Roles::table();
    $userTable = Users::table();

    $fname = Validator::post("fname")->label("Firstname")->required()->alpha()->maxChars(100)->X();
    $lname = Validator::post("lname")->label("Lastname")->required()->alpha()->maxChars(100)->X();
    $phone = Validator::post("phone")->label("Phone number")->required()->maxChars(13)->X();
    $status = Validator::post("status")->label("Status")->required()->number()->in([1, 2])->X();
    $email = Validator::post("email")->label("Email")->required()->unique("$userTable:email")->email()->X();
    $role = Validator::post("role")->label("Role")->required()->decrypt()->number()->in_table("$roleTable:id")->X();

    if ($errs = Validator::errors()) {
        sendResponse(422, errors: $errs);
    }

    $password = Random::integer(6);



    Users::insert([
        "fname" => $fname,
        "lname" => $lname,
        "type" => $role,
        "email" => $email,
        "active" => $status,
        "password" => $password
    ]);

    $title = env("app_name");
    //Mail::to($email)->message("You are now a member of $title, your password is $password")->send();
});

Response::code(200)->send();
