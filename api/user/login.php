<?php
    require_once "../autoload.php";

    function error($httpCode, $message)
    {
        http_response_code($httpCode);
        echo json_encode([
            "error"=>$message
        ]);
        exit(0);   
    }

    $db = new MySQL();
    $queryBuilder = new QueryBuilder();

    $json = Input::getJsonBody();
    $input = new Input( json_decode(Input::getBody(),true) );

    if($json == NULL || !$input->validateAllKeys(['id', 'pass'])) {
        error(400, "Entrada de dados invalida para recurso");
    }

    try {

        $auth = new Authenticator($queryBuilder, $db);
        $token = $auth->login($json->id, $json->pass);
        echo json_encode([
            "token" => $token,
            "userId" => $json->id
        ]);

    } catch (\Throwable $th) {
        error(500, $th->getMessage());
    }
?>