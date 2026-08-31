<?php 
namespace Models;

use Tables\Task;

class TaskModel{
    
    public function __construct() {
        // Constructor code here
        // You can initialize properties or perform setup tasks
    }

    static function test(){
        return "Hello CodeTazer user. This is model file";
    }


    static function getById(int|null $id){
        if(! $id) return null;
        return Task::findOne($id);
    }

    static function getCurrentStatus(int|null $id){
        if(! $id) return null;
        $task = Task::findOne($id);
        if(! $task) return null;
        return val($task['status']);
    }

    static function getCurrentAssignee(int|null $id){
        if(! $id) return null;
        $task = Task::findOne($id);
        if(! $task) return null;
        return val($task['assign']);
    }


}