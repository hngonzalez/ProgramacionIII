<?php

require_once './clases/usuario.php';
require_once './clases/Archivo.php';
require_once './clases/funcionesAux.php';
require_once './clases/Token.php';
require_once './clases/auto.php';


$method = FuncionesAux::getServer('REQUEST_METHOD');
$path = FuncionesAux::getServer('PATH_INFO');

switch ($path) {
    case '/registro':
        switch ($method) {
            case 'POST':
                $tipoUsuario = FuncionesAux::getPost('tipo');
                $email = FuncionesAux::getPost('email');
                $password = FuncionesAux::getPost('password');
                $imgTmpLocation = $_FILES['imagen']["tmp_name"] ?? '';
                $imgName = $_FILES['imagen']["name"] ?? '';
                
                if ($email != '' && $password != '') {
                    $imgSubida = Archivo::subirImg($imgTmpLocation, $imgName);
                    if ($imgSubida != false) {
                        $usuario = new Usuario($email,$tipoUsuario,$password,$imgSubida);
                        $rta = Archivo::guardarObjJSON('userJson.txt', $usuario);
                        echo $rta;
                    }
                    else {
                        echo 'Error en la carga de la imagen!';
                    }
                }
                break;

            case 'GET':
                # code...
                break;
                
            default:
                echo 'Método incorrecto!';
                break;
        }
        break;
    
    case '/login':
        switch ($method) {
            case 'POST':
                /*
                * Recibo jwt, realizo el decode, si hay error no continúo
                */
                $userAccede = false;
                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                /*
                * Si pudo realizarse el decode del JWT, continúo
                */
                if (isset($decoded)) {                    
                    $listaUsuarios = Archivo::leerObjJSON('userJson.txt');

                    foreach ($listaUsuarios as $usr) {
                        if ($decoded->email == $usr->mail && $decoded->password == $usr->clave) {                            
                            $userAccede = true;
                            echo "Acceso concedido a:  <br>";
                            echo $jwt;
                        }
                    }

                    if ($userAccede == false) {
                        echo "Error en acceso";
                    }
                }

                break;
            case 'GET':
                echo 'Método incorrecto!'.$path;
                break;
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;


    case '/ingreso':
        switch ($method) {
            case 'POST':
                $patente = FuncionesAux::getPost('patente');

                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                if (isset($decoded)) {

                    $listaUsuarios = Archivo::leerObjJSON('userJson.txt');

                    if (isset($listaUsuarios)) {
                        foreach ($listaUsuarios as $usuario) {
                            if ($usuario->mail == $decoded->email) {
                                $tUser = $usuario->tipoUsuario;
                            }
                        }
                    }

                    if ($tUser == 'user') {
                        $auto = new Auto($patente,date("F j, Y, g:i a"),$decoded->email);
                        Archivo::guardarObjJSON('autos.txt',$auto);
                    }
                    else {
                        echo 'El usuario no es de tipo user';
                    }                   
                }
                break;
            case 'GET':
                $listadoAutos = new ArrayObject();
                $listadoAutos = Archivo::leerObjJSON('autos.txt');
                
                echo "Resultados: ";
                echo "<br>";
                foreach ($listadoAutos as $auto) {
                    echo $auto->patente.' - '.$auto->fecha_ingreso.' - '.$auto->email;
                    echo "<br>";
                }
                    
                break;
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;


    case '/ingreso/patente':
        switch ($method) {
            case 'POST':
                echo 'Método incorrecto!'.$path;
                break;
            case 'GET':
                $patente = FuncionesAux::getGet('patente');

                $listaAutos = Archivo::leerObjJSON('autos.txt');

                if (isset($listaAutos)) {
                    foreach ($listaAutos as $auto) {
                        if ($auto->patente == $patente) {
                            echo 'Patente: '.$auto->patente;
                            echo '<br>';
                            echo 'Fecha de Registro: '.$auto->fecha_ingreso;
                            echo '<br>';
                            echo 'Email: '.$auto->email;
                            echo '<br>';

                        }
                    }
                }


                break;
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;


    case '/users':
        switch ($method) {
            case 'POST':
                //$usuario = FuncionesAux::getPost("usuario");
                $imgTmpLocation = $_FILES['imagen']["tmp_name"] ?? '';
                $imgName = $_FILES['imagen']["name"] ?? '';
                $listaUsuarios = Archivo::leerObjJSON('userJson.txt');

                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                            
                if(isset($decoded) && isset($listaUsuarios)){
                    
                    
                    foreach ($listaUsuarios as $user) {                    
                        if (($decoded->email == $user->mail)) {
                            $currentPath = $user->foto;
    
                            $aux1 = explode('.',$currentPath);
                            $aux2 = explode('/',$aux1[0]);
    
                            
                            $aux2[0] = 'backup';
                             
                            $auxFinal = $aux2[0].'/'.$aux2[1].'.'.$aux1[1];
                            
                            $user->foto = 'img/'.$imgName;

                            $imgSubida = Archivo::subirImg2($imgTmpLocation, $imgName, $user,$currentPath,$listaUsuarios);
    
                            
                            if (copy($currentPath,$auxFinal)) {
                                unlink($currentPath);
                            }
                        }
                    }
    
                }

                
            break;
            
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;



    default:
        # code...
        break;
}


?>

