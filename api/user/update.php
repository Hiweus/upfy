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

    requireAuthentication();

    $db = new MySQL();
    $queryBuilder = new QueryBuilder();

    $json = Input::getJsonBody();
    $input = new Input( json_decode(Input::getBody(),true) );

    if($json == NULL || !$input->validateAllKeys(['id', 'name', 'pass'])) {
        error(400, "Entrada de dados invalida para recurso");
    }

    $sql = $queryBuilder
            ->table("user")
            ->fields(["name", "pass"])
            ->where("id = ?")
            ->update();

    try {
       
        $response = $db->query($sql, "ssi", [$json->name, hash("sha256", $json->pass), $json->id]);
        if($response->getAffectedRows() == 0)
        {
            error(500, "Nenhum dado foi modificado");
        }

        $sql = $queryBuilder
                ->table("user")
                ->fields(["id", "name", "creation_time", "update_time"])
                ->where("id = ?")
                ->select();

        $response = $db->query($sql, "i", [$json->id]);
        echo json_encode($response->getLines()[0]);

    } catch (\Throwable $th) {
        error(500, "Falha ao inserir novo usuario {$th->getLine()} {$th->getMessage()}");
    }
?>