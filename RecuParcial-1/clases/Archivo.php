<?php

class Archivo{

    static function serializarObj($ruta, $obj){
        $listaPrevia = Archivo::unserializeObj($ruta);
        
        $b = false;
        
        foreach ($listaPrevia as $objAnterior) {
            if ($objAnterior == $obj) {
                $b = true;
            }
        }
        
        if ($b == false) {
            $handlerFile = fopen("./".$ruta,"a");
            fwrite($handlerFile, serialize($obj).PHP_EOL);
            fclose($handlerFile);
            echo "Objeto guardado con éxito!";
        }
        else{
            echo "El objeto ya existe";
        }

        
    }

    static function unserializeObj($ruta){
        $listaObj = array();

        $handlerFile = fopen("./".$ruta,"r");

        while (!feof($handlerFile)) {
            $obj = unserialize(fgets($handlerFile));
            if ($obj != NULL) {
                array_push($listaObj,$obj);
            }
        }
        fclose($handlerFile);
        return $listaObj;
    }


    /*
    * Guarda obj en JSON
    * Recibe ruta y el obj a guardar
    */
    static function guardarObjJSON($ruta, $obj){
        $array = Archivo::leerObjJSON($ruta);

        if (isset($array)) {
            $handlerFile = fopen("./".$ruta,"w+");
            array_push($array,$obj);
            fwrite($handlerFile, json_encode($array).PHP_EOL); //atributos tienen que estar publicos
            fclose($handlerFile);
            echo "JSON guardado con éxito";
        }
        else {
            $array2 = array();
            $handlerFile = fopen("./".$ruta,"w+");
            array_push($array2,$obj);
            fwrite($handlerFile, json_encode($array2)); //atributos tienen que estar publicos
            fclose($handlerFile);
            echo "JSON guardado con éxito";
        }
        
    }


    /*
    * Guarda obj en JSON
    * Recibe ruta, el obj a guardar y el param por el que se revisará que no se repita el obj
    */
    static function guardarObjJSONConFiltro($ruta, $obj, $filtro){
        $existe = false; 
        $array = Archivo::leerObjJSON($ruta);

        if (isset($array)) {

            foreach ($array as $objeto) {
                if ($objeto->$filtro == $obj->$filtro) {
                    $existe = true;
                }
            }

            if (!$existe) {
                $handlerFile = fopen("./".$ruta,"w+");
                array_push($array,$obj);
                fwrite($handlerFile, json_encode($array).PHP_EOL); //atributos tienen que estar publicos
                fclose($handlerFile);
                echo "JSON guardado con éxito";
            }
            else{
                echo "El usuario ya se encuentra registrado";
            }
            
        }
        else {
            $array2 = array();
            $handlerFile = fopen("./".$ruta,"w+");
            array_push($array2,$obj);
            fwrite($handlerFile, json_encode($array2)); //atributos tienen que estar publicos
            fclose($handlerFile);
            echo "JSON guardado con éxito";
        }
        
    }


    /*
    * Lee obj de un JSON
    * Recibe la ruta
    * Devuelve lista de objetos
    */
    static function leerObjJSON($ruta){
        if (file_exists($ruta)) {
            $handlerFile = fopen($ruta,"r");
            $lista = json_decode(fgets($handlerFile));
            fclose($handlerFile);
            if (isset($lista)) {
                return $lista;
            }            
            else {
                echo "La lista no fue seteada";
                echo "<br>";
            }
            
        }
        else {
            echo "El archivo no existe";
            echo "<br>";
        }
    }

    
    static function subirImg($imgTmpLocation, $imgName){
        $destino = false;
        if ($imgTmpLocation != '' && $imgName != '') {
            $num = rand(1000, 10000);

            $extension = explode('.',$imgName);
            
            $destino = "img/".$extension[0]."_".$num.'.'.$extension[1];

            move_uploaded_file($imgTmpLocation, $destino);    
        }
        
        return $destino;
    }

    

    static function subirImg2($imgTmpLocation, $imgName, $user,$currentPath,$listaUsuarios){
        $destino = false;
        if ($imgTmpLocation != '' && $imgName != '') {
            $num = rand(1000, 10000);

            $extension = explode('.',$imgName);
            
            $destino = "img/".$extension[0]."_".$num.'.'.$extension[1];

            $user->foto = $destino;
            
            $destino = move_uploaded_file($imgTmpLocation, $destino);    

            //Archivo::eliminarDato($listaUsuarios,$currentPath);
            Archivo::guardarObjJSON('userJson.txt',$user);
        }

        return $destino;
    }

}

?>