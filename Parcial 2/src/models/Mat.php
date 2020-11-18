<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mat extends Model {
    protected $table = "materia";
    protected $primaryKey = "";
    public $timestamps = false; //Anula los campos created_at y updated_at (columnas)    
}

?>