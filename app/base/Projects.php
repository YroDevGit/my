<?php 
namespace Tables;
use Classes\BaseTable;

class Projects extends BaseTable {
    
    protected $table = "projects";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>