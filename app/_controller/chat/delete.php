<?php //route: chat/delete

//Add codes here...

use Classes\Response;
use Tables\Chat;

$id = get_user_data("id");

$chatId = get("id");

if(! $chatId || ! $id){
    sendResponse(422);
}

Chat::delete(["id"=>$chatId, "user"=>$id]);

Response::code(200)->send();
