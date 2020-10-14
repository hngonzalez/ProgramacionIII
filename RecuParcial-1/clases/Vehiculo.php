<?php

class Vehiculo {
    //Atributtes
    public $marca;
    public $modelo;
    public $patente;
    public $precio;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($marca, $modelo, $patente, $precio){
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->patente = $patente;
        $this->precio = $precio;
    }

    //Methods
    public function __toString(){
        return $this->marca.'-'.$this->modelo.'-'.$this->patente.'-'.$this->precio;
    }

}


?>

