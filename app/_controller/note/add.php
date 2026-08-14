<?php //route: note/add

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Classes\Validator;
use Tables\Notes;

$title = Validator::post("title")->required()->label("Title")->exec();
$desc = Validator::post("desc")->required()->label("Description")->exec();
$date = Validator::post("date")->required()->label("Date")->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->exec();
}

$create_notes = Notes::insert([
    "user_id" => myID,
    "title" => $title,
    "description" => $desc,
    "date" => $date
]);

Response::code(200)->message("OK")->var(["id"=>$create_notes->insertID()])->exec();