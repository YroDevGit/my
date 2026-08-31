<?php //route: task/sendComment

//Add codes here...

use Classes\Response;
use Models\Routetasking;
use Models\TaskModel;

$task = get_decrypt("task");
$comment = post("comment");

if(! $task){
    Response::code(422)->message("ID ERROR")->send();
}
if(! $comment){
    Response::code(422)->message("Comment is required")->send();
}
Routetasking::route($task, TaskModel::getCurrentStatus($task), TaskModel::getCurrentAssignee($task), $comment, null, 2);

Response::code(200)->message("OK")->send();