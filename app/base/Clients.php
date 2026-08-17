<?php 
namespace Tables;
use Classes\BaseTable;

class Clients extends BaseTable {
    
    protected $table = "clients";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>