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
    
      try{

        $eventos  = $this->model('/index','Incidentes');

        $evento = $eventos->mostra_incidentes_aberto();

        $data['dados'] = $evento;

        $this->view('/index','incidentes', $data);

      }catch(Exception $error){ }

    }

    //@ATALIZAÇÃO PARA QUE SE COMUNICA COM O ZABBIX E OS DADOS SEJAM ARMAZENADOS NO BANCO
    public function refresh(){

        $ApiZabbix = $this->model('/index','ApiZabbix');

        $urlApi = $ApiZabbix->requestApiZabbixUrl("http://172.17.0.2/zabbix/api_jsonrpc.php");

        $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, 'Admin', 'zabbix');

        $teste  = $this->model('/index','Incidentes');
  
        //@Monta a data para buscar os incidentes no zabbix
        $monta_data = date("Y-m-d H:i:00", strtotime('-30 minutes'));

        //@COnverte para data UNIX
        $converte_data = strtotime($monta_data);

        $add_data = new DateTime("@$converte_data");
          
        $add_data->format('U');

        $aberto = @$ApiZabbix->buscaEventoAbertoApiZabbix($urlApi, $login->result, $login->id, "event.get");

        foreach($aberto->result as $i => $eventos){

          $data_abertura = date('Y-m-d H:i:s', $eventos->clock);

          $teste->insertIncidentesApi(@$eventos->hosts[0]->hostid, $eventos->eventid,$eventos->name,$data_abertura, @$eventos->relatedObject->templateid);
            
        } 

        $this->encerraIncidentes($urlApi, $login->result, $login->id);

    }

      /*
  *DATA: 27-06-2020
  *
  *AS FUNCIONALIDADES ABAIXO TEM COMO OBJETIVO A CORRECAO E MELHORIAS NO MOMENTOS DA ATUALIZACAO E ADICAO DE HOSTS NOS APPLIANCES
 */
  public function encerraIncidentes($urlApi, $user, $pass){

        $ApiZabbix = $this->model('/index','ApiZabbix');

         $teste  = $this->model('/index','Incidentes');

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

                    $data_encerramento = date("Y-m-d H:i:s ", @$fechado->result[0]->clock);

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

}