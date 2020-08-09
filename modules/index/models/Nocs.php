<?php
require_once __DIR__ ."/../config.module.php";

class Nocs extends Dbo{

    
    public function cadastroRegrasNegocios($idEmpresa,$idTemplate = null,$idEquipamento = null,$severidade,$notifica_cliente,$notifica_empresa = NULL,$tempo_notifica_cliente = NULL,$tempo_notifica_empresa = NULL,$renotifica_interacao = NULL,$idTrigger){

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


    public function selecionaNoc_host(){


        $query = "SELECT * FROM host";


        $stm = $this->db->prepare($query);

       
        $stm->execute();

        return $stm->fetchAll();
    }

       public function selecionaNoc_hosts($id = null){


        $query = "SELECT * FROM host WHERE ID =:ID";


        $stm = $this->db->prepare($query);

        $stm->bindValue(":ID", $id);

        $stm->execute();

        return $stm->fetchAll();
    }


    public function regras_notifica(){
       $query = "SELECT * 
        FROM empresa AS em 

        LEFT JOIN noc_notificacao as notificacao on `notificacao`.IDEMPRESA = `em`.ID

        WHERE `em`.ID = `notificacao`.IDEMPRESA";

        $stm = $this->db->prepare($query);

      
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

     public function insertIncidentesApi($id_host, $id_incidente,$descricao,$data_abertura,$id_empresa,$id_regra_template){

       $status = "ABERTO";

       $query = "INSERT IGNORE INTO `incidentes` SET ID_HOST =:ID_HOST, ID_INCIDENTE =:ID_INCIDENTE, DESCRICAO =:DESCRICAO, DATA_ABERTURA =:DATA_ABERTURA, STATUS =:STATUS, IDEMPRESA =:IDEMPRESA, ID_REGRAS_NEGOCIO =:ID_REGRAS_NEGOCIO";

       $stm = $this->db->prepare($query);

       $stm->bindValue(":ID_HOST", $id_host);

       $stm->bindValue(":ID_INCIDENTE", $id_incidente);

       $stm->bindValue(":DESCRICAO", $descricao);
        
       $stm->bindValue(":DATA_ABERTURA", $data_abertura);
        
       $stm->bindValue(":STATUS", $status);

       $stm->bindValue(":IDEMPRESA", $id_empresa);

       $stm->bindValue(":ID_REGRAS_NEGOCIO", $id_regra_template);

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

  
        $stm->execute();

        return $stm->fetchAll();
  }

  public function mostra_empresa(){


        $query = "SELECT * 

                  FROM empresa AS em 

                  LEFT JOIN `host` as equipamentos on `equipamentos`.ID_EMPRESA = `em`.ID

                  LEFT JOIN noc_notificacao as notificacao on `notificacao`.IDEMPRESA = `em`.ID";

        $stm = $this->db->prepare($query);

  
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
