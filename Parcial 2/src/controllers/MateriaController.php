<?php

namespace App\Controllers;

use App\Models\Mat;
use Clases\Materia;
use Clases\Token;

class MateriaController{
    public function addMateria($request, $response, $args) {
        $params = (array)$request->getParsedBody();
        $materia = $params['materia'];        
        $cupos = $params['cupos'];        
        $cuatrimestre = $params['cuatrimestre'];        
        
        $newMat = new Materia($materia,$cuatrimestre,$cupos);
        //$existePatente = Mat::where("patente", $patente)->get();
        
        //$patenteDB = json_decode($existePatente);
        
        //if (count($patenteDB) == 0) {
            
            $mat = new Mat;

            $mat->nombre = $newMat->nombre;
            $mat->cuatrimestre = $newMat->cuatrimestre;
            $mat->cupos = $newMat->cupos;
            
            $mat->save();
            $data = array('status' => 'Materia agregada a la DB!');
            
        //}
        //else {
        //    $data = array('status' => 'Esta patente ya existe en la DB');
        //}
        
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response;
    }
    
   
}

?>