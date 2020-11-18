<?php

namespace Clases;

class Materia {
    //Atributtes
    public $nombre;
    public $cuatrimestre;
    public $cupos;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($nombre, $cuatrimestre, $cupos){
        $this->nombre = $nombre;
        $this->cuatrimestre = $cuatrimestre;
        $this->cupos = $cupos;
    }

    //Methods
    public function __toString(){
        return $this->nombre.'-'.$this->cuatrimestre.'-'.$this->cupos;
    }

}


?>

