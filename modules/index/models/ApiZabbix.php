<?php
require_once __DIR__ ."/../config.module.php";

/* DATA:10-01-2020
 * Author: fabio.sdRedes
 * @CLASS: ApiZabbix
 * @Objective: Conectar a API Zabbix para: autenticar, criar usuarios, hosts, listar, alterar e deletar
 *  */
class ApiZabbix extends Dbo{

    /*@VAR: $url
     * */
    private $url = null;

    /*@METHOD: Permite insrir o endereco da url do zabbix
     * */
    public function requestApiZabbixUrl($url){

      $this->url = $url;

      return $this->url;

    }

    /*@METHOD: permite inserir as credenciais do zabbix para
     * */
    public function responseApiZabbixAuth($urlZabbix, $user, $password){

        /*@VAR:
         *
         * Formato de dados em JSON Aceito pela a API Zabbix
         *  */
        $credenciais = ["jsonrpc" => "2.0","method"  => "user.login",
                        "params"  => array("user" => $user, "password" => $password),
                        "id" => 1,
                        "auth" => null
                       ];

        /*@VAR:
         *
         * Codifica os dados em formato JSON
         *  */
        $rsJson = json_encode($credenciais, true);

        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        return $this->requestApiZabbixCurl($urlZabbix, $rsJson);

    }

    /*@METHOD:
     *
     *Trata os dados api zabbix  ao enviar e ao receber.
     * */
    public function responseApiZabbixExecute($urlApiZabbix, $authApiZabbix, $iUserZabix, $method, $params = array()){

        /*@VAR:
         *
         * Converte os dados passado via parametros em array */
        $credenciais = [

          "jsonrpc" => "2.0",

          "method"  => $method,

          "params" => $params,

             "auth" => $authApiZabbix,

             "id"   => $iUserZabix
        ];

        /*@VAR:
         *
         * Codifica os dados em JSON*/
        $rsJson = json_encode($credenciais, true);

        //echo $rsJson;
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        return $this->requestApiZabbixCurl($urlApiZabbix, $rsJson);
    }

    /*@METHOD:
     *
     *Trata os dados api zabbix  para cadastro de TEMPLATES ZABBIX.
     * */
    public function responseApiZabbixCreateTemplate($urlApiZabbix, $authApiZabbix, $iUserZabix,$method, $template,$nomeVisivel, $descricao,  $groupHosts){

        /*@VAR:
         *
         * Converte os dados passado via parametros em JSON */
        $credenciais = '{
            "jsonrpc": "2.0",
            
            "method": "'.$method.'",

            "params": {
            
                "host": "'.$template.'",
                
                "name": "'.$nomeVisivel.'",

                "description": "'.$descricao.'",

                "groups": [ '.$groupHosts.' ]
                
            },
            
            "auth" : "'.$authApiZabbix.'",
            "id"   : "'.$iUserZabix.'"
        }';

       
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        //echo $credenciais;
        return $this->requestApiZabbixCurl($urlApiZabbix, $credenciais);
    }

    

    /*@METHOD:
     *
     *Trata os dados api zabbix  para cadastro de hosts.
     * */
    public function responseApiZabbixCreateHost($urlApiZabbix, $authApiZabbix, $iUserZabix,$method, $host,$nomeVisivel,$groupid, $templateid, $descricao, $interfacesOpcionais = NUll, $v_macros = NULL){

        /*@VAR:
         *
         * Converte os dados passado via parametros em JSON */
        $credenciais = '{
            "jsonrpc": "2.0",
            
            "method": "'.$method.'",

            "params": {
            
                "host": "'.$host.'" ,

                "name" : "'.$nomeVisivel.'",

                "description" : "'.$descricao.'",                
                
                "interfaces": [
                    
                    '.$interfacesOpcionais.'
                ],
                
                "groups": [ '.$groupid.' ],
                
                "templates": [ '.$templateid.' ],

                "macros": ['.$v_macros.']
                
            },
            
            "auth" : "'.$authApiZabbix.'",
            "id"   : "'.$iUserZabix.'"
        }';

       
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        //echo $credenciais;
        return $this->requestApiZabbixCurl($urlApiZabbix, $credenciais);
    }

    /*@METHOD:
     *
     *Trata os dados api zabbix  para cadastro de hosts.
     * */
    public function responseApiZabbixUpdateHost($urlApiZabbix, $authApiZabbix, $iUserZabix,$method, $hostid, $host,$nomeVisivel, $descricao, $interfacesOpcionais = NUll, $groupid,$templateid, $v_macros = NULL){

        /*@VAR:
         *
         * Converte os dados passado via parametros em JSON */
        $credenciais = '{
            "jsonrpc": "2.0",
            
            "method": "'.$method.'",

            "params": {
                
                "hostid" : "'.$hostid.'",

                "host": "'.$host.'" ,

                "name" : "'.$nomeVisivel.'",

                "description" : "'.$descricao.'",                
                
                "interfaces": [
                    
                    '.$interfacesOpcionais.'
                ],
                
                "groups": [ '.$groupid.' ],
                
                "templates": [ '.$templateid.' ],

                "macros": ['.$v_macros.']
                
            },
            
            "auth" : "'.$authApiZabbix.'",

            "id"   : "'.$iUserZabix.'"
        }';

       
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        //echo $credenciais;
        return $this->requestApiZabbixCurl($urlApiZabbix, $credenciais);
    }

    /*@METHOD:
     *
     *Trata os dados api zabbix  para cadastro de Aplicacoes no zabbix.
     * */
    public function requestApiZabbixCreaApplication($urlApiZabbix, $authApiZabbix, $iUserZabix,$method, $name,$hostid){

        /*@VAR:
         *
         * Converte os dados passado via parametros em JSON */
        $credenciais = '{
            "jsonrpc": "2.0",
            
            "method": "'.$method.'",

            "params": {
            
                "name" : "'.$name.'",

                '.$hostid.'                
                
            },
            
            "auth" : "'.$authApiZabbix.'",
            "id"   : "'.$iUserZabix.'"
        }';

       
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        //echo $credenciais;
        return $this->requestApiZabbixCurl($urlApiZabbix, $credenciais);
    }

    /*@METHOD:
     *
     *Trata os dados api zabbix  para cadastro de ITENS ZABBIX.
     * */
    public function responseApiZabbixCreateItens($urlApiZabbix, $authApiZabbix, $iUserZabix,$method, $nome, $key_, $hosts, $applications = NULL, $delay, $tipoAgente, $tipo_valor){

        /*@VAR:
         *
         * Converte os dados passado via parametros em JSON */
        $credenciais = '{
            
            "jsonrpc": "2.0",
            
            "method": "'.$method.'",

            "params": {
            
                "name": "'.$nome.'",

                "key_": "'.$key_.'",

                "type": "'.$tipoAgente.'",
                
                "value_type": "'.$tipo_valor.'",

                '.$hosts.',

                "applications": [ '.$applications.' ],

                "delay": "'.$delay.'"
                
            },
            
            "auth" : "'.$authApiZabbix.'",

            "id"   : "'.$iUserZabix.'"
        }';

       
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        //echo $credenciais;
        return $this->requestApiZabbixCurl($urlApiZabbix, $credenciais);
    }


    /*@METHOD: buscaEventosApiZabbix;
    *
    *Filtra um determinado id de um determinado evento Fechado
    */
    public function buscaEventoAbertoApiZabbix($urlApiZabbix, $authApiZabbix, $iUserZabix, $method, $pega_data = null){

            $credenciais = [

              "jsonrpc" => "2.0",

              "method"  =>  $method,
              
              //"actionids" => "11",

                "params"  => [
                                    
                   "output" => array('alertid','eventid','r_eventid','clock','name','message','value','severity'),
                                    
                   //"select_acknowledges" => "extend",
                                    
                   "selectHosts" => "extend",

                   "select_alerts" => "extend",
                   
                   "selectRelatedObject" => "extend",

                   "select_acknowledges" => array('eventid', 'clock'),

                   "filter" => array('value' => 1),
                                    
                   //"limit" => 10,

                   //"time_from" => 1583712000, //1580515200
                    "time_from" =>  $pega_data,
                    //"time_till" =>1577923200,

                   //"problem_time_from" => 1583712000,

                    "sortfield" => array('clock'),

                    "sortorder" => "DESC",
                 
                ],

              "auth" => $authApiZabbix,

              "id" => $iUserZabix
            ];

            /*@VAR:
             *
             * Codifica os dados em JSON*/
            $rsJson = json_encode($credenciais, true);

            //echo $rsJson;
            /*@CALL:
             *
             *Chama o metodo  requestApiZabbixCurl e retorna objetos
             *  */
            return $this->requestApiZabbixCurl($urlApiZabbix, $rsJson);

         
    }

    /*@METHOD: buscaEventoFechadoApiZabbix;
    *
    *Filtra um determinado id de um determinado evento fechado
    */
    public function buscaEventoFechadoApiZabbix($urlApiZabbix, $authApiZabbix, $iUserZabix, $method, $r_eventid = null, $pega_data = null){

            $credenciais = [

              "jsonrpc" => "2.0",

              "method"  =>  $method,
              
              //"actionids" => "11",

                "params"  => [
                                    
                   "output" => array('alertid','eventid','r_eventid','clock','name','message','value'),
                                    
                   //"select_acknowledges" => "extend",
                                    
                   "selectHosts" => "extend",

                   "select_alerts" => "extend",

                   "select_acknowledges" => array('eventid', 'clock'),

                   "filter" => array('value' => 0),

                   "eventid" => $r_eventid,
                                    
                    //"limit" => 10,
                    
                    //"time_from" =>  1583712000, //1580515200,
                    "problem_time_from" =>  $pega_data,
                    "time_till" =>$pega_data,

                    "problem_from" => $pega_data,
                    
                    "sortfield" => array('clock'),

                    "sortorder" => "DESC",
                 
                ],

              "auth" => $authApiZabbix,

              "id" => $iUserZabix
            ];

            /*@VAR:
             *
             * Codifica os dados em JSON*/
            $rsJson = json_encode($credenciais, true);

            //echo $rsJson;
            /*@CALL:
             *
             *Chama o metodo  requestApiZabbixCurl e retorna objetos
             *  */
            return $this->requestApiZabbixCurl($urlApiZabbix, $rsJson);

         
    }

    /*@METHOD: buscaEventosApiZabbix;
    *
    *Filtra um determinado id de um determinado evento Fechado
    */
    public function buscaItemApiZabbix($urlApiZabbix, $authApiZabbix, $iUserZabix, $method){

        $credenciais = [

          "jsonrpc" => "2.0",

          "method"  =>  $method,
          
            "params"  => [
                                
               "output" => array('name','key_','hostid','value_type','interfaceid','applications', 'delay'),
            ],

          "auth" => $authApiZabbix,

          "id" => $iUserZabix
        ];

        /*@VAR:
         *
         * Codifica os dados em JSON*/
        $rsJson = json_encode($credenciais, true);

        //echo $rsJson;
        /*@CALL:
         *
         *Chama o metodo  requestApiZabbixCurl e retorna objetos
         *  */
        return $this->requestApiZabbixCurl($urlApiZabbix, $rsJson);

     
    }
    
    /*@METHOD:
     *
     *Envia requisicao para a API Zabbix via CURL php */
    private function requestApiZabbixCurl($urlApiZabbix, $dataJson){

        /*@LIBS CURL PHP:
        */
        $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $urlApiZabbix);

            curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "POST" );

            curl_setopt ($ch, CURLOPT_COOKIEJAR, 'cookie.txt');

            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
            
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);

            curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);

            curl_setopt_array($ch, [

                CURLOPT_HTTPHEADER => array('Content-Type: application/json-rpc'),

                CURLOPT_FAILONERROR => true,

                CURLOPT_RETURNTRANSFER => true,

                CURLOPT_POST => true,

                CURLOPT_POSTFIELDS => $dataJson

            ]);

        $response = curl_exec($ch);

        curl_close($ch);
        
        return json_decode($response);

    }

}