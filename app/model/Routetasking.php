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


    static function route(int $task, int $status, int|null $assign){
        TaskRoute::insert([
            "task" => $task,
            "status" => $status,
            "assign" => $assign
        ]);
    }


}