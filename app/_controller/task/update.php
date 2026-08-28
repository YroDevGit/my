<?php //route: task/update

//Add codes here...

use Classes\Response;
use Classes\Validator;
use Tables\Task;

$id = get_decrypt("id");

if(! $id){
    Response::code(421)->message("ID error")->send();
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

Task::update($id, [
    "title" => $title,
    "description" => $description,
    "img" => $img,
    "prio" => $prio,
    "assign" => val($assign),
    "deadline" => $deadline,
    "remarks" => $remarks
]);

Response::code(200)->send();