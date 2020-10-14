<?php

require_once './clases/usuario.php';
require_once './clases/Archivo.php';
require_once './clases/funcionesAux.php';
require_once './clases/Token.php';
require_once './clases/Vehiculo.php';
require_once './clases/Turnos.php';
require_once './clases/tiposServicio.php';


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
                        $rta = Archivo::guardarObjJSONConFiltro('userJson.txt', $usuario, 'mail');
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
                
                $email = FuncionesAux::getPost('email');
                $password = FuncionesAux::getPost('password');
                $existe = false;
                $listaUsuarios = Archivo::leerObjJSON('userJson.txt');

                foreach ($listaUsuarios as $usr) {
                    if ($email == $usr->mail && $password == $usr->clave) {                            
                        $existe = true;
                        $jwt = Token::encodeJWT($email,$password);
                        echo "Acceso concedido a:  <br>";
                        echo $jwt;
                    }
                }              
                
                if (!$existe) {
                    echo 'Usuario incorrecto';
                }
                
                break;

            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;


    case '/vehiculo':
        switch ($method) {
            case 'POST':

                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                if (isset($decoded)) {
                    $patente = FuncionesAux::getPost('patente');
                    $marca = FuncionesAux::getPost('marca');
                    $modelo = FuncionesAux::getPost('modelo');
                    $precio = FuncionesAux::getPost('precio');
    
                    try {
                        $jwt = FuncionesAux::getServer("HTTP_TOKEN");
    
                        $decoded = Token::decodeJWT($jwt);
    
                    } catch (\Throwable $th){
                        echo "Error";
                    }
    
                    
                    if (isset($decoded)) {
    
                        $vehiculo = new Vehiculo($marca,$modelo,$patente,$precio);
                        Archivo::guardarObjJSON('vehiculos.txt',$vehiculo);
                                 
                    }
                }

               
                break;

            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;

    case '/servicio':
        switch ($method) {
            case 'POST':
                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                if (isset($decoded)) {
                    
                    $nombre = FuncionesAux::getPost('nombre');
                    $id = FuncionesAux::getPost('id');
                    $tipo = FuncionesAux::getPost('tipo');
                    $precio = FuncionesAux::getPost('precio');
                    $demora = FuncionesAux::getPost('demora');
                    
                    if ($nombre != '' && $id != '' && ($tipo == 10000 || $tipo == 20000 || $tipo == 50000) && $precio != '' && $demora != '') {
                        $tServicio = new TipoServicio($nombre,$id, $tipo, $precio, $demora);
        
                        if (isset($tServicio)) {
                            Archivo::guardarObjJSON('tiposServicio.txt',$tServicio);
                        }           
                    }
                }
                
                break;
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;

    case '/turno':
        switch ($method) {
            case 'GET':
                echo 'Método incorrecto!'.$path;
                break;
            case 'POST':

                try {
                    $jwt = FuncionesAux::getServer("HTTP_TOKEN");

                    $decoded = Token::decodeJWT($jwt);

                } catch (\Throwable $th){
                    echo "Error";
                }

                if (isset($decoded)) {
                    $patente = FuncionesAux::getPost('patente');
                    $fecha = FuncionesAux::getPost('fecha');
                    $id = FuncionesAux::getPost('id');
                    $tipServ = 'Error';

                    $listaVehiculos = Archivo::leerObjJSON('vehiculos.txt');
                    $listaTipoServicio = Archivo::leerObjJSON('tiposServicio.txt');

                    if ($patente != '' && $fecha != '' && $id != '') {
                        if (isset($listaTipoServicio)) {
                            foreach ($listaTipoServicio as $tServ) {
                                
                                if ($tServ->id == $id) {
                                    
                                    $tipServ = $tServ->tipo;
                                }
                            }
                        }
        
                        if ($tipServ != 'Error') {
                            if (isset($listaVehiculos)) {
                                foreach ($listaVehiculos as $vehi) {
                                    if ($vehi->patente == $patente) {
                                        $turno = new Turno($patente,$fecha, $vehi->marca, $vehi->modelo, $vehi->precio, $tipServ);
                                        Archivo::guardarObjJSON('turnos.txt',$turno);
                                    }
                                }
                            }
                        }
                        else {
                            echo 'Error al buscar ID de servicio';
                        }
                    }
                }

                break;
            default:
                echo 'Método incorrecto!'.$path;
                break;
        }
        break;

    case '/stats':
        switch ($method) {
            case 'POST':
                echo 'Método incorrecto!'.$path;
                break;
            case 'GET':
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
                            if ($usuario->mail == $decoded->mail) {
                                $tUser = $usuario->tipoUsuario;
                            }
                        }
                    }

                    if ($tUser == 'admin') {
                        $tipoServicio = FuncionesAux::getGet('tipoServicio');

                        $listatiposServicio = Archivo::leerObjJSON('tiposServicio.txt');
    
                        if (isset($listatiposServicio)) {
                            foreach ($listatiposServicio as $tipServ) {
                                if ($tipServ->tipo == $tipoServicio) {
                                    echo 'Nombre: '.$tipServ->nombre.'ID: '.$tipServ->id.'Precio: '.$tipServ->precio.'Demora: '.$tipServ->demora;
                                    echo '<br>';
                                }
                            }
                        }  
                    }
                    else {
                        echo 'El usuario no es de tipo user';
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

