<?php //route: project/delete

//Add codes here...

use Classes\Request;
use Classes\Response;
use Tables\Projects;

$id = Request::get_decrypt("id");

if(! $id){
    Response::code(422)->message("id is required")->send();
}

Projects::delete($id);

Response::code(200)->send();