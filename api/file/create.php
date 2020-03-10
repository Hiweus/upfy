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

    $input = new Input( $_FILES );
    $queryBuilder = new QueryBuilder();
    $database = new MySQL();
    
    $file =$input->get("file");
    $post = new Input($_POST);


    if($post->get("user") == null)
    {
        error(400, "Usuario destino não informado");
    }

    if($file != null)
    {
        $error = $file["error"];
        if($error != "0")
        {
            error(500, "Erro ao subir arquivo, codigo : ".$error);
        }

        $name = $file["tmp_name"];
        $oldName = $file["name"];
        $token = sha1_file($name);

        $extension = explode(".", $oldName);
        $extension = (count($extension) > 1)?$extension[count($extension)-1]:"";     
        $extension = ($extension == "")?"":".".$extension;

        $newName = $token.$extension;

        if(move_uploaded_file($name, "../uploads/".$newName))
        {
            try {
                $sql = $queryBuilder
                    ->table("file")
                    ->fields(["token", "name", "content"])
                    ->insert();
                $fileContent = file_get_contents("../uploads/".$newName);
                $response = $database->query($sql, "ssb", [$token, $newName, $fileContent]);


                $idUser = $post->get("user");

                $sql = $queryBuilder
                    ->table("owner_file")
                    ->fields(["fk_token", "fk_user"])
                    ->insert();


                $response = $database->query($sql, "si", [$token, $idUser]);

            } catch (\Throwable $th) {
                error(500, "Arquivo já foi salvo");
            }
            
            


            echo json_encode([
                "link" => "/uploads/".$newName,
                "name" => $newName
            ]);
            exit(0);
        }
        

        error(500, "Impossível mover arquivo entre os diretórios");
    }
    error(400, "arquivo não enviado");


?>