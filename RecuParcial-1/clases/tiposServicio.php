<?php

class TipoServicio {
    //Atributtes
    public $nombre;
    public $id;
    public $tipo;
    public $precio;
    public $demora;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($nombre, $id, $tipo, $precio, $demora){
        $this->nombre = $nombre;
        $this->id = $id;
        $this->tipo = $tipo;
        $this->precio = $precio;
        $this->demora = $demora;
    }

    //Methods
    public function __toString(){
        return $this->nombre.'-'.$this->id.'-'.$this->tipo.'-'.$this->precio.'-'.$this->demora;
    }

}


?>

