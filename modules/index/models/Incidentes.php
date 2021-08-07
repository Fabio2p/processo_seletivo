<?php
require_once __DIR__ ."/../config.module.php";

class Incidentes extends Dbo{


     public function insertIncidentesApi($id_host, $id_incidente,$descricao,$data_abertura,$id_regra_template){

       $status = "ABERTO";

       $query = "INSERT IGNORE INTO `incidentes` SET ID_HOST =:ID_HOST, ID_INCIDENTE =:ID_INCIDENTE, DESCRICAO =:DESCRICAO, DATA_ABERTURA =:DATA_ABERTURA, STATUS =:STATUS, ID_TRIGGER =:ID_TRIGGER";

       $stm = $this->db->prepare($query);

       $stm->bindValue(":ID_HOST", $id_host);

       $stm->bindValue(":ID_INCIDENTE", $id_incidente);

       $stm->bindValue(":DESCRICAO", $descricao);
        
       $stm->bindValue(":DATA_ABERTURA", $data_abertura);
        
       $stm->bindValue(":STATUS", $status);

       $stm->bindValue(":ID_TRIGGER", $id_regra_template);

       $stm->execute();

    }

  /*
  *DATA: 27-06-2020
  *
  *AS FUNCIONALIDADES ABAIXO TEM COMO OBJETIVO A CORRECAO E MELHORIAS NO MOMENTOS DA ATUALIZACAO E ADICAO DE HOSTS NOS APPLIANCES
 */
  public function mostra_incidentes_aberto(){


        $query = "SELECT * FROM incidentes";
   
        $stm = $this->db->prepare($query);

        $stm->execute();

        return $stm->fetchAll();
  }


  public function mostra_host(){


        $query = "SELECT * FROM host";

        $stm = $this->db->prepare($query);

      var_dump($stm);
        $stm->execute();

        return $stm->fetchAll();
  }

  /*
  *DATA: 27-06-2020
  *
  *AS FUNCIONALIDADES ABAIXO TEM COMO OBJETIVO A CORRECAO E MELHORIAS NO MOMENTOS DA ATUALIZACAO E ADICAO DE HOSTS NOS APPLIANCES
 */
  public function update_incidentes($id_incidente,$status, $data_encerramento){

      $query = "UPDATE incidentes SET STATUS =:STATUS, DATA_ENCERRAMENTO =:DATA_ENCERRAMENTO WHERE ID_INCIDENTE =:ID_INCIDENTE AND STATUS = 'ABERTO'";

      $stm = $this->db->prepare($query);

      $stm->bindValue(":ID_INCIDENTE", $id_incidente);

      $stm->bindValue(":STATUS", $status);

       $stm->bindValue(":DATA_ENCERRAMENTO", $data_encerramento);
  
      $stm->execute();

  }

}
