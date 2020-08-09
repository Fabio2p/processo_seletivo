<?php
/**
 * 
 */
class addHost extends Controller
{
	
	public function index()
	{

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


		$this->view("/index", 'addHost', $data);
	}

	public function salvaHost()
	{
		
		//header('Content-type: application/json');

		
		//echo json_encode($response_array);


		$ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.2/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');



		$add_host = array(

						'host' 		 => $_POST['equipamento'],

						'name' 		 => $_POST['nome'],

						'templates'  => $_POST['template'],

						'groups'     => array($_POST['grupos']),

						'interfaces' => array(
											  'type'  => 1,
											  
											  'main'  => 1,
											  
											  'useip' => 1,

											  'ip'    =>  $_POST['ip'],

											  'dns'   =>  $_POST['dns'],

											  'port'  =>  80,

											 )

					);


		 $addHost =  @$ApiZabbix->responseApiZabbixExecute($urlApi, $login->result, $login->id, "host.create",$add_host);


		   // echo "<pre>";
		   // 		print_r($addHost);
		   // echo "</pre>";


		

		 if(@$addHost->result->hostids[0]):

		 	
			$this->convertJSON([
								'error' => false,

								'mensagem' => 'Cadastro realizado com sucesso!']);

		else:

		   $this->convertJSON([
		   					   'error' => true,

		   					   'mensagem' => $addHost->error->data]);

		endif;	



		// header('Content-type: application/json');

		// 	$result = array('error' => false,
							
		// 					'mensagem' => 'Cadastro realizado com sucesso!'

		// 					);
			
		// 	echo json_encode($result);


	}

	public function TESTEJSON(){

		$host = $this->model('/index', 'Nocs');

		echo json_encode($host->selecionaNoc_host());
	}
}