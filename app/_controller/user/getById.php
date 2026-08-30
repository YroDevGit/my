<?php //route: user/getById

//Add codes here...

use Classes\Response;
use Tables\Users;

$id = get_user_data("id");

if(! $id){
    sendResponse(code:422, message:"User id error");
}
$getUser = Users::findOne($id);

if(! $getUser){
    Response::code(422)->message("User error")->send();
}

sendResponse(code:200, message:"OK", data:$getUser);