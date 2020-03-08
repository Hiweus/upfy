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

    if($json == NULL || !$input->validateAllKeys(['name', 'pass'])) {
        error(400, "Entrada de dados invalida para recurso");
    }

    $sql = $queryBuilder
            ->table("user")
            ->fields(["name", "pass"])
            ->insert();

    try {
        $db->query($sql, "ss", [$json->name, hash("sha256", $json->pass)]);
        
        $sql = $queryBuilder
                ->table("user")
                ->fields(["id", "name", "creation_time", "update_time"])
                ->where("id = ?")
                ->select();
        $id = $db->query("select LAST_INSERT_ID() as id", "", [])->getLines()[0]['id'];
        $response = $db->query($sql, "i", [$id]);
        echo json_encode($response->getLines()[0]);

        http_response_code(201);
    } catch (\Throwable $th) {
        error(500, "Falha ao inserir novo usuario {$th->getLine()} {$th->getMessage()}");
    }
?>