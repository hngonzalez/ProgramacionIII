<?php

namespace Clases;
//require_once 'Archivo.php';

class FuncionesAux {
  
    public static function validarTexto($texto){
        $texto = trim($texto);
        if($texto=="" && trim($texto)==""){
            return false;
        }else{
            $patron = '/^[a-zA-Z, ]*$/';
            if(preg_match($patron,$texto)){
                return true;   
            }else{
                return false;
            }
        }   
    }
}


?>

