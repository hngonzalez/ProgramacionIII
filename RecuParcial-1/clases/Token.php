<?php

require __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;

class Token {
    
    //Atributtes
    static private $key = "primerparcial";
    
    static private $payload;

    //Methods
    static function decodeJWT($jwt){          

        $decoded = JWT::decode($jwt, static::$key, array('HS256'));

        return $decoded;
    }

    static function encodeJWT($email,$password){          

        $payload = array(
        "mail" => $email,
        "clave" => $password
        );

        $jwt = JWT::encode($payload,static::$key);

        return $jwt;
    }



}

?>







