<?php //route: email/send

//Add codes here...

use Classes\Mail;
use Classes\Response;
use Classes\Validator;

$to = Validator::post("to")->required()->email()->exec();
$from = Validator::post("from")->required()->email()->exec();
$sender = Validator::post("sender")->required()->email()->exec();
$subject = Validator::post("subject")->required()->maxChars(100)->exec();
$message = Validator::post("message")->required()->maxChars(500)->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->send();
}

//$sent = Mail::to($to)->subject($subject)->message($message)->fromEmail($from)->from($sender)->send();

Response::code(200)->message("OK")->send();