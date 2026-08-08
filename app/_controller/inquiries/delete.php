<?php //route: inquiries/delete

//Add codes here...

use Classes\Request;
use Classes\Response;
use Tables\Emails;

$id = Request::post_decrypt("id");

if(! $id){
    Response::code(401)->message("id is required")->send();
}

$rows = Emails::delete($id);

Response::code(200)->var(["affected_row"=>$rows])->send();