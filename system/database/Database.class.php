<?php
/**
 * Author: Fábio Silveira dos Anjos
 * 
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * 
 * data: 16-08-2019
 * 
 * Classe database: responsável pela a conexão com a base de dados
 */

abstract class Database{

    /**
     * Atribute: $conn
     */
    private static $conn = null;

    /**
     * Método setConn(): atribui os valores necessário para a conexão
     * 
     */
    private static function setConn(){

        require_once(realpath('../config/config.db.php'));
        
        try {
            
            if(self::$conn == null):
                
                $chars = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"];

                $dsn = "mysql:host=".$config['host'].";dbname=".$config['base'];

                self::$conn = new PDO($dsn, $config['user'],$config['pass']);

                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            endif;

            
            return self::$conn;


        } catch (PDOException $e) {
            
            if($e->getCode() == '2002'):

                echo "<b>Servidor</b> não localizado!";

            endif;    

            if($e->getCode() == '1049'):

                echo "<b>Banco de dados</b> não localizado!";

            endif;

        }

    }

    /**
     * Atributo getConn(): recupera os dados para serem utilizados 
     * em classes herdeiras
     * 
     */
    protected function getConn(){
        
        return self::setConn();
    }
    
}
