<?php 
require_once __DIR__ ."/../config.module.php";

    class Usuarios extends Dbo{

        public function listUsuarios($limit, $page){
            
            $query = "SELECT * FROM usuarios LIMIT :limit OFFSET :page";
    
            $stm = $this->db->prepare($query);
            $stm->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stm->bindParam(':page', $page, PDO::PARAM_INT);
            $stm->execute();

            return $stm->fetchAll();
        }
    }

?>