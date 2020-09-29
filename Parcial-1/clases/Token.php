<?php

require __DIR__ . '/../vendor/autoload.php';

use \Firebase\JWT\JWT;

class Token {
    
    //Atributtes
    static private $key = "primerparcial";

    //Methods
    static function decodeJWT($jwt){          

        $decoded = JWT::decode($jwt, static::$key, array('HS256'));

        return $decoded;
    }



}

?>







