<?php 
namespace Tables;
use Classes\BaseTable;

class TaskRoute extends BaseTable {
    
    protected $table = "TaskRoute";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>