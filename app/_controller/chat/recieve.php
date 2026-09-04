<?php //route: chat/recieve

//Add codes here...

use Classes\Collection;
use Tables\Chat;
use Tables\Users;

$id = get_user_data("id");
$result = Chat::paginatedFind([], 1, 20, ["order by"=> "created_at desc"]);
$users = Users::getAll();
$usersArray = Collection::array_column($users, null, "id");

$allChat = $result['data'];

$allChat = Collection::data($allChat)->addColumn(function($row) use($id){
    if($row["user"] == $id){
        return ["owner"=> "yes"];
    }else{
        return ["owner"=> "no"];
    }
})->exec();

$allChat = Collection::data($allChat)->addColumn(function($row) use($id, $usersArray){
    return ["img"=>val($usersArray[$row['user']]["img"]),"sender"=>$usersArray[$row['user']]["fname"] ?? "Unknown", "avatar"=>strtoupper($usersArray[$row['user']]["fname"][0]?? "").strtoupper($usersArray[$row['user']]["lname"][0]?? "")];
})->apply("created_at", function($row){
    return dateLocal($row);
})->exec();

$allChat = array_reverse($allChat);

sendResponse(200, data:$allChat);