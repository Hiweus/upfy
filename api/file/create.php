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
    
    $file =$input->get("file");
    if($file != null)
    {
        $name = $file["tmp_name"];
        $oldName = $file["name"];
        $newName = sha1_file($name);

        $extension = explode(".", $oldName);
        $extension = (count($extension) > 1)?$extension[count($extension)-1]:"";     
        $extension = ($extension == "")?"":".".$extension;

        $newName .= $extension;

        if(move_uploaded_file($name, "../uploads/".$newName))
        {
            echo json_encode([
                "link" => "/uploads/".$newName,
                "name" => $newName
            ]);
            exit(0);
        }
        

        error(500, "arquivo muito grande");
    }
    error(500, "arquivo não enviado");


?>