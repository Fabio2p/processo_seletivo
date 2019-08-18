<?php 
/**
 * Author: Fábio Silveira dos Anjos
 * 
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * 
 * data: 17-08-2019
 * 
 * Classe Dbo: responsável pela a conexão com a base de dados
 */

require_once(realpath('../system/database/Database.class.php'));

class Dbo extends Database{

    protected $db;

    private  $stm;

    /**
     * Atributos para dá suporte a sintaxe SQL
     */
    private $keys;

    private $values;

    /**
     * 
     * Inicializa o atributo $this->db
     */    
    public function __construct(){

        $this->db = parent::getConn();

    }
    /**
     * 
     * Método insert(): Inclui dados na base de dados
     * 
     */
    protected function insert($table, array $fields){


        $this->keys     = implode(',', array_keys($fields));

        $this->values   = implode(', :', array_keys($fields));
        
        $query = "INSERT INTO {$table}({$this->keys}) VALUES(:{$this->values})";

        $this->stm = $this->db->prepare($query);

        foreach($fields as $keys => $values):

            $this->stm->bindValue(":{$keys}", $values, (is_int($values) ? PDO::PARAM_INT : PDO::PARAM_STR));

        endforeach;

        $this->stm->execute();
    }

    /**
     * 
     * Método select(): exibe dados da base de dados
     * 
     */
    protected function select($fields, $table, $where = null){

        if($where != null):

            array($where);
            
            foreach($where as $vars=>$k):

                $field[] = $vars .'= :'. $vars;

                $places = implode(' AND ', $field);

            endforeach;

            $Clause = "WHERE ".$places;

        endif;

        $place = (empty($Clause) ? " " : $Clause);

        $query = "SELECT {$fields} FROM {$table} {$place}";


        $this->stm = $this->db->prepare($query);

        $this->stm->setFetchMode(PDO::FETCH_OBJ);

        if($where !== null):

            array($where);

            foreach($where as $chaves=>$valores):

            $this->stm->bindValue(":{$chaves}", $valores, (is_int($valores) ? PDO::PARAM_INT : PDO::PARAM_STR));
                
            endforeach;

        endif;


    $this->stm->execute();

    return $this->stm->fetchAll();

  }

  protected function update($table, array $fields, $id, $param){

    foreach($fields as $vars=>$k):

        $field[] = $vars .'= :'. $vars;

        $places = implode(' ,', $field);

    endforeach;

    $query = "UPDATE {$table} SET {$places} WHERE {$id}= :{$param}";

    $this->stm = $this->db->prepare($query);

    foreach($fields as $chaves=>$valores):

      $this->stm->bindValue(":{$chaves}", $valores, (is_int($valores) ? PDO::PARAM_INT : PDO::PARAM_STR));
          
    endforeach;

    $this->stm->bindParam(":{$param}", $param, PDO::PARAM_INT);

    $this->stm->execute();
  }
  
  /**
   * Método close(): fecha a conexão
   * 
   */
  protected function close(){

    $this->db = null;

  }


}
