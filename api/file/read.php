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

    $input = new Input( getallheaders() );
    $queryBuilder = new QueryBuilder();
    $database = new MySQL();
    
    $auth = new Authenticator($queryBuilder, $database);
    $idUser = $auth->getId($input->get("token"));

    $sql = "select name, token from file,(select fk_token from owner_file where fk_user = ?) as owner_file where owner_file.fk_token = token";

    $response = $database->query($sql, "i", [$idUser]);
    
    
    
    echo json_encode($response->getLines());
    
?>