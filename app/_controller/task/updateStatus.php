<?php //route: task/updateStatus

//Add codes here...

use Classes\Request;
use Classes\Response;
use Models\Routetasking;
use Tables\Task;

$status = Request::get_decrypt("status");
$task = Request::post_decrypt("task");

if(! $status || ! $task){
    Response::code(422)->message("Request is not complete")->send();
}

Task::update($task, ["status"=>$status]);
Routetasking::route($task, $status, null);

Response::code(200)->message("OK")->send();