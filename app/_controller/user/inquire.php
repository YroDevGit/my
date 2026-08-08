<?php //route: user/inquire

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Classes\Validator;
use Tables\Emails;
use Tables\Inquiry_type;

$iTable = Inquiry_type::table();

$email = Validator::body("email")->label("Email")->required()->maxChars(100)->email()->run();
$message = Validator::body("message")->label("Message")->required()->minChars(30)->maxChars(500)->run();
$type = Validator::body("type")->label("Inquiry type")->required()->in_table($iTable.":id")->run();

if($errors = Validator::errors()){
    Response::code(400)->message("Validation failed")->errors($errors)->send();
}

Emails::insert([
    "email" => $email,
    "message" => $message,
    "itype" => $type
]);

Ctrx::throttle(1, 300);

Response::code(200)->send();