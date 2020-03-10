<?php
    spl_autoload_register(function($resourceName){
        require_once "model/$resourceName.php";
    });

    function requireAuthentication()
    {
        $input = new Input( json_decode(Input::getBody(),true) );
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
?>