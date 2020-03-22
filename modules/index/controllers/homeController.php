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

	private $apiZabbix;

	private $urlApi;

	private $auth;

	public function __construct(){

		$this->apiZabbix = $this->model('/index', 'ApiZabbix');

		$this->urlApi = $this->apiZabbix->requestApiZabbixUrl('http://172.17.0.3/zabbix/api_jsonrpc.php');

		$this->auth = $this->apiZabbix->responseApiZabbixAuth($this->urlApi, 'fabio', '123456');
	}

    public function index(){
        
            /**
             * carrega a view login.view.php em:
             * 
             * ../modules/index/views/login.view.php 72.17.0.3
             */
          	

			$dados_host = array(
		                        "params" => array('output' => 'extend'),

		                        "selectGroups" => array('groupid', 'name'),

		                        "selectParentTemplates" => array('templateid','name'),

		                        "selectApplications" => array('applicationid','name'),

		                        "selectItems"   => array('itemid', 'name'),

		                        "selectTriggers" => array('triggerid', 'description'),

		                        "selectInterfaces" => array('ip', 'dns','port','type','useip'),

		                        //"filter" => array('hostid' => "{$idZabbix}")
		            );

			$listaHostIdZabbix = $this->apiZabbix->responseApiZabbixExecute($this->urlApi, $this->auth->result, $this->auth->id, "host.get", $dados_host);

		$data['hostIdZabbix'] = $listaHostIdZabbix;

		$this->view('/index', 'listarHost', $data);

    }

    public function grupoHost(){

    	$dados_host = array("params" => array('output' => 'extend'),

    						"selectHosts" => array('hostid','name'),

    						"selectTemplates" => array('templateid','name')

		                    );



    	$listaGruposZabbix = $this->apiZabbix->responseApiZabbixExecute($this->urlApi, $this->auth->result, $this->auth->id, "hostgroup.get", $dados_host);


    	$data['GruposHosts'] = $listaGruposZabbix;

    	$this->view('/index', 'grupoHost', $data);

    }

    public function template(){

    	$dados_host = array("params" => array('output' => 'extend'),

    						"selectGroups" => array('groupid','name'),

    						"selectHosts" => array('hostid','name')

		                    );



    	$listaTemplateZabbix = $this->apiZabbix->responseApiZabbixExecute($this->urlApi, $this->auth->result, $this->auth->id, "template.get", $dados_host);

    	$data['lista_template'] = $listaTemplateZabbix;

    	$this->view('/index', 'template', $data);
    }

    public function editaGrupoHost(){

    	var_dump($_POST);
    }

}
