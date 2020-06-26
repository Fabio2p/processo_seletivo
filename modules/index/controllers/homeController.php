<?php
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

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

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

         $listaTriggers = array(
                
            "params" => array('output' => 'hostid', 'host','name'),

            'selectTriggers' => array('triggerid','description'),

        );

            //@Lista host para serem customizados de acordo com a necessidade da empresa
        $exibeTrigers = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $listaTriggers);



       //@Regras aplicada ao template, onde a extração dos dados do mesmo será necessario para a entregas dos dados entre o zabbix e o sistema 
       $regras_template = array(

            "params" => array("templateid"),

            "selectTriggers" => array('triggerid')
       ); 

       $lista_regras_templates =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "template.get", $regras_template);

     //fim da aplicação da regra do template  

        $data['regras_lista_hosts'] = $exibeTrigers;

        $data['regras_lista_template'] = $lista_regras_templates;


        //@method override: chama o método view 
        $this->view("/index",'desassociacao_host', $data);


          $lista = array(
                
            "params" => array('output' => 'hostid', 'host','name'),

            'selectTriggers' => array('triggerid','description'),

        ); 

         $hostid_associado =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $lista);


         echo "<pre>";
            print_r($hostid_associado->result);
         echo "</pre>";

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

        /*Melhoria na data de busca de incidentes do zabbix*/
         
        //@Monta a data para buscar os incidentes no zabbix
        $monta_data = date("Y-m-d H:i:00", strtotime('-30 minutes'));

        //@COnverte para data UNIX
        $converte_data = strtotime($monta_data);

        $add_data = new DateTime("@$converte_data");
          
        $add_data->format('U');

        $data_busca_incidente = $add_data->getTimestamp();


       // echo $data_busca_incidente;

        
        /*Fim da melhorias*/
        
        $aberto = @$ApiZabbix->buscaEventoAbertoApiZabbix($urlApi, $login->result, $login->id, "event.get");


         foreach($aberto->result as $i => $eventos):

            echo "Incidentes Aberto: ". $eventos->eventid .'<br>';
            echo "Incidentes Fechado: ". $eventos->r_eventid .'<br>';

        if($eventos->r_eventid != 0):  

           $fechado = @$ApiZabbix->buscaEventoFechadoApiZabbix($urlApi, $login->result, $login->id, "event.get",$data_busca_incidente);

          //echo "Incidentes Aberto: ". $eventos->r_eventid .'<br>';

           foreach($fechado->result as $fecha):

              if($eventos->r_eventid === $fecha->eventid):

                echo "Incidentes Encerrados: ". $eventos->eventid .'<br>';

                echo "Id do Incidente: ". $fecha->eventid .'<br>';



              endif;  

           endforeach; 

        endif; 

        endforeach;  

        //@Fim das Regras no template
    }

    public function refreshDadosHistorico(){

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        
        //@Aqui entra os eventod cadastrado no banco
        $ivento_id = '16';

        $incidente_aberto = array("output" => array('eventid','r_eventid'),
          
          "filter" => array('value' => 1, "eventid" =>  $ivento_id)

        );
       
        
        $aberto = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "event.get",$incidente_aberto);

        foreach($aberto->result as $indice => $eventos){


          if($ivento_id == $eventos->eventid):

            $incidente_fechado = array(

                'output' => array('eventid', 'clock','value','name'),

                "filter" => array('value' => 0, "eventid" => $eventos->r_eventid)
              );


            $fechado = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "event.get",$incidente_fechado);

            // echo "<pre>";
            //   print_r($fechado->result);
            // echo "</pre>";
            
            for($i =0; $i <= $indice; $i++):

              $data_encerramento = date("Y-m-d H:i:s ", @$fechado->result[$i]->clock);

              echo $data_encerramento;  
            
            endfor;
        

          endif;  

        }  
       
    }



    public function addBlobAzure(){
       $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');


            //@Lista host para serem customizados de acordo com a necessidade da empresa
        $exibeTrigers = @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "hostgroup.get");



       //@Regras aplicada ao template, onde a extração dos dados do mesmo será necessario para a entregas dos dados entre o zabbix e o sistema 
       $regras_template = array(

            "params" => array("templateid"),

            "selectTriggers" => array('triggerid')
       ); 

       $lista_regras_templates =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "template.get", $regras_template);

     //fim da aplicação da regra do template  

        $data['regras_lista_hosts'] = $exibeTrigers;

        $data['regras_lista_template'] = $lista_regras_templates;


        //@method override: chama o método view 
        $this->view("/index",'cadastro_host', $data);


       

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


    public function czpe(){

       $ApiZabbix = $this->model('/index','ApiZabbix');

       $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.3/zabbix/api_jsonrpc.php");
        
         $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');


        $lista_templates_associados = array(

          "filter" => array('hostid' =>  $_POST['pegaHost']),
         
          "selectParentTemplates" => array('templateid')
        
        );


      $id_templates_associado =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.get", $lista_templates_associados);

          
      foreach($id_templates_associado->result as $i => $item): 

          foreach($item->parentTemplates as $templates_host_associados):

              $seleciona_templates_associados[] = $templates_host_associados->templateid;

          endforeach;

      endforeach;  


       $substitui = array(
                          
                          "hostid" => $_POST['pegaHost'],

                          "templates" => $_POST['itTemplate'],

                          "templates_link" => $seleciona_templates_associados
                        
                        );

        $atualiza =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.update", $substitui);

       echo "<pre>";
          print_r($atualiza);
       echo "</pre>";
        
    
    }

    public function disponibilidade(){
        header('Refresh:60');
        $this->modelCustom('/index','Ping');

       $this->view('/index','disponibilidade');
      
    }
    
}