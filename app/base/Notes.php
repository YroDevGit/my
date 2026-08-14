<?php 
namespace Tables;
use Classes\BaseTable;

class Notes extends BaseTable {
    
    protected $table = "notes";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>