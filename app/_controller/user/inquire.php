<?php //route: user/inquire

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Classes\Validator;
use Tables\Emails;

$email = Validator::body("email")->label("Email")->required()->maxChars(100)->email()->run();
$message = Validator::body("message")->label("Message")->required()->minChars(30)->maxChars(500)->run();

if($errors = Validator::errors()){
    Response::code(400)->message("Validation failed")->errors($errors)->send();
}

Emails::insert([
    "email" => $email,
    "message" => $message
]);

Ctrx::throttle(1, 300);

Response::code(200)->send();