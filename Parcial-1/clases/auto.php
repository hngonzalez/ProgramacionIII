<?php

class Auto {
    //Atributtes
    public $patente;
    public $fecha_ingreso;
    public $email;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($patente, $fecha_ingreso, $email){
        $this->patente = $patente;
        $this->fecha_ingreso = $fecha_ingreso;
        $this->email = $email;
    }

    //Methods
    public function __toString(){
        return $this->patente.'-'.$this->fecha_ingreso.'-'.$this->email.'-';
    }

}


?>

