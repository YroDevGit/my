<?php //route: note/add

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Classes\Validator;
use Tables\Notes;
use Tables\Note_category;

$noteCategoryTable = Note_category::table();

$title = Validator::post("title")->required()->label("Title")->exec();
$desc = Validator::post("desc")->required()->label("Description")->exec();
$date = Validator::post("date")->required()->label("Date")->exec();
$category = Validator::post("category")->required()->label("Category")->decrypt()->in_table("$noteCategoryTable:id")->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->exec();
}

$create_notes = Notes::insert([
    "user_id" => myID,
    "title" => $title,
    "description" => $desc,
    "date" => $date,
    "category" => $category
]);

Response::code(200)->message("OK")->var(["id"=>$create_notes->insertID()])->exec();