<?php //route: task/getRoute

//Add codes here...

use Classes\Collection;
use Classes\DB;
use Classes\Hash;
use Tables\TaskRoute;

$id = get_decrypt("id");
if (! $id) {
    sendResponse(code: 422, message: "ID ERROR");
}

$data = DB::query("SELECT t.id,t.task,t.status,t.created_at,t.updated_at,(select concat(fname, ' ', lname) from users where id = t.assign) AS assignee,t.assign,t.comment,t.image,t.by,t.type,concat(u.fname, ' ',u.lname) 'byname', t.by FROM TaskRoute t LEFT JOIN users u ON t.by=u.id where t.task = $id;");
$data = Collection::data($data)->hash("by")->encrypt("id")->exec();
$lastQuery = DB::getLastQuery();
sendResponse(200, data: $data, message:$lastQuery, var:["my"=>Hash::hash(get_user_data("id"))]);
