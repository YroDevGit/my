<?php //route: user/getG1

//Add codes here...

use Classes\DB;


$all = DB::query("select u.id, u.fname, u.lname, u.email, u.type, r.role_code, r.role_title from users u, roles r where u.type = r.id and r.group = 1");

sendResponse(code:200, data:$all);