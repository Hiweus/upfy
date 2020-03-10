<?php
    class Authenticator
    {
        const SESSION_TIMEOUT = 5;

        private $queryBuilder, $database;
        public function __construct($queryBuilder, $database)
        {
            $this->database = $database;
            $this->queryBuilder = $queryBuilder;
        }

        public function login($id, $pass)
        {
            $sql = $this->queryBuilder
                ->table("user")
                ->fields(["id", "name", "creation_time", "update_time"])
                ->where("id = ? and pass = ?")
                ->select();

            $response = $this->database->query($sql, "is", [$id, hash("sha256", $pass)]);
            if(count($response->getLines()) == 0)
            {
                throw new Exception("Usuário e/ou senha incorretos");
            }

            $token = rand(PHP_INT_MIN, PHP_INT_MAX) ." <===> ". rand(PHP_INT_MIN, PHP_INT_MAX);
            $token .= " <===> ". date("Y-m-d h:i:s",time());
            $token = hash("sha256", $token);

            $sql = $this->queryBuilder
                    ->table("auth")
                    ->fields(["token", "fk_user"])
                    ->insert();
            $response = $this->database->query($sql, "si" , [$token, $id] );
            if($response->getAffectedRows() == 0)
            {
                throw new Exception("Falha ao gerar token do usuário");
            }
            return $token;
        }

        public function verifySession($token)
        {
            $sql = "update `auth` set `last_visit` = NOW() where token = ? and timestampdiff(MINUTE, last_visit, creation_time) < ?";
            $response = $this->database->query($sql, "si", [$token, SELF::SESSION_TIMEOUT]);
            return ($response->getAffectedRows() > 0);
        }

        public function getId($token)
        {
            $sql = $this->queryBuilder
                    ->table("auth")
                    ->fields(["fk_user"])
                    ->where("token = ?")
                    ->select();
            $response = $this->database->query($sql, "s", [$token]);
            if(count($response->getLines()) > 0)
            {
                return $response->getLines()[0]['fk_user'];
            }

            throw new Exception("Esta sessão não é valida, favor fazer login novamente");
        }
    }
    
?>