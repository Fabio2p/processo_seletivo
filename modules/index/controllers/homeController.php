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
        $this->view("/index",'regra_de_negocios', $data);

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
        $ivento_id = '160';

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

       $this->library("vendor/autoload");

       //$this->library("vendor/random_string");

       //$obj02  = new MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
       
       $obj03  = new MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
       
       $obj04  = new MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;

       $urlAzure = "DefaultEndpointsProtocol=https;AccountName=".getenv('ACCOUNT_NAME').";AccountKey=".getenv('ACCOUNT_KEY');

     
       $blobClient = BlobRestProxy::createBlobService($urlAzure);
       
       $obj04->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

       $obj04->addMetaData("key1", "value1");
       
       $obj04->addMetaData("key2", "value2");


       try{

         $blobClient->createContainer($containerName, $createContainerOptions);
       
       }catch(ServiceException $e){



       }

       echo "Classe: ListBlobsOptions";
       
       echo "<hr>";
        var_dump($obj03);
       echo "<hr>";


       echo "Classe: CreateContainerOptions";
       
       echo "<hr>";
        var_dump($obj04);
       echo "<hr>";  
       

    }

    public function interacao(){

      
      $this->view("/index", 'checkUpload');
   
    }
}