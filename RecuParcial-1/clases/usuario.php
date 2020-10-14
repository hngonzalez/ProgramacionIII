<?php

class Usuario {
    //Atributtes
    public $tipoUsuario;
    public $mail;
    public $clave;
    public $foto;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($mail, $tipoUsuario, $clave, $foto){
        $this->mail = $mail;
        $this->tipoUsuario = $tipoUsuario;
        $this->clave = $clave;
        $this->foto = $foto;
    }

    //Methods
    public function __toString(){
        return $this->mail.'-'.$this->tipoUsuario.'-'.$this->clave.'-'.$this->foto;
    }

}


?>

