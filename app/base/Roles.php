<?php 
namespace Tables;
use Classes\BaseTable;

class Roles extends BaseTable {
    
    protected $table = "roles";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>