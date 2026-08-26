<?php //route: task/update

//Add codes here...

use Classes\Response;

$id = get_decrypt("id");

if(! $id){
    Response::code(421)->message("ID error")->send();
}

