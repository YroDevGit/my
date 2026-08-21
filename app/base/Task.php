<?php 
namespace Tables;
use Classes\BaseTable;

class Task extends BaseTable {
    
    protected $table = "task";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>