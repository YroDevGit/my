<?php //route: note/get

//Add codes here...

use Classes\Collection;
use Classes\Response;
use Tables\Note_category;

$id = get("id");

$data = [];

if($id){
    $data = Note_category::get(["id"=>$id, "user_id"=>myID]);
}else{
    $data = Note_category::find(["user_id"=>myID]);
}

$data = Collection::data($data)->encrypt("id")->exec();

Response::code(200)->data($data)->exec();