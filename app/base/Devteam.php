<?php 
namespace Tables;
use Classes\BaseTable;

class Devteam extends BaseTable {
    
    protected $table = "devteam";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>