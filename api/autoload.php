<?php
    spl_autoload_register(function($resourceName){
        require_once "model/$resourceName.php";
    });
?>