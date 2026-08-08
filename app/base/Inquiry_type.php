<?php 
namespace Tables;
use Classes\BaseTable;

class Inquiry_type extends BaseTable {
    
    protected $table = "inquiry_type";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>