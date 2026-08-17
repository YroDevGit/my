<?php //route: project/add

//Add codes here...

use Classes\Response;
use Classes\Validator;
use Tables\Projects;
use Tables\Inquiry_type;
use Tables\Clients;

$clientTbl = Clients::table();
$projectTypeTbl = Inquiry_type::table();
$projectTbl = Projects::table();

$name = Validator::body("name")->required()->label("Project name")->unique("$projectTbl:name")->maxChars(50)->exec();
$description = Validator::body("description")->required()->label("Description")->minChars(30)->maxChars(1000)->exec();
$client = Validator::body("client")->required()->label("Client")->in_table("$clientTbl:id")->number()->exec();
$date = Validator::body("date")->required()->label("Date")->exec();
$type = Validator::body("type")->required()->label("Project type")->in_table("$projectTypeTbl:id")->number()->exec();

if($errors = Validator::errors()){
    Response::code(422)->errors($errors)->send();
}

Projects::insert([
    "name" => $name,
    "description" => $description,
    "client" => $client,
    "date" => dbDate($date),
    "type" => $type
]);

Response::code(200)->message("OK")->send();