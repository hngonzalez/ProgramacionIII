<?php

namespace App\Controllers;

use App\Models\Nota;
use Clases\Notas;
use Clases\Token;

class NotasController{
    public function addNota($request, $response, $args) {
        $idMateria = $args['idMateria'];
        $params = (array)$request->getParsedBody();
        $not = $params['nota'];        
        echo $not;
        die();
        $idAlumno = $params['idAlumno'];        
        
        
        $newNota = new Notas($idAlumno,$idMateria,$not);

        //if (count($patenteDB) == 0) {
            
            $nota = new Nota;

            $nota->idAlumno = $newNota->nombre;
            $nota->idMateria = $newNota->cuatrimestre;
            $nota->nota = $newNota->cupos;
            
            $nota->save();
            $data = array('status' => 'Nota agregada a la DB!');
            
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