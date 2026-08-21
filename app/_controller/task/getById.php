<?php //route: task/getById

//Add codes here...

use Classes\Request;
use Classes\Response;
use Tables\Task;

$id = Request::get_decrypt("id");

if(! $id){
    Response::code(422)->message("ID ERROR")->send();
}

$result = Task::findOne($id);

Response::code(200)->data($result)->send();