<?php //route: note/delete

//Add codes here...

use Classes\Response;
use Tables\Notes;

$id = decrypt(post("id"));

if(! $id){
    Response::code(422)->message("id is required")->exec();
}

Notes::delete($id);

Response::code(200)->exec();