<?php 
namespace Tables;
use Classes\BaseTable;

class Chat extends BaseTable {
    
    protected $table = "chat";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>