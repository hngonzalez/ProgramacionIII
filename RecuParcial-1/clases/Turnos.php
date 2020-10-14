<?php

class Turno {
    //Atributtes
    public $patente;
    public $fecha;
    public $marca;
    public $modelo;
    public $precio;
    public $tipoServicio;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($patente, $fecha, $marca, $modelo, $precio, $tipoServicio){
        $this->patente = $patente;
        $this->fecha = $fecha;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->precio = $precio;
        $this->tipoServicio = $tipoServicio;
    }

    //Methods
    public function __toString(){
        return $this->patente.'-'.$this->fecha.'-'.$this->marca.'-'.$this->modelo.'-'.$this->precio.'-'.$this->tipoServicio;
    }

}


?>

