<?php

namespace App\Controllers;

use App\Models\User;
use Clases\Token;
use Clases\Usuario;
use Clases\FuncionesAux;

class UserController{
    public function userSignUp($request, $response, $args) {
        $params = (array)$request->getParsedBody();
        $email = $params['email'];        
        $nombre = $params['nombre'];        
        $clave = $params['clave'];        
        $tipo = $params['tipo'];        

        if(FuncionesAux::validarTexto($nombre) && strlen($clave)>=4) {
            $newUser = new Usuario($email, $nombre, $clave, $tipo);
            $existeUser = User::where("email", $newUser->mail)->get();
            
            
            if (isset($newUser) && count($existeUser) == 0) {

                $user = new User;

                $user->email = $newUser->mail;
                $user->nombre = $newUser->nombre;
                $user->clave = $newUser->clave;
                $user->tipo = $newUser->tipo;        

                $user->save();

                $data = array('status' => 'El usuario fue generado con exito');
            }
            else {
                $data = array('status' => 'El mail o nombre ya existe en la base de datos');
            }
        }
        else {

        }

        

        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response;
    }
    
    public function userLogIn($request, $response, $args) {
        
        $params = (array)$request->getParsedBody();
        $email = $params['email'];                        
        $password = $params['clave'];        

        $existeUserEmail = User::where("email", $email)->get();
        
        $userDB = json_decode($existeUserEmail);

        if (count($userDB) == 1) {
            if ($userDB[0]->email == $email && $userDB[0]->clave == $password) {
            
                $jwt = Token::encodeJWT($email,$password);
    
                if (isset($jwt)) {
                    $data = array('status' => 'Acceso concedido a '.$email.': '.$jwt);
                }
            }
            else
            {
                $data = array('status' => 'Datos de acceso incorrectos'); 
            }
        }
        else
        {
            $data = array('status' => 'Mail inexistente'); 
        }
        
        $payload = json_encode($data);
        
        $response->getBody()->write($payload);
        return $response;
    }
    
    
    /*public function getAll($request, $response, $args) {
        $rta = User::get();
        //$rta = User::find();
        //$rta = User::where("campo", valor)->get();
        

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function getOne($request, $response, $args) {
        $rta = User::where("id", $args['id'])->get();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function add($request, $response, $args) {
        $response->getBody()->write("Hello ADD!");
        return $response;
    }

    public function update($request, $response, $args) {
        $id = $args['id'];
        $user = User::find($id);
        //$user = User::where("id", $id)->get();

        $user->nombre = "Ezequiel";
        $user->apellido = "Suarez";

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }

    public function delete($request, $response, $args) {
        $id = $args['id'];
        $user = User::find($id);


        $response->getBody()->write("Hello DELETE!");
        return $response;
    }*/
}

?>