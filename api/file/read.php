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
    $parameters = new Input($_GET);

    $queryBuilder = new QueryBuilder();
    $database = new MySQL();
    
    $auth = new Authenticator($queryBuilder, $database);
    $idUser = $auth->getId($input->get("token"));

    $tokenRequired = $parameters->get("token");
    if($tokenRequired == null)
    {
        $sql = "select name, token, creation_time from file,(select fk_token from owner_file where fk_user = ?) as owner_file where owner_file.fk_token = token order by creation_time desc";
        $response = $database->query($sql, "i", [$idUser]);
        echo json_encode($response->getLines());
        exit(0);
    }

    $sql = "select content, name from file where token = ?";
    $response = $database->query($sql, "s", [$tokenRequired]);
    
    $line = $response->getLines();
    if(count($line) > 0)
    {
        $line = $line[0];
        $content = $line["content"];
        $name = $line["name"];


        // header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$name);
        header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // header('Pragma: public');
        header('Content-Length: ' . strlen($content)-1);

        echo $content;
        exit(0);
    }
    else
    {
        echo json_encode([
            "error" => "Esse arquivo não foi encontrado ou você não possui permissão"
        ]);
        http_response_code(401);
    }
?>