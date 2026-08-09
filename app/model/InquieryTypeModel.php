<?php 
namespace Models;

use Tables\Inquiry_type;

class InquieryTypeModel{
    
    public function __construct() {
        // Constructor code here
        // You can initialize properties or perform setup tasks
    }

    static function test(){
        return "Hello CodeTazer user. This is model file";
    }

    static function getById(int|null $id){
        if(! $id) return [];
        $find = Inquiry_type::findOne(["id"=>$id]);
        if(! $find){
            return [];
        }
        return $find ?? [];
    }



}