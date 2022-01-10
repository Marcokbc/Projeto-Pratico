<?php

namespace App\DB;

use \PDO;
use PDOException;

class DataBase{
    /**
     * Host de conecção do banco de dados
     * @var string
     */
    const HOST = 'localhost';

    /**
     * nome do banco de dados
     * @var string
     */
    const NAME = 'projeto';

    /**
     * Usuário do banco
     * @var string
     */
    const USER = 'root';

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia a conexão
     * @param string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Metodo responsavel por criar uma conexão com o banco de dadoss
     */
    private function setConnection(){
        try{
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//o atributo errmode vai receber o errmode_exception. Vai sempre lançar uma exception se algo não saia como o esperado
        }catch(PDOException $e){
            die('ERROR:'.$e->getMessage());
        }
    }

    /**
     * Metodo responsavel por executar queries no banco de dados
     *
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query,$params = []){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e){
            die('ERROR:'.$e->getMessage());
        }
    }

    /**
     * Metodo responsavel por inserir dados no banco
     * @param array $values [field/value]
     * @return interger ID ISERIDO
     */
    public function insert($values){
            //DADOS DA QUERY
            $fields = array_keys($values);
            $binds  = array_pad([],count($fields),'?');

            //MONTA A QUERY
            $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

            //EXECUTA O INSERT
            $this->execute($query,array_values($values));

            //RETORNA O ID INSERIDO
            return $this->connection->lastInsertId();
  }

    /**
     * Metodo que faz uma consulta no banco
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null,$order = null, $limit = null,$fields = '*'){
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    /**
     * @param string $where
     * @param array $values [field => value]
     * @return boolean
     */
    public function update($where,$values){
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        //EXECUTA A QUERY
        $this->execute($query,array_values($values));

        return true;
    }

    /**
     * Metodo resposavel por excluir a vaga do banco de dados
     * @param string $where
     * @return boolean
     */

    public function delete($where){
        //Monta a query
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
        
        //EXECUTA A QUERY
        $this->execute($query);

        //retorna sucesso
        return true;
    }
}    
