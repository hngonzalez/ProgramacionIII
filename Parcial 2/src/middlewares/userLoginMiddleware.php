<?php

namespace App\Middlewares;

use Slim\Psr7\Response;
use Clases\Token;

class userLoginMiddleware{
    public function __invoke($request, $handler){
        $params = (array)$request->getHeader('token');

        $jwt = $params[0];  
        

        if (isset($jwt)) {
            
            try {
                $userJWTDecoded = Token::decodeJWT($jwt);
            } catch (\Throwable $th){
                echo "Error";
            }
            
            if (!isset($userJWTDecoded)) {
                $response = new Response();
                
                $rta = array("status"=>"Usuario no autenticado");

                $rta = json_encode($rta);

                $response->getBody()->write($rta);
                
                return $response;
            }
            else {
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();

                $resp = new Response();
                $resp->getBody()->write($existingContent);

                return $resp;
            }

        }
        else {

        }
    }
}




?>