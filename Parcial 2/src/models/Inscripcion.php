<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model {
    protected $table = "inscripcion";
    protected $primaryKey = "";
    public $timestamps = false; //Anula los campos created_at y updated_at (columnas)    
}

?>