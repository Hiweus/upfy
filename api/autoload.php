<?php
    spl_autoload_register(function($resourceName){
        require_once "model/$resourceName.php";
    });

    function cors() {

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
            exit(0);
        }
    }

    function requireAuthentication()
    {
        $input = new Input( getallheaders() );
        $status = false;
        if($input->get("token") != null)
        {
            $auth = new Authenticator(new QueryBuilder(), new MySQL());
            $status = ($auth->verifySession($input->get("token")));
        }

        if(!$status)
        {
            echo json_encode([
                "error" => "Necessário autenticar para continuar a utilizar esse recurso"
            ]);
            http_response_code(401);
            exit(0);
        }
    }


    cors();
?>