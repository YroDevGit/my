<?php //route: project/getById

//Add codes here...

use Classes\Response;
use Tables\Projects;
use Classes\Request;

$id = Request::get_decrypt("id");
if(! $id){
    Response::code(422)->message("id is required")->send();
}

$data = Projects::findOne($id);

Response::code(200)->data($data)->send();
