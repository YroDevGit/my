<?php //route: note/get

//Add codes here...

use Classes\Collection;
use Classes\Response;
use Tables\Note_category;

$id = get("id");

$data = [];

if($id){
    $data = Note_category::get(["id"=>$id]);
}else{
    $data = Note_category::getAll();
}

$data = Collection::data($data)->encrypt("id")->exec();

Response::code(200)->data($data)->exec();