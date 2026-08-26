<?php //route: task/delete

//Add codes here...

use Classes\Request;
use Classes\Response;
use Tables\Task;

$task = Request::get_decrypt("task");

if(! $task){
    Response::code(422)->message("Task is required")->send();
}

$findTask = Task::findOne($task);

if(! $findTask){
    Response::code(422)->message("Task error")->send();
}

$status = val($findTask['status']);

if($status != 8 ){
    Response::code(422)->message("You can only delete rejected task")->send();
}

Task::delete($task);

Response::code(200)->message("OK")->send();
