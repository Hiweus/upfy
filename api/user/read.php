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
    $input = new Input($_GET);
    $queryBuilder = new QueryBuilder();

    $search = [];
    $typeSearch = "";

    $queryBuilder
            ->table("user")
            ->fields(["id", "name", "creation_time", "update_time"]);

    if($input->get("id") != null)
    {
        $queryBuilder->where("id = ?");
        $search = [$input->get("id")];
        $typeSearch = "i";
    }

    $sql = $queryBuilder->select();

    $response = $db->query($sql, $typeSearch, $search);

    if(count($response->getLines()) == 0) error(404, "nenhum registro encontrado");
    
    echo json_encode($response->getLines());


?>