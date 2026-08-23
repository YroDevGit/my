<?php //route: task/getAssigne

//Add codes here...

use Classes\Request;
use Classes\Response;
use Tables\Task;
use Tables\Users;

$task = Request::get_decrypt("task");

if(! $task){
    Response::code(404)->message("Task error")->send();
}

$getTask = Task::findOne($task);

if(! $getTask){
    Response::code(404)->message("Task not found.!")->send();
}

$assign = val($getTask['assign']);

if(! $assign){
    Response::code(200)->data([])->send();
}

$user = Users::findOne($assign);

Response::code(200)->data($user)->send();