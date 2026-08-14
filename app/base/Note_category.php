<?php 
namespace Tables;
use Classes\BaseTable;

class Note_category extends BaseTable {
    
    protected $table = "note_category";

    protected $primaryKey = "id";

    protected $fillable = [];

    protected $guarded = [];

    protected $hidden = [];

    protected $timestamps = false;
}
?>