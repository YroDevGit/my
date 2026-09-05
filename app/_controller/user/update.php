<?php //route: user/update

//Add codes here...

use Classes\CtrStorage;
use Classes\File;
use Classes\Response;
use Classes\Validator;
use Tables\Users;

$id = get_user_data("id");
if (! $id) {
    Response::code(421)->message("User id error")->send();
}
$fname = Validator::body("fname")->required()->maxChars(50)->alpha()->label("First name")->exec();
$lname = Validator::body("lname")->required()->maxChars(50)->alpha()->label("Last name")->exec();

$file = File::get("img");
$filename = post("_img");

if($file){
    $filename = CtrStorage::upload_file($file);
}

if(! $filename || $file){
    $img = Users::findOne($id);
    $pict = val($img['img'], "");
    if($pict){
        CtrStorage::delete_files($pict);
    }
}

if (post("password")) {
    $password = Validator::body("password")->required()->minChars(8)->label("Password")->maxChars(70)->exec();
    $reenter = Validator::body("repassword")->required()->minChars(8)->label("Re-enter password")->maxChars(70)->exec();
    if ($reenter) {
        if ($password !== $reenter) {
            Validator::add_error("repassword", "Password not matched");
        }
    }
}

if ($errors = Validator::errors()) {
    sendResponse(code: 422, errors: $errors);
}

if (post("password")) {
    Users::update($id, [
        "fname" => $fname,
        "lname" => $lname,
        "password" => $password,
        "img" => $filename
    ]);
} else {
    Users::update($id, [
        "fname" => $fname,
        "lname" => $lname,
        "img"=> $filename
    ]);
}
sendResponse(code:200);