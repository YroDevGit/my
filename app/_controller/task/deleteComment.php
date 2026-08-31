<?php //route: task/deleteComment

//Add codes here...

use Tables\TaskRoute;

$id = get_decrypt("id");
if(! $id){
    sendResponse(code:422, message:"ID ERROR");
}
TaskRoute::delete($id);

sendResponse(200);