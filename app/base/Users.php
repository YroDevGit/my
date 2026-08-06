<?php 
namespace Tables;
use Classes\BaseTable;

class Users extends BaseTable {
    
    protected $table = "users";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>