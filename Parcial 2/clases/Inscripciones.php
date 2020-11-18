<?php

namespace Clases;

class Inscripciones {
    //Atributtes
    public $idAlumno;
    public $idMateria;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($idAlumno, $idMateria){
        $this->idAlumno = $idAlumno;
        $this->idMateria = $idMateria;
    }

    //Methods
    public function __toString(){
        return $this->idAlumno.'-'.$this->idMateria;
    }

}


?>

