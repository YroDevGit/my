<?php 
namespace Tables;
use Classes\BaseTable;

class Emails extends BaseTable {
    
    protected $table = "emails";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>