<?php 
namespace Models;

use Tables\Notes;

class NotesModel{
    
    public function __construct() {
        // Constructor code here
        // You can initialize properties or perform setup tasks
    }

    static function test(){
        return "Hello CodeTazer user. This is model file";
    }

    static function getNoteById($id){
        $result = Notes::findOne(["id"=>$id]);
        return $result ?? [];
    }



}