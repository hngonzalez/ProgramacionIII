<?php

namespace Clases;

class Usuario {
    //Atributtes
    public $mail;
    public $nombre;
    public $clave;
    public $tipo;

    //Properties
    public function __get($name){
        return $this->$name;    
    }
    public function __set($name,$value){
        $this->$name = $value;    
    }

    //Constructors
    public function __construct($mail, $nombre, $clave, $tipo){
        $this->mail = $mail;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->clave = $clave;
    }

    //Methods
    public function __toString(){
        return $this->mail.'-'.$this->tipo.'-'.$this->clave.'-'.$this->nombre;
    }
    
    public function GuardarUserEnArchivo($fileName,$mode,$data){
        $archivo = fopen($fileName,$mode);
        $lista = array();

        while (!feof($archivo)) {
            $objeto = unserialize(fgets($archivo));
            if ($objeto == "" or $objeto == NULL) {
                $mailArchivo = null; //AHORA CON SERIALIZACIÓN
            }
            else {
                //$legajoArchivo = $datos.[1]; ANTES SIN SERIALIZAR
                $mailArchivo = $objeto->mail; //AHORA CON SERIALIZACIÓN
            }
                array_push($lista, $mailArchivo);
        }
        
        //echo $data->mail;
        //var_dump($lista);
        //die ();
        if(in_array((string)$data->mail,$lista)) {
            return 'Mail repetido';
        }
        else {            
            $fwrite = fwrite($archivo, serialize($data).PHP_EOL);
            
            echo 'Usuario guardado!';
            echo "<br>";
            //echo "Archivo guardado en: $destino";
            $close = fclose($archivo);
        }
    }
}


?>

