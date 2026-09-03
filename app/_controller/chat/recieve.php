<?php //route: chat/recieve

//Add codes here...

use Tables\Chat;

$allChat = Chat::paginatedFind([], 1, 10, ["order by"=> "created_date desc"]);