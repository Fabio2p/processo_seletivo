<?php 
require_once __DIR__ ."/../config.module.php";

    class Usuarios extends Dbo{

        public function listUsuariosStatic(){
            
            $query = "SELECT * FROM usuarios ORDER BY id desc LIMIT 5";
    
            $stm = $this->db->prepare($query);
            $stm->execute();

            return $stm->fetchAll();
        }

        public function listUsuarios($limit, $page, $colunm, $order){
            
            $query = "SELECT * FROM usuarios ORDER BY `$colunm` $order LIMIT :limit OFFSET :page";
    
            $stm = $this->db->prepare($query);
            $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stm->bindParam(':page', $page, PDO::PARAM_INT);
            $stm->execute();

            return $stm->fetchAll();
        }
    }

?>