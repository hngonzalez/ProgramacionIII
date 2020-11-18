<?php

namespace App\Controllers;

use App\Models\Inscripcion;
use App\Models\User;
use App\Models\Mat;
use Clases\Inscripciones;
use Clases\Token;

class InscripcionController{
    public function addInscripcion($request, $response, $args) {
        $idMateria = $args['idMateria'];
        
        
        if ($idMateria == "") {
            $data = array('status' => 'Datos vacios');

            $response->getBody()->write(json_encode($data));
            return $response;
        }
        else {
            
            $jwt = (array)$request->getHeader('token');
            
            $userJWTDecoded = Token::decodeJWT($jwt[0]);
            
            try {
                
            } catch (\Throwable $th){
                echo "Error";
            }
            
            $existeUserDB = User::where("email", $userJWTDecoded->mail)->get();

            $cantCupos = Mat::where("id", $idMateria)->get();

            $currentCupos = Inscripcion::where("idMateria", $idMateria)->get();

            $currentCupos = count($currentCupos);
            $cantCupos = $cantCupos[0]->cupos;

            if ($currentCupos < $cantCupos) {
                
                $newInscrip = new Inscripciones($existeUserDB[0]->id,$idMateria);
            
                $inscrip = new Inscripcion;

                $inscrip->idAlumno = $newInscrip->idAlumno;
                $inscrip->idMateria = $newInscrip->idMateria;
                
                $inscrip->save();

                $data = array('status' => 'La inscripcion fue generado con exito');
            }
            else {
                $data = array('status' => 'Cupos completos o no existe la materia');
            }

            $response->getBody()->write(json_encode($data));
            return $response;
        }
    }
    
    public function listoInscriptos($request, $response, $args) {
        $idMateria = $args['idMateria'];

        $rta = Inscripcion::where("idMateria", $idMateria)->get();
        
        
        $response->getBody()->write(json_encode($rta));
        return $response;
        
    }
}

?>