<?php

require_once 'Archivo.php';

class FuncionesAux {

    static function getServer($info){
        return $_SERVER[$info] ?? '';
    }

    static function getPost($info){
        return $_POST[$info] ?? '';
    }

    static function getGet($info){
        return $_GET[$info] ?? '';
    }

    static function generoID($materia){
        
        $listaMaterias = Archivo::unserializeObj('./materias.txt');
        $idRandom = random_int(1,1000);
        $arrayIds = array();
        
        foreach ($listaMaterias as $mat) {
            array_push($arrayIds, $mat->id);
        }

        while (in_array($idRandom,$arrayIds)) {
            $idRandom = random_int(1,1000);
        }

        $materia->id = $idRandom;

        return $materia;
    }
}


?>

