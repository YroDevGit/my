<?php //route: inquiry_type/get

//Add codes here...

use Classes\Ctrx;
use Classes\Response;
use Tables\Inquiry_type;

$inq = Inquiry_type::getAll();

Response::code(200)->data($inq)->send();