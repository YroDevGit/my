<?php 
namespace Models;

use Tables\TaskRoute;

class Routetasking{
    
    public function __construct() {
        // Constructor code here
        // You can initialize properties or perform setup tasks
    }

    static function test(){
        return "Hello CodeTazer user. This is model file";
    }

    static function getType(int $type){
        $arr = [
            0 => "Change Status",
            1 => "Change assignee",
            2 => "Add Comment",
            3 => "Create task"
        ];
        return val($arr[$type]);
    }


    static function route(int $task, int $status, int|null $assign, $message = null, $image = null, $type = null){
        if(! $type){
            TaskRoute::insert([
                "task" => $task,
                "status" => $status,
                "assign" => $assign,
                "by" => get_user_data("id")
            ]);
        }else{
            TaskRoute::insert([
                "task" => $task,
                "status" => $status,
                "assign" => $assign,
                "comment" => $message,
                "image" => $image,
                "type" =>$type,
                "by"=> get_user_data("id")
            ]);
        }
        return true;
    }


}