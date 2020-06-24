<?php
require_once __DIR__ ."/../config.module.php";

class Nocs extends Dbo{

    
    public function cadastroRegrasNegocios($idEmpresa,$idTemplate = null,$idEquipamento = null,$severidade,$notifica_cliente,$notifica_empresa,$tempo_notifica_cliente,$tempo_notifica_empresa,$renotifica_interacao,$idTrigger){

       $query = "INSERT into noc_notificacao(IDEMPRESA,IDTEMPLATE,IDEQUIPAMENTO,SEVERIDADE,NOTIFICA_CLIENTE,NOTIFICA_EMPRESA,TEMPO_NOTIFICA_CLIENTE,TEMPO_NOTIFICA_EMPRESA,RENOTIFICA_INTERACAO,IDTRIGGER) VALUES(:IDEMPRESA,:IDTEMPLATE,:IDEQUIPAMENTO,:SEVERIDADE,:NOTIFICA_CLIENTE,:NOTIFICA_EMPRESA,:TEMPO_NOTIFICA_CLIENTE,:TEMPO_NOTIFICA_EMPRESA,:RENOTIFICA_INTERACAO,:IDTRIGGER)";

       $stm = $this->db->prepare($query);

        $stm->bindValue(":IDEMPRESA", $idEmpresa);

         $stm->bindValue(":IDTEMPLATE", $idTemplate);

        $stm->bindValue(":IDEQUIPAMENTO", $idEquipamento);

        $stm->bindValue(":SEVERIDADE", $severidade);

        $stm->bindValue(":NOTIFICA_CLIENTE", $notifica_cliente);

        $stm->bindValue(":NOTIFICA_EMPRESA", $notifica_empresa);

        $stm->bindValue(":TEMPO_NOTIFICA_CLIENTE", $tempo_notifica_cliente);

        $stm->bindValue(":TEMPO_NOTIFICA_EMPRESA", $tempo_notifica_empresa);

        $stm->bindValue(":RENOTIFICA_INTERACAO", $renotifica_interacao);
        
        $stm->bindValue(":IDTRIGGER", $idTrigger);

       $stm->execute();

    }

     public function teste($nome){


       $query = "INSERT into teste(NOME) VALUES(:NOME)";

       $stm = $this->db->prepare($query);

        $stm->bindValue(":NOME", $nome);

       $stm->execute();

    }


    public function selecionaNoc_host($id_empresa){


        $query = "SELECT * FROM hosts WHERE IDEMPRESA =:IDEMPRESA";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":IDEMPRESA", $id_empresa);

        $stm->execute();

        return $stm->fetchAll();
    }


    public function selecionaNoc_notificacao($id_empresa){


        $query = "SELECT * FROM noc_notificacao WHERE IDEMPRESA =:IDEMPRESA";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":IDEMPRESA", $id_empresa);

        $stm->execute();

        return $stm->fetchAll();
    }
    
    public function backups($id_empresa, $bkp){
        
      $query = "INSERT INTO rotina_backup SET ID_EMPRESA =:ID_EMPRESA, BACKUP =:BACKUP";
      
      $stm = $this->db->prepare($query);
      
      $stm->bindValue(":ID_EMPRESA", $id_empresa);
      
      $stm->bindValue(":BACKUP", $bkp);
      
      $stm->execute();
      
        
    }

     public function backups_groups($id_empresa, $id_group, $nome_grupo){
        
      $query = "INSERT INTO appliance_groups SET ID_EMPRESA =:ID_EMPRESA, ID_GROUP =:ID_GROUP, NOME =:NOME";
      
      $stm = $this->db->prepare($query);
      
      $stm->bindValue(":ID_EMPRESA", $id_empresa);
      
      $stm->bindValue(":ID_GROUP", $id_group);

      $stm->bindValue(":NOME", $nome_grupo);
      
      $stm->execute();
      
        
    }

     public function backups_tempates($id_empresa, $id_group, $id_template, $nome_template){
        
      $query = "INSERT INTO appliance_templates SET ID_EMPRESA =:ID_EMPRESA, ID_GROUP =:ID_GROUP, ID_TEMPLATE =:ID_TEMPLATE, NOME =:NOME";
      
      $stm = $this->db->prepare($query);
      
      $stm->bindValue(":ID_EMPRESA", $id_empresa);
      
      $stm->bindValue(":ID_GROUP", $id_group);

      $stm->bindValue(":ID_TEMPLATE", $id_template);

      $stm->bindValue(":NOME", $nome_template);
      
      $stm->execute();
      
        
    }
    
    public function getBackup(){
        
        
        $query = "SELECT * FROM rotina_backup";
        
        $stm = $this->db->prepare($query);
     
        $stm->execute();
        
        return $stm->fetchAll();
    }

}
