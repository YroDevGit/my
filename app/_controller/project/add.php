<?php //route: project/add

//Add codes here...

use Classes\Response;
use Classes\Validator;

$name = Validator::body("name")->required()->label("Project name")->maxChars(50)->exec();
$description = Validator::body("description")->required()->label("Description")->minChars(30)->maxChars(1000)->exec();
$client = Validator::body("client")->required()->label("Client")->number()->exec();
$date = Validator::body("date")->required()->label("Date")->exec();
$type = Validator::body("type")->required()->label("Project type")->number()->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->send();
}
