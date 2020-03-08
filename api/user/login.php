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

        
        $sql = $queryBuilder
                ->table("user")
                ->fields(["id", "name", "creation_time", "update_time"])
                ->where("id = ? and pass = ?")
                ->select();

        $response = $db->query($sql, "is", [$json->id, hash("sha256", $json->pass)]);
        if(count($response->getLines()) == 0)
        {
            error(401, "Usuário e/ou senha incorretos");
        }

        echo json_encode($response->getLines()[0]);

    } catch (\Throwable $th) {
        error(500, "Falha ao inserir novo usuario {$th->getLine()} {$th->getMessage()}");
    }
?>