<?php //route: client/get

//Add codes here...

use Classes\Response;
use Tables\Clients;

$clients = Clients::getAll();

Response::code(200)->data($clients)->send();
