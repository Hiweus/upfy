<?php


class QueryBuilder
{
    private $tabela, $campos, $where;
    function table($nome){$this->tabela = $nome;return $this;}
    function fields($campos){$this->campos = $campos;return $this;}
    function where($where){$this->where = $where;return $this;}

    private function gerarParametros($qtd)
    {
        $parametros = "";
        for($i=0;$i<$qtd;$i++){
            $parametros .= ($parametros == "")?"":", ";
            $parametros .= "?";
        }
        return $parametros;
    }

    private function formatarCampos()
    {
        $campos = array_map(function($valor){
            if($valor == "*"){return $valor;}
            $campo = stripslashes($valor);
            return "`$campo`";
        },$this->campos);
        return $campos;
    }

    private function getWhere()
    {
        return ($this->where != "")?"where {$this->where}":"";
    }

    private function aposExecutar()
    {
        $this->campos = [];
        $this->where = "";
    }

    function insert()
    {
        $campos = $this->formatarCampos();
        $nomes = implode(", ",$campos);
        $parametros = $this->gerarParametros(count($campos));
        $sql = "insert into `{$this->tabela}` ({$nomes}) values ({$parametros})";
        $this->aposExecutar();
        return $sql;
    }

    function insertOnDuplicate()
    {
        $campos = $this->formatarCampos();
        $nomes = implode(", ",$campos);
        $parametros = $this->gerarParametros(count($campos));

        $valores = "";
        foreach($campos as $c)
        {
            $valores .= ($valores == "")?"":", ";
            $valores .= "{$c} = ?";
        }


        $sql = "insert into `{$this->tabela}` ({$nomes}) values ({$parametros}) ON DUPLICATE KEY UPDATE {$valores}";


        $this->aposExecutar();
        return $sql;
    }

    function select()
    {
        $campos = $this->formatarCampos();
        $nomes = implode(", ",$campos);
        $parametros = $this->gerarParametros(count($campos));

        $where = $this->getWhere();
        $sql = "select {$nomes} from `{$this->tabela}` $where";
        $this->aposExecutar();
        return $sql;
    }

    function delete()
    {
        $where = $this->getWhere();
        $sql = "delete from `{$this->tabela}` $where";
        $this->aposExecutar();
        return $sql;
    }

    function update()
    {
        $campos = $this->formatarCampos();
        $where = $this->getWhere();

        $valores = "";
        foreach($campos as $c)
        {
            $valores .= ($valores == "")?"":", ";
            $valores .= "{$c} = ?";
        }

        $sql = "update `{$this->tabela}` set {$valores} $where";
        $this->aposExecutar();
        return $sql;
    }

}
// $qb = new QueryBuilder();
// echo $qb
//     ->table('users')
//     ->fields(['nome', 'login', 'password'])
//     ->insert();

// echo "\n\n";

// echo $qb
//     ->table('users')
//     ->fields(['nome', 'login', 'password'])
//     ->insertOnDuplicate();

// echo "\n\n";

// echo $qb
//         ->table("users")
//         ->fields(["*"])
//         ->where("id < ?")
//         ->select();

// echo "\n\n";
// #SELECT
// echo $qb
//     ->table('users') // poderia não informar, pois já está "salvo"
//     ->fields(['id', 'nome', 'login', 'password'])
//     ->where("id = ? and usuario != ?")
//     ->select();
// echo "\n\n";


// # UPDATE
// echo $qb
//     ->table('users') // poderia não informar, pois já está "salvo"
//     ->fields(['nome', "idade"])
//     ->where('id = ?')
//     ->update();
// echo "\n\n";


//     #DELETE
// echo $qb
//     ->table('users') // poderia não informar, pois já está "salvo"
//     ->where('id = ? and idade < ?')
//     ->delete();
?>