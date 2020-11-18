<?php

namespace App\Controllers;

use App\Models\Mat;

class StatsController{
    public function listadoMaterias($request, $response, $args) {
        $idMateria = $args['idMateria'];

        if (isset($idMateria)) {
            $rta = Mat::where("id", $idMateria)->get();
        }
        else {
            $rta = Mat::get();
        }

        $response->getBody()->write(json_encode($rta));
        return $response;
        
    }
    
   
}

?>