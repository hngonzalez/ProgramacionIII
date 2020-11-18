<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model {
    protected $table = "notas";
    protected $primaryKey = "";
    public $timestamps = false; //Anula los campos created_at y updated_at (columnas)    
}

?>