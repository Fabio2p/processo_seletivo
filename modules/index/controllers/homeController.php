<?php

/**
 * Author: Fábio Silveira dos Anjos
 * 
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * 
 * data: 17-08-2019
 * 
 * Classe Home: carrega a pagina inicial da app
 * 
 */
class Home extends Controller{

  public function index(){


   $this->view("/index",'formulario');
   
  }

  public function blobAzureImages(){

    $azure = $this->model('/index','ApiImagesBlobAzure');
    
    //$nome =   $_FILES["anexos"]["name"];

    //$path =   $_FILES["anexos"]["tmp_name"];
    

    //$typeMime = $_FILES["anexos"]["type"];

    //echo $typeMime;


    $nomeImagem = $azure->getNameImage('anexos');


    $pathImagem = $azure->getPathTmpImages('anexos');


    $mimeImage  = $azure->mimeTypeImage('anexos');


    echo "Nome: ". $nomeImagem .'<br>';

    //Lista imagens de um determinado container
    $teste = $azure->listImagesBlobAzure('homologacao');

    //Faz upload de umagens para um container 
    $azure->apiUploadImagesBlobAzure("homologacao/upload/sdredes/assinaturas",$nomeImagem, $pathImagem, $mimeImage);

}


  public function index_old(){

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.2/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

         $listaTriggers = array(
                
            "params" => array('output' => 'hostid', 'host','name'),

            'selectTriggers' => array('triggerid','description'),

        );

            //@Lista host para serem customizados de acordo com a necessidade da empresa
        $exibeHosts = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $listaTriggers);



       //@Regras aplicada ao template, onde a extração dos dados do mesmo será necessario para a entregas dos dados entre o zabbix e o sistema 
       $regras_template = array(

            "params" => array("templateid"),

            "selectTriggers" => array('triggerid')
       ); 

       $lista_regras_templates =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "template.get", $regras_template);


       $grupos = array('params' => array('extend'));


       $listaGrupos = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "hostgroup.get", $grupos);

     //fim da aplicação da regra do template  

        $data['regras_lista_hosts'] = $exibeHosts;

        $data['regras_lista_template'] = $lista_regras_templates;

        $data['grupos'] = $listaGrupos;


        //@method override: chama o método view 
        $this->view("/index",'regra_de_negocios', $data);


          $lista = array(
                
            "params" => array('output' => 'hostid', 'host','name'),

            'selectTriggers' => array('triggerid','description'),

        ); 

         $hostid_associado =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $lista);


    }


    public function getRegrasTriggers(){

         $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');
       

        $idHost    =  $_GET['id'];

        $lista = array(
                
            //"params" => array('output' => 'hostid', 'host','name'),

            'params' => array('triggerid', 'description'),

            "filter" => array('hostid' => (int) $idHost)
        );



         $exibe = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "trigger.get", $lista);
        

         echo json_encode($exibe->result);

    }


    public function salvar(){

       $noc = $this->model("/index", 'Nocs');

       //Id da empresa
       $idEmpresa = '1';

       //Adiciona o id do Template
        $idTemplate = isset($_POST['rnTemplate']) ? $_POST['rnTemplate'] : 0;

        //Adiciona o id do Equipamento
        $equipamento = isset($_POST['equipamento']) ? $_POST['equipamento'] : 0;

        $idTriggers = $_POST['checkeds']; 

        //Notifica o cliente caso esteja marcado
        $notificaCliente = $_POST['rnCliente'];

         //Notifica o cliente caso esteja marcado
        $notificaEmpresa = $_POST['rnEmpresa'];

        //Se adicionado, renotifica o incidente
        $renotifica_interacao = $_POST['renotificacao'];

        //Adiona a severidade da empresa ao invez da do zabbix
        $severidade = $_POST['severidade'];

        //Prazo para que o cliente seja notificado
        $tempo_notifica_cliente = $_POST['tempoNotificaCliente'];

        //Prazo para que a EMpresa seja notificado
        $tempo_notifica_empresa = $_POST['tempoNotificaEmpresa'];


        $count = count($idTriggers);

        for($i=0;$i<$count;$i++):


            $noc->cadastroRegrasNegocios($idEmpresa,$idTemplate,$equipamento,$severidade,$notificaCliente,$notificaEmpresa,$tempo_notifica_cliente,$tempo_notifica_empresa,$renotifica_interacao,$idTriggers[$i]);
    
        endfor;
    }
    

    public function swheetAlert(){

    	/*$data = true;

    	if($data == true):

    		echo "Cadastro realizdo com sucesso";

    	else:
    	
    		echo "Falha ao cadastrar os dados";	

    	endif;	*/
    }


    public function refreshDados(){

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        $teste  = $this->model('/index','Nocs');

        /*Melhoria na data de busca de incidentes do zabbix*/
         
        //@Monta a data para buscar os incidentes no zabbix
        $monta_data = date("Y-m-d H:i:00", strtotime('-30 minutes'));

        //@COnverte para data UNIX
        $converte_data = strtotime($monta_data);

        $add_data = new DateTime("@$converte_data");
          
        $add_data->format('U');

        $data_busca_incidente = $add_data->getTimestamp();



    
        /*Fim da melhorias*/
        
        $aberto = @$ApiZabbix->buscaEventoAbertoApiZabbix($urlApi, $login->result, $login->id, "event.get");

         //echo "<pre>";
         //  print_r($aberto->result);
         //echo "</pre>";

         //$exibe_host = $teste->mostra_host();
        //@Aqui entra os eventod cadastrado no banco

         $mostra_empresa = $teste->mostra_empresa();

         //$regras_de_notificao = $teste->regras_notifica();
       
       foreach($mostra_empresa as $h => $detalha):
       
        if($detalha['NOC'] == 1):

           foreach($aberto->result as $i => $eventos):

            if(@$eventos->hosts[0]->hostid ==  @$detalha['HOSTID']):

              $data_abertura = date('Y-m-d H:i:s', $eventos->clock);

              echo "Incidentes Aberto: ". $eventos->eventid .' '. 'Descrição: '. $eventos->name .'Data de Abertura: '.date('Y-m-d H:i:s', $eventos->clock).' Id da Trigger: '.@$eventos->relatedObject->triggerid.'<br>';

                $teste->insertIncidentesApi(@$eventos->hosts[0]->hostid, $eventos->eventid,$eventos->name,$data_abertura,@$detalha['ID_EMPRESA'], @$eventos->relatedObject->templateid);
             
            endif;

          endforeach;  

        elseif($detalha['NOTIFICA_CLIENTE'] == 1):

        
           foreach($aberto->result as $i => $evento):

            if(@$evento->hosts[0]->hostid ==  @$detalha['HOSTID']):
                
                $data_abertura = date('Y-m-d H:i:s', $evento->clock);

                $teste->insertIncidentesApi(@$evento->hosts[0]->hostid, $evento->eventid,$evento->name,$data_abertura,@$detalha['ID_EMPRESA'], @$evento->relatedObject->templateid);

            endif;

          endforeach;  

      

        endif;  

      endforeach;  

      $this->encerraIncidentes($urlApi, $login->result, $login->id);

        //@Fim das Regras no template
    }

      /*
  *DATA: 27-06-2020
  *
  *AS FUNCIONALIDADES ABAIXO TEM COMO OBJETIVO A CORRECAO E MELHORIAS NO MOMENTOS DA ATUALIZACAO E ADICAO DE HOSTS NOS APPLIANCES
 */
  public function encerraIncidentes($urlApi, $user, $pass){

        $ApiZabbix = $this->model('/index','ApiZabbix');

         $teste  = $this->model('/index','Nocs');

        //$urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        //$login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        
        $exibe_incidentes = $teste->mostra_incidentes_aberto();
        //@Aqui entra os eventod cadastrado no banco
       
       foreach($exibe_incidentes as $i => $detalha):

           $incidente_aberto = array("output" => array('eventid','r_eventid'),
            
             "filter" => array('value' => 1, "eventid" =>  $detalha['ID_INCIDENTE']),

             "selectRelatedObject" => "extend"

          );
         
          
           $aberto = @$ApiZabbix->responseApiZabbixExecute($urlApi, $user, $pass, "event.get",$incidente_aberto);


          foreach($aberto->result as $e_a => $detalhamento):

              if($detalhamento->eventid == $detalha['ID_INCIDENTE'] && @$detalhamento->relatedObject->triggerid):
                  
                echo  "Podem ser fechado: ". $detalhamento->eventid .'<br>';

                $incidente_fechado = array(

                  'output' => array('eventid', 'clock','value','name'),

                  "filter" => array('value' => 0, "eventid" => $detalhamento->r_eventid)
                );


                $fechado = @$ApiZabbix->responseApiZabbixExecute($urlApi, $user, $pass, "event.get",$incidente_fechado);

                  
                for($e_f = 0; $e_f <= $e_a; $e_f++):

                  if(@$fechado->result[$e_f]->eventid == $detalhamento->r_eventid):

                    $status = "RESOLVIDO";

                    $data_encerramento = date("Y-m-d H:i:s ", @$fechado->result[$i]->clock);

                    $teste->update_incidentes($detalhamento->eventid,$status, $data_encerramento);

                  endif;

                endfor;           

               else:

                $status = "CANCELADO";

                $data = date("Y-m-d H:i:s");

                $teste->update_incidentes($detalhamento->eventid,$status,$data);

              endif;  

          endforeach;  
        
      endforeach;   
  
       
    }

    
  public function interacao(){


        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        
        $grupos    = $_POST['GruposHost'];

        $templates = $_POST['itTemplate'];

        $host = array(

          'host' => "Equipamento 01",

          'name' => "",

          'description' => "Implorando pelo retorno do id Host",

          'interfaces' => array('type' => 1, 
                                'main' => 1, 
                                'useip' => 1, 
                                'ip' => '192.168.2.3',
                                'dns' => '',
                                'port' => '10050'),

          'groups'     => $grupos,

          'templates'  => $templates,

          'macros'     => array('macro' => '{$USER_ID}','value' => "123321")

        );


        $GruposHosts = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.create",$host);

        echo "<pre>";
          print_r($templates);
        echo "</pre>";


        echo "<pre>";
          print_r($GruposHosts);
        echo "</pre>";
   
    }

    public function endpoint(){


        $ApiZabbix = $this->model('/index','ApiZabbix');

        $url1 = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.1/zabbix/api_jsonrpc.php");

        $url2 = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.2/zabbix/api_jsonrpc.php");

        $url3 = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $url4 = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.4/zabbix/api_jsonrpc.php");


         $api1 = $ApiZabbix->responseApiZabbixEndPoint($url1);

         $api2 = $ApiZabbix->responseApiZabbixEndPoint($url2);

         $api3 = $ApiZabbix->responseApiZabbixEndPoint($url3);

         $api4 = $ApiZabbix->responseApiZabbixEndPoint($url4);

         if($api1['http_code'] == 412):

             $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.1/zabbix/api_jsonrpc.php");

             $mensagem = "Appliance 01";


          elseif($api2['http_code'] == 412):
          

             $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.2/zabbix/api_jsonrpc.php");

             $mensagem = "Appliance 02";

          elseif($api3['http_code'] == 412):
          

             $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

             $mensagem = "Appliance 03";

           elseif($api4['http_code'] == 412):
          

             $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

             $mensagem = "Appliance 04";        

         endif; 
        


          $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');


        /*echo "<pre>";
          print_r($api1);
        echo "</pre>";*/
        

        echo $mensagem;

        //$login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');
        
        $teste = $ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get");


        echo "<pre>";
          print_r($teste->result);
        echo "</pre>";
    }

    /*
    *
    */
    
    public function rotinasbackup(){

        $ApiZabbix = $this->model('/index','ApiZabbix');
        
        $noc = $this->model("/index", 'Nocs');
        
        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");
        
        
        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');


        $dados_template = array(
             "params" => array('output' => 'extend'),
            
           //"selectTriggers" => array('triggerid','description'),
            
           "selectGroups" => array('groupid','name','hostids'),
            
           "selectApplications" => array('applicationid','name'),
            
           "selectItems" => array('itemid','name','type','snmp_community'),
            
           "selectMacros" => array('macro','value'),
        
            "selectInterfaces" => array('main','ip', 'dns','port','type','useip','bulk','interface_ref'),

          "selectMappings" => array('valuemapid')

        );


        $grupos =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "template.get",$dados_template);

        echo "<pre>";
          print_r($grupos);
        echo "</pre>";

        // $id_empresa = '1';

        //  foreach($grupos->result as $template):
        //   $noc->backups_tempates($id_empresa,$template->groups[0]->groupid,$template->templateid, $template->name);
        // endforeach;

        //foreach($grupos->result as $grupos):
          //$noc->backups_groups($id_empresa,$grupos->groupid, $grupos->name);
        //endforeach;


    }

    /*
     * 
     * 
     * 
     * 
     * */
    
    public function bkps(){
        
        $ApiZabbix = $this->model('/index','ApiZabbix');
        
        $noc = $this->model("/index", 'Nocs');
        
        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");
        
        $mensagem = "Appliance 04";
        
      
        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');
        
       
        //@Regras aplicada ao template, onde a extração dos dados do mesmo será necessario para a entregas dos dados entre o zabbix e o sistema
        
        $regras_template = array(
            
           "params" => array('output' => 'extend'),
            
           //"selectTriggers" => array('triggerid','description'),
            
           "selectGroups" => array('groupid','name','hostids'),
            
           "selectApplications" => array('applicationid','name'),
            
           "selectItems" => array('itemid','name'),
            
           "selectMacros" => array('macro','value'),
            
           "selectParentTemplates" => array('templateid','name'),
            
           "selectParentTemplates" => array('templateid','name'),
            
            "selectInterfaces" => array('main','ip', 'dns','port','type','useip','bulk','interface_ref'),
            
        );
        
        $lista_regras_templates =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $regras_template);
        
        $teste = json_encode($lista_regras_templates->result);
        
        
        $noc->backups(1, $teste);
        
//         echo "<pre>";
//            print_r($teste);
//         echo "</pre>";
        
        $teste = $noc->getBackup();
        
        $t = json_decode($teste[0]['BACKUP']);
        
//         echo "<pre>";
//             print_r($t);
//         echo "</pre>";
        
      
     
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        
        $xml .= "<zabbix_export>\n";

            $xml .= "\t<version>4.2</version>\n";
            
            $xml .= "\t<date>2020-06-16T23:59:13Z</date>\n";
        
            $xml .= "\t<groups>\n";
               
            $xml .= "\t</groups>\n";
                
        $xml .= "\t<hosts>\n";
     
           foreach ($t as $i => $k):
           
           $xml .= "\t\t<host>\n";
           
            $xml .= "\t\t\t<host>". $k->host ."</host>\n";
            $xml .= "\t\t\t<name>". $k->name ."</name>\n";
            $xml .= "\t\t\t<description>". $k->description ."</description>\n";
            
            if(!empty($k->proxy)){
                
                $xml .= "\t\t\t<proxy>". $k->proxy ."</proxy>\n";
            
            }else{
                
                $xml .= "\t\t\t<proxy/>\n";
            }
            
            $xml .= "\t\t\t<status>". $k->status ."</status>\n";
            $xml .= "\t\t\t<ipmi_authtype>". $k->ipmi_authtype ."</ipmi_authtype>\n";
            $xml .= "\t\t\t<ipmi_privilege>". $k->ipmi_privilege ."</ipmi_privilege>\n";
         
            $xml .= "\t\t\t<ipmi_username>". $k->ipmi_username ."</ipmi_username>\n";
            
            if(!empty($k->ipmi_password)){
                
                $xml .= "\t\t\t<ipmi_password>". $k->ipmi_password ."</ipmi_password>\n";
                
            }else{
                
                $xml .= "\t\t\t<ipmi_password/>\n";
            }
            
            $xml .= "\t\t\t<tls_connect>". $k->tls_connect ."</tls_connect>\n";
            $xml .= "\t\t\t<tls_accept>". $k->tls_accept ."</tls_accept>\n";
            
            if(!empty($k->tls_issuer)){
                
                $xml .= "\t\t\t<tls_issuer>". $k->tls_issuer ."</tls_issuer>\n";
                
            }else{
                
                $xml .= "\t\t\t<tls_issuer/>\n";
            }
            
            if(!empty($k->tls_subject)){
                
                $xml .= "\t\t\t<tls_subject>". $k->tls_subject ."</tls_subject>\n";
                
            }else{
                
                $xml .= "\t\t\t<tls_subject/>\n";
            }
            
            if(!empty($k->tls_psk_identity)){
                
                $xml .= "\t\t\t<tls_psk_identity>". $k->tls_psk_identity ."</tls_psk_identity>\n";
                
            }else{
                
                $xml .= "\t\t\t<tls_psk_identity/>\n";
            }
            
            if(!empty($k->tls_psk)){
                
                $xml .= "\t\t\t<tls_psk>". $k->tls_psk ."</tls_psk>\n";
                
            }else{
                
                $xml .= "\t\t\t<tls_psk/>\n";
            }
            
            if(!empty($k->parentTemplates[0]->name)):
            $xml .= "\t\t\t<templates>\n";
            
            foreach ($k->parentTemplates as $template):
            $xml .="\t\t\t\t<template>\n";
                $xml .= "\t\t\t\t\t<name>". $template->name ."</name>\n";
            $xml .="\t\t\t\t</template>\n";
            endforeach;
            
            $xml .= "\t\t\t</templates>\n";
            
            else:
            
            $xml .= "\t\t\t<templates/>\n";
            
            endif;    
            
            if(!empty($k->groups[0]->name)):
            
                $xml .= "\t\t\t<groups>\n";
               
                   foreach ($k->groups as $group):
         
                     $xml .= "\t\t\t\t<group>\n";
                        $xml .= "\t\t\t\t\t<name>". $group->name ."</name>\n";
                     $xml .= "\t\t\t\t</group>\n";
            
                   endforeach;
                    
                 $xml .= "\t\t\t</groups>\n";
                 
                 else:
                 
                 $xml .= "\t\t\t<groups/>\n";
                 
             endif; 
            
       
                 $xml .= "\t\t\t<interfaces>\n";
               
                 foreach ($k->interfaces as $item):
                    $xml .= "\t\t\t\t<interface>\n";
                     
                        $xml .= "\t\t\t\t\t<default>".$item->main ."</default>\n";
                        
                        $xml .= "\t\t\t\t\t<type>".$item->type ."</type>\n";
                            
                        $xml .= "\t\t\t\t\t<useip>".$item->useip ."</useip>\n";
                            
                        $xml .= "\t\t\t\t\t<ip>".$item->ip ."</ip>\n";
                        
                        if(!empty($k->dns)){
                            
                            $xml .= "\t\t\t\t\t<dns>". $k->dns ."</dns>\n";
                            
                        }else{
                            
                            $xml .= "\t\t\t\t\t<dns/>\n";
                        }
                            
                        $xml .= "\t\t\t\t\t<port>".$item->port ."</port>\n";
                            
                        $xml .= "\t\t\t\t\t<bulk>".$item->bulk ."</bulk>\n";
                        
                        if(!empty($k->interface_ref)){
                            
                            $xml .= "\t\t\t\t\t<interface_ref>". $k->interface_ref ."</interface_ref>\n";
                            
                        }else{
                            
                            $xml .= "\t\t\t\t\t<interface_ref/>\n";
                        }
                      
                    $xml .= "\t\t\t\t</interface>\n";
                   endforeach;
               
                 $xml .= "\t\t\t</interfaces>\n";
               
            
//               if(!empty($k->triggers[0]->description)):
              
//                  $xml .= "\t\t\t<triggers>\n";
//                    foreach ($k->triggers as $item):
//                     $xml .= "\t\t\t\t<trigger>" .$item->description ."</trigger>\n";
//                    endforeach;
//                  $xml .= "\t\t\t</triggers>\n"; 
//                 else:
                
//                  $xml .= "\t\t\t<triggers/>\n"; 
              
//               endif;   
             
              if(!empty($k->applications[0]->name)):
                 $xml .= "\t\t\t<applications>\n";
                    foreach ($k->applications as $application):
                    $xml .= "\t\t\t\t<application>\n";
                        $xml .= "\t\t\t\t\t<name>". $application->name ."</name>\n";
                    $xml .= "\t\t\t\t</application>\n";
                   endforeach;
                   
                 $xml .= "\t\t\t</applications>\n";
                 
                 else:
                 
                 $xml .= "\t\t\t<applications/>\n";
                 
              endif;   
              
//               if(!empty($k->items[0]->name)):
//                   $xml .= "\t\t\t<items>\n";
              
//                   foreach ($k->items as $itens):
//                   $xml .= "\t\t\t\t<item>\n";
//                   $xml .= "\t\t\t\t\t<name>". $itens->name ."</name>\n";
//                   $xml .= "\t\t\t\t</item>\n";
//                   endforeach;
                  
//                 $xml .= "\t\t\t</items>\n";
              
//               else:
              
//               $xml .= "\t\t\t<items/>\n";
              
//               endif;   
            
             if(!empty($k->macros[0]->macro)):
       
           $xml .= "\t\t\t<macros>\n";
               foreach ($k->macros as $macro):
                 
       
                    $xml  .= "\t\t\t\t<macro>\n";
                          $xml .= "\t\t\t\t\t<macro>". $macro->macro ."</macro>\n";
                          $xml .= "\t\t\t\t\t<value>". $macro->value ."</value>\n";
                       $xml .="\t\t\t\t</macro>\n";
                
               
               endforeach;
           $xml .= "\t\t\t</macros>\n";
           
           
           else:
           
           $xml .= "\t\t\t<macros/>\n";
           
           endif;
           
                 if(!empty($k->tags)){
                     
                     $xml .= "\t\t\t<tags>". $k->tags ."</tags>\n";
                     
                 }else{
                     
                     $xml .= "\t\t\t<tags/>\n";
                 }
           $xml .= "\t\t</host>\n";
           
           endforeach;
       
       $xml .= "\t</hosts>\n";
 
       $xml .= "</zabbix_export>";   
       
       header('Content-type: text/xml');
       
       header('Content-Disposition: attachment; filename="hosts_sdbusiness.xml"');
       echo $xml;
    }
    
   public function atualizaUrl(){
       
       echo "Data Atual: ". date("Y-m-d h:i:s");
   }
    

   public function passagemPorReferencia(&$valor, &$chave){

     $valor = 100;

     return $valor;
   }


  public function disponibilidade(){
        header('Refresh:60');
        $this->modelCustom('/index','Ping');

       $this->view('/index','disponibilidade');
      
    }

 /*
  *DATA: 27-06-2020
  *
  *AS FUNCIONALIDADES ABAIXO TEM COMO OBJETIVO A CORRECAO E MELHORIAS NO MOMENTOS DA ATUALIZACAO E ADICAO DE HOSTS NOS APPLIANCES
 */
  public function AtualizaEquipamentos(){

       $ApiZabbix = $this->model('/index','ApiZabbix');

       $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");
        
         $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');


      //ALTERA OS DADOS DOS HOSTS
      $substitui = array(
                          
                          "hostid" => $_POST['pegaHost'],

                          "templates" => $_POST['itTemplate'],

                          "name" => $_POST['equipamento'],

                          "host" => $_POST['equipamento'],

                          "groups"=> $_POST['grupos_host']
                          
                        );

      $atualiza =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.update", $substitui);

     

     //LISTA A INTERFACE DO HOST 
     $lista_interfaces = array(

        'filter' => array('hostid' => $_POST['pegaHost']),

        'selectInterfaces' => array('interfaceid')
     );
        

      $listar_interfaces =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $lista_interfaces);  
      

     //EXTRAI O ID DA INTERFACE DO HOST 
     foreach($listar_interfaces->result as $t => $item):

        $atualiza_interface = $item->interfaces[0]->interfaceid;

      endforeach;  

      
      //ALTERA OS DADOS DA INTERFACE DO HOST
      $up_interface = array(

        "interfaceid" => $atualiza_interface,

        "ip" => $_POST['ip'],

        "port" => $_POST['porta'],

        "dns" => $_POST['dns'] 
      
      );

    $t = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "hostinterface.update", $up_interface);  


     echo "<pre>";
      print_r($t);
     echo "</pre>";
    
    }

  /*
  *DEIXA OS DADOS PRE SELECIONADO PARA AS POSSIVEIS ALTERAÇOES
  * DE EQUIPAMENTOS
  */
  public function edicaoEquipamentos(){

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        //@FAZ O FILTRO DO HOST A SER RDITADO
        $lista_templates_associados = array(

          "filter" => array('hostid' =>  '10308'),
         
          "selectParentTemplates" => array('templateid')
        
        );


      //@REQUISITA OS DADOS AO APPLIANCES  
      $id_templates_associado =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $lista_templates_associados);

      
      //@FAZ A EXTRAÇÃO DOS DADOS COLETADO    
      foreach($id_templates_associado->result as $i => $item): 

          foreach($item->parentTemplates as $templates_host_associados):

              $seleciona_templates_associados[] = $templates_host_associados->templateid;

          endforeach;

      endforeach;  
      


      //@LISTA OS TEMPLATES NA CAIXA DE SELECAO
      $regras_template = array(

            "params" => array("templateid"),
       ); 

      //@REQUISITA OS DADOS AO APPLIANCES
      $lista_regras_templates =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "template.get", $regras_template);
      

      //@PASSA OS DADOS A VIEWS
      $data['regras_lista_template'] = $lista_regras_templates;

      //@PASSA OS DADOS A VIEWS
      $data['compara_selecao'] = $seleciona_templates_associados;


      $this->view("/index", 'verifica', $data);

    }

    public function ApiAzureBlob(){

        $target_url = "http://host.local.dev-sys/index/home/teste";    


        $post = array('file' =>'@' . $_FILES['anexos']['tmp_name']. ';filename=' . $_FILES['anexos']['name']
    );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $target_url);

        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");   
        
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: multipart/form-data'));
        //curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);   
        //curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);  
        //curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $result = curl_exec ($ch);

        if ($result === FALSE) {

            echo "Error sending" . $result .  " " . curl_error($ch);

            curl_close ($ch);

        }else{

            curl_close ($ch);

            echo  "Result: " . $result;

        }   


        }

        public function teste(){

          $sub_dir = '/var/www/html/projetos-dev/';

          $dir_to_save = getcwd();

          $name = uniqid().'-comprovante.png';

       
          file_put_contents($dir_to_save.$sub_dir.$_POST['file']);
        }
    
}