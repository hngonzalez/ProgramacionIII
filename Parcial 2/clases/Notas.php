<?php

namespace Clases;

class Notas {
    //Atributtes
    public $idAlumno;
    public $idMateria;
    public $nota;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($idAlumno, $idMateria, $nota){
        $this->idAlumno = $idAlumno;
        $this->idMateria = $idMateria;
        $this->nota = $nota;
    }

    //Methods
    public function __toString(){
        return $this->idAlumno.'-'.$this->idMateria.'-'.$this->nota;
    }

}


?>

