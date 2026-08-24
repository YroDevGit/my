<?php //route: task/add

//Add codes here...

use Classes\Request;
use Classes\Response;
use Classes\Validator;
use Models\Routetasking;
use Tables\Task;


$project = Request::get_decrypt("id");

if(! $project){
    Response::code(401)->message("Project error")->send();
}

$title = Validator::post("title")->required()->label("Title")->exec();
$description = Validator::post("description")->label("Description")->required()->minChars(50)->maxChars(2000)->exec();
$img = Validator::post("img")->exec();
$prio = Validator::post("prio")->required()->label("Priority")->number()->in([1,2,3])->exec();
$assign = Validator::post("assign")->exec();
$deadline = Validator::post("deadline")->label("Deadline")->required()->exec();
$remarks = Validator::post("remarks")->maxChars(1000)->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->send();
}


$res = Task::insert([
    "project" => $project,
    "title" => $title,
    "description" => $description,
    "img" => $img,
    "prio" => $prio,
    "assign" => val($assign),
    "deadline" => $deadline,
    "remarks" => $remarks
]);

$id = $res->_id();

Routetasking::route($id, 1, val($assign));

Response::code(200)->message("OK")->send();

