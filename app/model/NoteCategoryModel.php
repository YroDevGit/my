<?php 
namespace Models;

use Tables\Note_category;

class NoteCategoryModel{
    
    public function __construct() {
        // Constructor code here
        // You can initialize properties or perform setup tasks
    }

    static function test(){
        return "Hello CodeTazer user. This is model file";
    }


    static function getNoteCategoryById($id){
        $result = Note_category::findOne(["id"=>$id]);
        return $result ?? [];
    }


}