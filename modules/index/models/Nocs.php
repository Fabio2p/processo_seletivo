<?php
require_once __DIR__ ."/../config.module.php";

class Nocs extends Dbo{

    
    public function cadastroRegrasNegocios($idEmpresa,$idEquipamento,$severidade,$notifica_cliente,$notifica_empresa,$tempo_notifica_cliente,$tempo_notifica_empresa,$renotifica_interacao,$idTrigger){

       $query = "INSERT into noc_notificacao(IDEMPRESA,IDEQUIPAMENTO,SEVERIDADE,NOTIFICA_CLIENTE,NOTIFICA_EMPRESA,TEMPO_NOTIFICA_CLIENTE,TEMPO_NOTIFICA_EMPRESA,RENOTIFICA_INTERACAO,IDTRIGGER) VALUES(:IDEMPRESA,:IDEQUIPAMENTO,:SEVERIDADE,:NOTIFICA_CLIENTE,:NOTIFICA_EMPRESA,:TEMPO_NOTIFICA_CLIENTE,:TEMPO_NOTIFICA_EMPRESA,:RENOTIFICA_INTERACAO,:IDTRIGGER)";

       $stm = $this->db->prepare($query);

        $stm->bindValue(":IDEMPRESA", $idEmpresa);

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


}
