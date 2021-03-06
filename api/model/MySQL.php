<?php
    class RespostaSQL
    {
        public $linhasAfetadas, $linhas;
        public function getLines(){return $this->linhas;}
        public function getAffectedRows(){return $this->linhasAfetadas;}
    }

    class MySQL
    {
        private $host, $usuario, $senha, $database, $conexao;
        public function __construct($host="localhost",
                                    $usuario="hiweus",
                                    $senha="admin",
                                    $database="upfy")
        {
            $this->host = $host;
            $this->usuario = $usuario;
            $this->senha = $senha;
            $this->database = $database;

            $this->conectar();
        }

        public function conectar()
        {
            $this->conexao = new mysqli($this->host, $this->usuario, $this->senha, $this->database);
            if($this->conexao->error === null)
            {
                var_dump($this->conexao);
                throw new Exception("Erro ao conectar no banco de dados");
            }
            $this->conexao->set_charset("utf8");
        }

        public function fechar()
        {
            try {
                $this->conexao->close();
            } catch (Exception $erro) {
            }
        }

        public function __destruct()
        {
            $this->fechar();
        }

        public function query($sql, $tipos, $parametros)
        {
            $smtp = $this->conexao->prepare($sql);
            if($smtp !== false)
            {

                $posicoes = [];
                $binario = [];
                for($i=0;$i<strlen($tipos);$i++)
                {
                    if($tipos[$i] == "b") {   
                        array_push($posicoes, $i);
                        array_push($binario, $parametros[$i]);
                        $parametros[$i] = NULL;
                    }
                }
                

                @$smtp->bind_param($tipos, ...$parametros);

                for($i=0;$i<count($posicoes);$i++)
                {
                    $smtp->send_long_data($posicoes[$i], $binario[$i]);
                }
                

                $status = $smtp->execute();
                $result = $smtp->get_result();

                $linhasAfetadas = $smtp->affected_rows;
                $linhas = [];
                if(!$status)
                {
                    throw new Exception("Erro ao executar a query {$sql} erro : {$smtp->error}\n");
                }
                else if($result !== false)
                {
                    $linhas = $result->fetch_all(MYSQLI_ASSOC);
                }
                $smtp->close();

                $resposta = new RespostaSQL();
                $resposta->linhasAfetadas = $linhasAfetadas;
                $resposta->linhas = $linhas;

                return $resposta;
            }
            else
            {
                throw new Exception("Erro ao executar a query {$sql} verifique sua sintaxe SQL\n");
            }
        }
    }
?>
