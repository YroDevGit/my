<?php //route: chat/send

//Add codes here...

use Classes\Response;
use Tables\Chat;

$id = get_user_data("id");

$message = post("message");

if(! $message){
    Response::code(404)->message("Message not found")->send();
}

Chat::insert([
    "user"=> $id,
    "message" => $message
]);

sendResponse(200);