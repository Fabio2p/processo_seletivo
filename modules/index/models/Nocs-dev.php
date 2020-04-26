<?php
require_once __DIR__ ."/../config.module.php";

class Nocs extends Dbo{

    public function getLastNoc()
    {
        $array = array();
        $sql = "SELECT `ID` from `noc` ORDER BY ID DESC LIMIT 1; ";
        $sql = $this->db->prepare($sql);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetch()[0];
        }
        return '0';
    }

    public function getNoc($idEmpresa, $idNoc = null) // achei caralho
    {
        $array = array();
        // $sql = "SELECT noc.`id`, noc.`id_empresa`, requerida.`RAZAOSOCIAL`, noc.`id_cliente`, empresas.`fantasia`, noc.`id_ramificacao`, ramificacao.`nome` as ramificacao, noc.`id_host`, equipamento.`NOME` as host, noc.`id_trigger`, noc.`status`, noc.`urgencia`, noc.`data_abertura`, TIMEDIFF(if (noc.`data_encerramento` > noc.`data_abertura`, noc.`data_encerramento`, now()), noc.`data_abertura`) as `TEMPOATIVO`,noc.`data_encerramento`, noc.`mensagem`, noc.`primeiro_atendimento`, noc.`escalonado`, noc.`id_ticket`, noc.`PROTOCOLO`, noc.`causador`, noc.`zabbix_encerrramento` as zabbix_encerramento,empresas.`NOCDESASTRE`,empresas.`TEMPODESASTRE`,empresas.`NOCALTA`, empresas.`TEMPOALTA`,empresas.`NOCMEDIA`,empresas.`TEMPOMEDIA`,empresas.`NOCATENCAO`,empresas.`TEMPOATENCAO`,empresas.`NOCINFORMACAO`,empresas.`TEMPOINFORMACAO`,empresas.`NOCBAIXA`,empresas.`TEMPOBAIXA` ";
        // $sql .= "FROM `noc` as noc ";
        // $sql .= "LEFT JOIN `empresas` as requerida on noc.`id_empresa` = requerida.`id` ";
        // $sql .= "LEFT JOIN `empresas` as empresas on noc.`id_cliente` = empresas.`id` ";
        // $sql .= "LEFT JOIN `equipamento` as equipamento on noc.`id_host` = equipamento.`id` ";
        // $sql .= "LEFT JOIN `ramificacao` as ramificacao on noc.`id_ramificacao` = ramificacao.`id` ";
        // $sql .= "where noc.`id_empresa` = :IDEMPRESA and noc.`status` = 'ABERTO' ";
        // $sql .= $idNoc != null ? "AND noc.`id` = ".$idNoc." " : " ";
        // $sql .= "order by noc.`data_abertura` desc;";

        $sql = "SELECT DISTINCT noc.`id`,  
                    noc.`id_empresa`,
                    empresas.`RAZAOSOCIAL`,
                    noc.`id_cliente`,
                    empresas.`FANTASIA` as fantasia,
                    noc.`id_ramificacao`,
                    
                    ramificacao.`NOME` AS ramificacao , 
                    
                    token_empresa.`IDEQUIPAMENTO` AS id_host, 
                    equipamento.`host` as host, 
                    noc.`id_trigger`, 
                    noc.`status`, 
                    noc.`urgencia`, 
                    noc.`data_abertura`, 
                    TIMEDIFF(if (noc.`data_encerramento` > noc.`data_abertura`, noc.`data_encerramento`, now()), noc.`data_abertura`) as `TEMPOATIVO`, 
                    noc.`data_encerramento`, 
                    noc.`mensagem`, 
                    noc.`primeiro_atendimento`, 
                    noc.`escalonado`, 
                    noc.`id_ticket`, 
                    noc.`PROTOCOLO`, 
                    noc.`causador`, 
                    noc.`zabbix_encerrramento` as zabbix_encerramento, 
                    empresas.`NOCDESASTRE`, 
                    empresas.`TEMPODESASTRE`, 
                    empresas.`NOCALTA`, 
                    empresas.`TEMPOALTA`, 
                    empresas.`NOCMEDIA`, 
                    empresas.`TEMPOMEDIA`, 
                    empresas.`NOCATENCAO`, 
                    empresas.`TEMPOATENCAO`, 
                    empresas.`NOCINFORMACAO`, 
                    empresas.`TEMPOINFORMACAO`, 
                    empresas.`NOCBAIXA`, 
                    empresas.`TEMPOBAIXA` 


                FROM noc,empresas,equipamento, token_empresa, ramificacao 
                
                WHERE token_empresa.`HOSTID` = noc.`id_host` 
                
                AND noc.`id_empresa` = empresas.`ID`  
                
                AND noc.id_ramificacao = ramificacao.`ID` 

                AND equipamento.`ID` = token_empresa.`IDEQUIPAMENTO`   
                
                AND noc.`id_cliente` = :IDEMPRESA
                
                AND noc.`status` = 'ABERTO'

                AND `token_empresa`.`IDEMPRESA` = `noc`.`id_empresa`"; 
                
                $sql .= $idNoc != null ? " AND noc.`id` = ".$idNoc." " : " "; 
                
                $sql .= " order by noc.`data_abertura` desc;"; 


        $sql = $this->db->prepare($sql);

        $sql->bindValue(":IDEMPRESA", $idEmpresa);

        $sql->execute();

        if ($sql->rowCount() > 0) {

            return $sql->fetchAll();

        }

        return false;
    }

    public function getNocItens($id_noc){
        $array = array();
        $sql = "SELECT * from `noc_itens` WHERE `id_noc` = :IDNOC ORDER BY `data` DESC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        }
        return false;
    }

    public function getNocIncidentes($id_trigger){
        $array = array();
        $sql = "SELECT noc.`id`, noc.`id_empresa`, noc.`id_cliente`, empresas.`fantasia`, noc.`id_ramificacao`, ramificacao.`nome` as ramificacao, noc.`id_host`, equipamento.`NOME` as host, noc.`id_trigger`, noc.`status`, noc.`urgencia`, noc.`data_abertura`, TIMEDIFF(if (noc.`data_encerramento` > noc.`data_abertura`, noc.`data_encerramento`, now()), noc.`data_abertura`) as `TEMPOATIVO`,noc.`data_encerramento`, noc.`mensagem`, noc.`primeiro_atendimento`";
        $sql .= "FROM `noc` as noc ";
        $sql .= "LEFT join `empresas` as empresas on noc.`id_cliente` = empresas.`id` ";
        $sql .= "LEFT JOIN `equipamento` as equipamento on noc.`id_host` = equipamento.`id` ";
        $sql .= "LEFT JOIN `ramificacao` as ramificacao on noc.`id_ramificacao` = ramificacao.`id` ";
        $sql .= "where noc.`id_empresa` = :IDEMPRESA ";
        //$sql .= $idCliente != null ? "AND noc.`id_cliente` = ".$idCliente." " : " ";
        $sql .= "order by noc.`data_abertura` desc;";
        $sql = $this->db->prepare($sql);
        //$sql->bindValue(":IDEMPRESA", $idEmpresa);
//        $sql->execute();
//        if ($sql->rowCount() > 0) {
//            return $sql->fetchAll();
//        }
//        return false;
        return $sql;
    }

    public function getNocTerceiros($id_empresa){
        $array = array();
        $sql = "SELECT * ";
        $sql .= "FROM `terceiros` order by `FANTASIA`";
        $sql .= "";
        $sql = $this->db->prepare($sql);
//        $sql->bindValue(":IDEMPRESA", $idEmpresa);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        }
        return false;
    }

    public function addItensNoc($id_noc, $tipo = 'AUTO', $status = 'INCIDENTE', $mensagem){
        $sql = "INSERT INTO `noc_itens` ( `data`, `id_noc`, `mensagem`, `status`, `tipo`) ";
        $sql .= "VALUES ( :DATA, :ID_NOC, :MENSAGEM, :STATUS, :TIPO );";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":DATA", date('Y-m-d H:i:s'));
        $sql->bindValue(":ID_NOC", $id_noc);
        $sql->bindValue(":TIPO", $tipo);
        $sql->bindValue(":STATUS", $status);
        $sql->bindValue(":MENSAGEM", $mensagem);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function uploadAnexo($id_noc, $anexo){
        $sql = "INSERT INTO `noc_itens_anexo` ( `anexo`, `id_item`) VALUES ( :ANEXO, :ID_ITEM ); ";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":ANEXO", $anexo);
        $sql->bindValue(":ID_ITEM", $id_noc);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getNocItem($id_item){
        $array = array();
        $sql = "SELECT * from noc_itens WHERE `id` = :IDITEM ORDER BY `data` DESC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDITEM", $id_item);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }
        return false;
    }

    public function getAnexos($id_item){
        $array = array();
        $sql = "SELECT * FROM `noc_itens_anexo` WHERE `id_item` = :IDITEM;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDITEM", $id_item);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetchAll();
        }
        return false;
    }

    public function finalizaNoc($id_noc){
        $array = array();
        $sql = "UPDATE `noc` SET `status` = 'RESOLVIDO', `data_encerramento` = :data_encerramento WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":data_encerramento", date("Y-m-d H:i:s"));
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function foraExpediente($id_noc, $fator){
        $array = array();
        $sql = "UPDATE `noc` SET `status` = 'RESOLVIDO', `data_encerramento` = :data_encerramento, `causador` = :causador WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":causador", $fator);
        $sql->bindValue(":data_encerramento", date("Y-m-d H:i:s"));
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }
    public function oscilacao($id_noc, $fator) {
        $array = array();
        $sql = "UPDATE `noc` SET `status` = 'FALSO POSITIVO', `data_encerramento` = :data_encerramento, `causador` = :causador WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":causador", $fator);
        $sql->bindValue(":data_encerramento", date("Y-m-d H:i:s"));
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function causadorNoc($id_noc, $fator, $protocolo = ''){
        $array = array();
        $sql = "UPDATE `noc` SET `causador` = :CAUSADOR , `protocolo` = :PROTOCOLO WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":CAUSADOR", $fator);
        $sql->bindValue(":PROTOCOLO", $protocolo);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function falsoPositivoNoc($id_noc){
        $array = array();
        $sql = "UPDATE `noc` SET `status` = 'FALSO POSITIVO', `data_encerramento` = :data_encerramento WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":data_encerramento", date("Y-m-d H:i:s"));
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function escalonarTicketNoc($id_noc, $idTicket){
        $array = array();
        $sql = "UPDATE `noc` SET `escalonado` = 'SIM', `id_ticket` = :IDTICKET WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->bindValue(":IDTICKET", $idTicket);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function primeiroAtendimento($id_noc){
        $array = array();
        $sql = "SELECT `primeiro_atendimento` FROM `noc` WHERE `id` = :IDNOC;";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDNOC", $id_noc);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
            if ($array['primeiro_atendimento'] == null){
                $sql2 = "UPDATE `noc` SET `primeiro_atendimento` = :TEMPO WHERE `id` = :IDNOC;";
                $sql2 = $this->db->prepare($sql2);
                $sql2->bindValue(":IDNOC", $id_noc);
                $sql2->bindValue(":TEMPO", date("Y-m-d H:i:s"));
                $sql2->execute();
                return true;
            }
        }
        return false;
    }

    public function nocExists($idempresa, $idcliente, $idtrigger){
        $array = array();
        $sql = "SELECT `id`, `status`, `id_trigger`, `id_cliente`, `urgencia`, `data_abertura` FROM `noc` WHERE `status` = 'ABERTO' and `id_empresa` = :IDEMPRESA and `id_trigger` = :IDTRIGGER and `id_cliente` = :IDCLIENTE";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDEMPRESA", $idempresa);
        $sql->bindValue(":IDTRIGGER", $idtrigger);
        $sql->bindValue(":IDCLIENTE", $idcliente);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }
        return false;
    }

    public function insertNoc($empresa, $cliente, $ramificacao, $host, $trigger, $mensagem, $urgencia = false)
    {
        $array = array();
        $sql = "INSERT INTO `noc` ( `id_empresa`, `id_cliente`, `id_ramificacao`, `id_host`, `id_trigger`, `mensagem`, `urgencia` ) ";
        $sql .= "VALUES ( :IDEMPRESA, :IDCLIENTE, :IDRAMIFICACAO, :IDHOST, :IDTRIGGER, :MENSAGEM, :URGENCIA );";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":IDEMPRESA", $empresa);
        $sql->bindValue(":IDCLIENTE", $cliente);
        $sql->bindValue(":IDRAMIFICACAO", $ramificacao);
        $sql->bindValue(":IDHOST", $host);
        $sql->bindValue(":IDTRIGGER", $trigger);
        $sql->bindValue(":MENSAGEM", $mensagem);
        $sql->bindValue(":URGENCIA", $urgencia == false ? 'DESASTRE' : $urgencia);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function resolveZabbix($id){
        $array = array();
        $sql = "UPDATE `noc` SET `zabbix_encerrramento` = :DATAHORA WHERE `id` = :ID";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":DATAHORA", date("Y-m-d H:i:s"));
        $sql->bindValue(":ID", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        }
        return false;
    }


    /*===================================Metodo utilizados pela a Api zabbix===============================*/

    /*EXTRACT: IDEMPRESA, IDRAMIFICACAO, HOSTID
    *Seleciona os dados citados acima da tabela noc itens;
    */
     public function getHostIdTokenEmpresa($idEmpresa){

        $sql = "SELECT 
                     `IDEMPRESA`, 
                     `IDLOJA`, 
                     `HOSTID`, 
                     `IDEQUIPAMENTO` 
                FROM `token_empresa` 

                WHERE IDEMPRESA = :IDEMPRESA";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":IDEMPRESA", $idEmpresa);

        $sql->execute();

        return $sql->fetchAll();
    }


    /*INSERT: id_empresa, id_cliente, id_ramificacao, id_host, id_trigger,mensagem,data_abertura,urgencia
    *INSERE OS DADOS CITADO ACIMA DE ABERTURA DE INCIDENTE DO ZABBIX
    */
    public function insertNocApiZabbix($id_empresa, $id_cliente, $id_ramificacao, $id_host, $id_trigger, $mensagem, $data_abertura, $urgencia = false){

        $array = array();

        $sql = "INSERT IGNORE INTO `noc` ( `id_empresa`, `id_cliente`, `id_ramificacao`, `id_host`, `id_trigger`, `mensagem`, `data_abertura`,`urgencia` ) ";

        $sql .= "VALUES ( :IDEMPRESA, :IDCLIENTE, :IDRAMIFICACAO, :IDHOST, :IDTRIGGER, :MENSAGEM, :DATA_ABERTURA, :URGENCIA );";
        
        $sql = $this->db->prepare($sql);

        $sql->bindValue(":IDEMPRESA", $id_empresa);

        $sql->bindValue(":IDCLIENTE", $id_cliente);

        $sql->bindValue(":IDRAMIFICACAO", $id_ramificacao);

        $sql->bindValue(":IDHOST", $id_host);

        $sql->bindValue(":IDTRIGGER", $id_trigger);

        $sql->bindValue(":MENSAGEM", $mensagem);

        $sql->bindValue(":DATA_ABERTURA", $data_abertura);

        $sql->bindValue(":URGENCIA", $urgencia == false ? 'DESASTRE' : $urgencia);

        $sql->execute();

        if ($sql->rowCount() > 0) {

            return $this->db->lastInsertId();
        }

        return false;
    }

    /*@UPDATE: data_encerramento;
    *ENCERRA O INCIDENTE DO ZABBIX
    */
    public function finalizaNocApiZabbix($data_encerramento, $id_trigger){

        $array = array();

        $sql = "UPDATE `noc` SET `status` = 'RESOLVIDO', `zabbix_encerrramento` = :ZABBIX_ENCERRAMENTO WHERE `id_trigger` = :ID_TRIGGER;";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":ID_TRIGGER", $id_trigger);

        $sql->bindValue(":ZABBIX_ENCERRAMENTO", $data_encerramento);

        $sql->execute();

        if ($sql->rowCount() > 0) {

            return true;

        }

        return false;
    }

    /*@EXTRACT: id_noc;
    *SELECIONA O ID NOC PARA SER COMPARADO EM POSTERIORES CONSULTAS NA TABELA NOC ITENS
    */
    public function extraiIdNoc($id_trigger){

        $sql = "SELECT id AS `id_noc` FROM `noc` WHERE `id_trigger` =:ID_TRIGGER";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":ID_TRIGGER", $id_trigger);

        $sql->execute();

        return $sql->fetchAll();
    }

    /*@INSERT: id_noc,mensagem,tipo_chamado,status_chamado;
    * ADICIONA OS DADOS DE ABERTURA PARA GERAMENTO DE RELATORIOS COMPLETO NA TABELA NOC ITENS
    */
    public function addItensNocApiZabbix($id_noc, $mensagem, $tipo_chamado, $status_chamado){

        $tipo =  $tipo_chamado;

        $status = $status_chamado;

        $sql = "INSERT IGNORE INTO `noc_itens` (`data`, `id_noc`, `mensagem`, `status`, `tipo`) ";

        $sql .= "VALUES ( :DATA, :ID_NOC, :MENSAGEM, :STATUS, :TIPO);";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":DATA", date('Y-m-d H:i:s'));

        $sql->bindValue(":ID_NOC", $id_noc);

        $sql->bindValue(":TIPO", $tipo); // AUTO OU MANUAL

        $sql->bindValue(":STATUS", $status); // INCIDENTE E RESOLVIDO

        $sql->bindValue(":MENSAGEM", $mensagem);

        $sql->execute();
       


        if ($sql->rowCount() > 0) {

            return $this->db->lastInsertId();
        }

    }

    /*@EXTRACT: id_noc,tipo,status;
    * SELECIONA ID NOC, TIPO E STATUS PARA COMPARAR OS REGISTROS EXISTENTE NA TABELA NOC ITENS.
    */
    public function extraiIdNocNoc_items($id_noc,$tipo,$status){

        $sql = "SELECT id_noc, tipo, status  FROM `noc_itens` WHERE `id_noc` =:ID_NOC AND `tipo` =:TIPO AND `status` =:STATUS";

        $sql = $this->db->prepare($sql);

        $sql->bindValue(":ID_NOC", $id_noc);

        $sql->bindValue(":TIPO", $tipo);

        $sql->bindValue(":STATUS", $status);

        $sql->execute();

        return $sql->fetchAll();
    }

    // =========FUNCIONALIDADES LISTAR EMPRESAS ===================
    /*DATA: 12-02-2018
    *
    *FUNCIONALIDADES LISTAR EMPRESAS 
    *LISTA APENAS EMPRESA QUE POSSUEM NOC 
    */

    public function listaEmpresasNoc(){

        // $query = "SELECT empresas.ID, empresas.RAZAOSOCIAL,empresas.FANTASIA,empresas.CNPJ,empresas.TELEMPRESA,empresas.ATIVO, empresas.EXCLUIDO, token_empresa.IDEMPRESA FROM empresas, token_empresa WHERE empresas.ID = token_empresa.IDEMPRESA";
        $query = "SELECT 
        ID, 
        RAZAOSOCIAL, 
        FANTASIA, 
        CNPJ, 
        TELEMPRESA,
        FOTOEMPRESA, 
        ATIVO,
        ZABBIX, 
        EXCLUIDO  
        FROM empresas WHERE ZABBIX <> 'DEFAULT' AND ZABBIX != ''";
        $stm = $this->db->prepare($query);

        $stm->execute();

        return $stm->fetchAll();

    }

    /*DATA: 13-02-2018
    *LISTA APENAS EMPRESA QUE POSSUEM NOC E RAMIFICAÇÕES
    */
    public function listaRamificao($id_empresa){

        // $query = "SELECT ramificacao.ID, ramificacao.EXCLUIDO, ramificacao.NOME,ramificacao.CNPJ,ramificacao.TELEMPRESA,ramificacao.CIDADE, ramificacao.BAIRRO, token_empresa.IDEMPRESA FROM ramificacao, token_empresa WHERE token_empresa.IDEMPRESA = ramificacao.IDEMPRESA AND token_empresa.IDEMPRESA =:ID_EMPRESA";
        $query = "SELECT 
        ramificacao.ID, 
        ramificacao.EXCLUIDO, 
        ramificacao.NOME, 
        ramificacao.CNPJ, 
        ramificacao.TELEMPRESA, 
        ramificacao.CIDADE, 
        ramificacao.BAIRRO, 
        empresas.ZABBIX 
        FROM 
        ramificacao, 
        empresas 
        WHERE 
        empresas.ID = ramificacao.IDEMPRESA 
        AND empresas.ID = :ID_EMPRESA 
        AND empresas.ZABBIX <> 'DEFAULT' 
        AND ramificacao.EXCLUIDO = 0";
        $stm = $this->db->prepare($query);

        $stm->bindValue(":ID_EMPRESA", $id_empresa);

        $stm->execute();

        return $stm->fetchAll();

    }

    /*DATA: 12-02-2018
    *SETA O ENDPOINT ZABBIX DE FORMA DINAMICA PARA CADA EMPRESA QUE POSSUI NOC
    */
    public function ApiZabbixEndPoint($id_empresa){

        $query = "SELECT ZABBIX FROM empresas WHERE ID =:ID_EMPRESA";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":ID_EMPRESA", $id_empresa);

        $stm->execute();

        return $stm->fetch();

    } // FIM DO METODO

    /*DATA: 12-02-2018
    *LISTA APENAS EMPRESA QUE POSSUEM NOC, EQUIPAMENTO
    */
    public function listaEquipamentos(){

        $query = "SELECT equipamento.ID, equipamento.IDRAMIFICACAO, equipamento.EXCLUIDO, equipamento.NOME, equipamento.HOST, equipamento.IP, equipamento.DDNS, token_empresa.HOSTID FROM equipamento, ramificacao, token_empresa WHERE ramificacao.ID = equipamento.IDRAMIFICACAO AND equipamento.ID = token_empresa.IDEQUIPAMENTO";

        $stm = $this->db->prepare($query);

        $stm->execute();

        return $stm->fetchAll();

    }

    // =========FIM FUNCIONALIDADES LISTAR EMPRESAS ===================



    //@DATA: 20-02-2020
    //CADASTRA HOSTS ZABBIX
    public function insertHostidApiZabbix($idEmpresa, $idLoja, $hostidZabbix, $idEquipamento){

        $query = "INSERT IGNORE INTO token_empresa(`IDEMPRESA`,`IDLOJA`,`HOSTID`, `IDEQUIPAMENTO`) VALUES(:IDEMPRESA,:IDLOJA,:HOSTID, :IDEQUIPAMENTO)";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":IDEMPRESA", $idEmpresa);

        $stm->bindValue(":IDLOJA", $idLoja);

        $stm->bindValue(":HOSTID", $hostidZabbix);
        
        $stm->bindValue(":IDEQUIPAMENTO", $idEquipamento);

        $stm->execute();

    }

    /*
    *DATA: 01-03-2020
    */
    //Lista os Host da tabela Equipamentos
    public function listIdHostApiZabbix($id_equipamento){

        $query = "SELECT equipamento.HOST FROM equipamento  WHERE ID =:ID_EQUIPAMENTO";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":ID_EQUIPAMENTO", $id_equipamento);

        $stm->execute();

        return $stm->fetch();
    }

    //Altera id do Host Zabbix da Tabela token empresa
    public function deletadHostApiZabbix($hostid){

        //$query = "DELETE FROM token_empresa WHERE HOSTID =:id_host";
        $query = "UPDATE  `token_empresa` SET `ATIVO` = '0'  WHERE HOSTID =:id_host";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":id_host", $hostid);

        $stm->execute();

    }

    //Lista os id do Host
    public function listaIdHostZabbix($id_equipamento){

        $query = "SELECT token_empresa.HOSTID FROM token_empresa, equipamento WHERE  equipamento.ID =:EQUIPAMENTO";

        $stm = $this->db->prepare($query);

        $stm->bindValue(":EQUIPAMENTO", $id_equipamento);

        $stm->execute();

        return $stm->fetch();

    } // Fim do Metodo: listaIdHostZabbix

    //Lista id Equipamento
    public function listaIdEquipamento($id){

       $query = "SELECT HOSTID FROM token_empresa WHERE HOSTID =:EQUIPAMENTO";

       $stm = $this->db->prepare($query);

       $stm->bindValue(":EQUIPAMENTO", $id);

       $stm->execute();


       return $stm->fetch();

    } // Fim do Metodo: listaIdEquipamento

    
    /*
    *DATA: 27-03-2020
    *@Lista o Host zabbix
    */
    public function getIdEquipamento($id){

       $query = "SELECT HOSTID FROM token_empresa WHERE IDEQUIPAMENTO =:EQUIPAMENTO";

       $stm = $this->db->prepare($query);

       $stm->bindValue(":EQUIPAMENTO", $id);

       $stm->execute();


       return $stm->fetch();

    } // Fim do Metodo: listaIdEquipamento


    /*
    *Query para listar somente a empresa que o usuario estiver logado
    */
    public function listaEmpresasMonitoramentoNoc(){

        $query = "
                SELECT
                empresas.ID, 
                empresas.RAZAOSOCIAL, 
                empresas.FANTASIA, 
                empresas.CNPJ, 
                empresas.TELEMPRESA,
                empresas.FOTOEMPRESA, 
                empresas.ATIVO,
                empresas.ZABBIX, 
                empresas.EXCLUIDO,
                `noc`.`status`,
                noc.id_empresa,
                noc.id_cliente,
                `equipamento`.`HOST`,
                noc.urgencia,
                noc.mensagem
            FROM empresas,noc, token_empresa, equipamento
            
                WHERE ZABBIX <> 'DEFAULT' AND ZABBIX != ''
                
                AND `noc`.`status` = 'ABERTO'
                
                AND noc.id_cliente = empresas.ID
                
                AND equipamento.ID = token_empresa.IDEQUIPAMENTO
                
                and token_empresa.HOSTID = noc.id_host
            ";

        $stm = $this->db->prepare($query);

        $stm->execute();

        return $stm->fetchAll();            

    }

    /*@Lista os id clientes Noc para que posterior possam serem recuperados
    */
    public function listIdClientesNoc(){


       $query = "
            SELECT
                `noc`.`status`,
                `noc`.`id_empresa`,
                `noc`.`id_cliente`,
                `equipamento`.`HOST`,
                `noc`.`urgencia`,
                `noc`.`mensagem`
        
            FROM empresas,noc,equipamento,token_empresa 
            
            WHERE 

                `noc`.`id_cliente` = id_cliente       
            AND
                `noc`.`status` = 'ABERTO'
            AND 
                `noc`.`id_empresa` = `empresas`.`ID`
                
            AND `equipamento`.`ID` = `token_empresa`.`IDEQUIPAMENTO`
            
            AND `token_empresa`.`HOSTID` = `noc`.`id_host`

            AND `token_empresa`.`IDEMPRESA` = `noc`.`id_empresa`";

       $stm = $this->db->prepare($query);

       //$stm->bindValue(":IDCLIENTE", $id_cliente);

       $stm->execute();


       return $stm->fetchAll();

    } // Fim do Metodo listIdClientesNoc

   
    /*
    *DATA: 31-03-2020
    *Faz backups dos hosts Appliance no sistema SdBusiness
    */

    //BKPS de Grupos de Host
    public function bkpGruposAppliance($groupid, $nome){

        try{
            $query = "INSERT IGNORE INTO zgrupos(`GROUPID`,`NOME`) VALUES(:GROUPID,:NOME)";

            $stm   = $this->db->prepare($query);

            $stm->bindValue("GROUPID", $groupid);

            $stm->bindValue("NOME", $nome); 

            $stm->execute();
          
          }catch(PDOException $e){

             echo "Error na atualização do Backups: ". $e->getMessage();
          }  
    }

    //BKPS de templates Appliance
    public function bkpTemplateAppliance($idgroup,$nome,$nomevisivel,$templateid,$descricao){

        try{
            $query = "INSERT IGNORE INTO(IDGROUP,NOME,NOMEVISIVEL,TEMPLATEID,DESCRICAO) VALUES(:IDGROUP, :NOME, :NOMEVISIVEL, :TEMPLATEID, :DESCRICAO)";

            $stm   = $this->db->prepare($query);

            $stm->bindValue(":IDGROUP", $idgroup);

            $stm->bindValue(":NOME", $nome);

            $stm->bindValue(":NOMEVISIVEL", $nomevisivel);

            $stm->bindValue(":TEMPLATEID", $templateid);

            $stm->bindValue(":DESCRICAO", $descricao);

            $stm->execute();

           }catch(PDOException $e){

             echo "Error na atualização do Backups: ". $e->getMessage();
           } 
    }

    //BKPS de Itens Appliance
    public function bkpItemAppliance($hostid,$nome,$type,$value_type,$interface,$delay){

        try{
            $query = "INSERT IGNORE INTO(HOSTID,NOME,TYPE,VALUE_TYPE,INTERFACE,DELAY) VALUES(:HOSTID, :NOME, :TYPE, :VALUE_TYPE, :INTERFACE, :DELAY)";

            $stm   = $this->db->prepare($query);

            $stm->bindValue(":HOSTID", $hostid);

            $stm->bindValue(":NOME", $nome);

            $stm->bindValue(":TYPE", $type);

            $stm->bindValue(":VALUE_TYPE", $value_type);

            $stm->bindValue(":INTERFACE", $interface);

            $stm->bindValue(":DELAY", $delay);

            $stm->execute();
          
          }catch(PDOException $e){

            echo "Error na atualização do Backups: ". $e->getMessage();
          }   

    }

    //BKPS de Triggers Appliance
    public function bkpTriggerAppliance(){

    }

    /*Fim da rotina*/


     /*
    *DATA: 22-04-2020
    *@CADASTRA OS TIPOS DE EQUIPAMENTOS DA CATEGORIAS 'Outros'
    */  
     public function cadastroTipoEquipamento($nome){

        try{
           $query = "INSERT tipo_outros(`NOME`) VALUES(:NOME)";

            $stm   = $this->db->prepare($query);

            $stm->bindValue(":NOME", $nome, PDO::PARAM_STR);

            $stm->execute();

          }catch(PDOException $e){

            return false;

          }  
     }

      /*
    *DATA: 22-04-2020
    *@LISTA OS TIPOS DE EQUIPAMENTOS DA CATEGORIAS 'Outros'
    */ 
     public function ListaTiposEquipamentos(){

       $query = "SELECT
                    `ID`,
                    `NOME`
                FROM `tipo_outros`";

       $stm = $this->db->prepare($query);

       $stm->execute();

       return $stm->fetchAll();
     
     } 
}
