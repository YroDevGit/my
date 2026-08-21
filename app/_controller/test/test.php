<?php //route: test/test

//Add codes here...

use Classes\Mail;
use Classes\Response;

$data = decrypt("KiDB-o7NPz2A43JWGAJiBDZyWC9tcnkzc0IwTnpoN2cwQUE9PQ");

Mail::to("tyronemalocon@gmail.com")->subject("Hello jasper")->message("Jasper palo")->send();


Response::code(200)->message("Success")->var(["a"=>$data])->send();