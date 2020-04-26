<?php
class noc extends Controller {

    /*@var: seta o nome do modulo subsistema
    */
    private $modulo;

    /*@var: seta o nome do sistema
     */
    private $sistema;

    /*@var: seta o nome da Empresa
     */
    private $empresa;

    /*@var: seta a versao do sistema
     */
    private $versao;

    /*@var: seta a build do sistema
     */
    private $build;

    public function __construct() {

        /*@atribute: pega o nome do modulo*/
        $this->modulo = FILTER_INPUT(INPUT_GET, 'module', FILTER_SANITIZE_STRING);

        //@method override: chama a Model Users
         $u = $this->model("/{$this->modulo}", 'Users');

        // if ($u->isLogged() == FALSE) {

        //     header("Location:" . BASE_URL . "/{$this->modulo}/login");
        // }

        /*seta o nome do Sistema
        */
        $this->sistema  = App::nomeSistema();

        /*Seta o nome da Empresa
        */
        $this->empresa  = App::nomeEmpresa();

        /*Seta a Versão do sistema
        */
        $this->versao   = App::versaoSistema();

        /*Seta a build do Sistema
        */
        $this->build    = App::buildSistema();
    }

    /*
    *DATA: 11-03-2020
    *Lista Card de Empresas
    */
    public function index(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            //@method override: chama a Model Users
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            $noc = $this->model("/{$this->modulo}", 'Nocs');

            //@Lista as Empresa que contem Monitoramento
            $listaEmpresasNoc = $noc->listaEmpresasNoc();

            //Lista somente a empresa que o usuario estiver logado
            //$listaEmpresasNoc = $noc->listaEmpresasMonitoramentoNoc();

            $data['nome_usuario'] = $u->getName();

            $data['email'] = $u->getEmail();

            $data['fantasia'] = $u->getFantasia();

            $data['sobrenome'] = $u->getSobrenome();

            $data['id_usuario'] = $u->getId();

            $data['tecnico'] = $u->getTecnico();

            $data['id_empresa_usuario'] = $u->getIdempresa();

            $data['userCri'] = $u->getUserCri();

            $data['userMod'] = $u->getUserMod();

            $data['fantasia'] = $u->getFantasia();

            $data['imagem'] = $u->getFotoEmpresa();

            $data['fotoUsuario'] = $u->getFoto();

            $data['ipExterno'] = $u->getUltIp();

            $data['modTicket'] = $u->modTicket();

            $data['modAtivos'] = $u->modAtivos();

            $data['ListaNumerosNoc'] =  $noc->listIdClientesNoc();

            if ($u->getTecnico()){

                //Nome do sistema
                $data['NOMESISTEMA'] = $this->sistema;

                // Nome da empresa
                $data['EMPRESA'] = $this->empresa;

                // Versão do sistema
                $data['VERSAO'] = $this->versao;

                // Build do sistema
                $data['BUILD'] = $this->build;

                $data['modulo'] = $this->modulo;

                //@Passa os dados para serem listados na view
                $data['listaEmpresas'] = $listaEmpresasNoc;


                //@method headerloadTemplate: chama a view headerTemplate
                $this->headerloadTemplate("/{$this->modulo}", 'headerTemplate', $data);

                //@method view: chama a view noc_aprovacao
                $this->view("/{$this->modulo}", 'noc_empresas', $data);

                //@method footerloadTemplate: chama a view footerTemplate
                $this->footerloadTemplate("/{$this->modulo}", 'footerTemplate', $data);

            } else {

                header('Location: '.BASE_URL ."/{$this->modulo}");
            }

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA


    }// Fim do Metodo: index


    /*
    *DATA: 11-03-2020
    *Lista os incidentes por Empresa
    */
    public function empresa(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            //@method override: chama a Model Users
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            $data['nome_usuario'] = $u->getName();

            $data['email'] = $u->getEmail();

            $data['fantasia'] = $u->getFantasia();

            $data['sobrenome'] = $u->getSobrenome();

            $data['id_usuario'] = $u->getId();

            $data['tecnico'] = $u->getTecnico();

            $data['id_empresa_usuario'] = $u->getIdempresa();

            $data['userCri'] = $u->getUserCri();

            $data['userMod'] = $u->getUserMod();

            $data['fantasia'] = $u->getFantasia();

            $data['imagem'] = $u->getFotoEmpresa();

            $data['fotoUsuario'] = $u->getFoto();

            $data['ipExterno'] = $u->getUltIp();

            $data['modTicket'] = $u->modTicket();

            $data['modAtivos'] = $u->modAtivos();

            if ($u->getTecnico()){

                //Nome do sistema
                $data['NOMESISTEMA'] = $this->sistema;

                // Nome da empresa
                $data['EMPRESA'] = $this->empresa;

                // Versão do sistema
                $data['VERSAO'] = $this->versao;

                // Build do sistema
                $data['BUILD'] = $this->build;

                $data['modulo'] = $this->modulo;

                $data['id_empresa'] = App::getId();

                //@method headerloadTemplate: chama a view headerTemplate
                $this->headerloadTemplate("/{$this->modulo}", 'headerTemplate', $data);

                //@method view: chama a view noc_aprovacao
                $this->view("/{$this->modulo}", 'noc_aprovacao', $data);

                //@method footerloadTemplate: chama a view footerTemplate
                $this->footerloadTemplate("/{$this->modulo}", 'footerTemplate', $data);

            } else {

                header('Location: '.BASE_URL ."/{$this->modulo}");
            }

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }//Fim do Método: empresa

    /*
    *DATA: 04-04-2020
    *Faz insersão dos Incidentes Zabbix
    */
    public function refreshNoc(){

        $this->modulo = FILTER_INPUT(INPUT_GET, 'module', FILTER_SANITIZE_STRING);

        $verifica_token = "B28FF9E84C162AB6258C9156AC30F1F35815ADCB";

        if(App::getHash() == $verifica_token):

            $u = $this->model("/{$this->modulo}", 'Users');

            $pegaDataAtual = strtotime(date("Y-m-d h:05:00"));


            /*@MODEL ApiZabbix:
            *
            * Cria uma instância da Model ApiZabbix
            *  */
            $ApiZabbix = $this->model("/{$this->modulo}", 'ApiZabbix');

            //@METHOD OVERRIDE: chama a Model Nocs
            $noc = $this->model("/{$this->modulo}", "Nocs");

            //@Chama o metodo lista empresa Noc e extrai a url do Appliace Zabbix
            $end_point_zabbix = $noc->listaEmpresasNoc();


            //@Chama o metodo lista empresa Noc e extrai a url do Appliace Zabbix
            $end_point_zabbix = $noc->ApiZabbixEndPoint(App::getId());

            /*@CALL requestApiZabbixUrl:
            *
            *METHOD OPCIONAL: Chama o metodo  requestApiZabbixUrl do  Api Zabbix.
                *  */
            $urlApi = $ApiZabbix->requestApiZabbixUrl($end_point_zabbix['ZABBIX']);

           /**
            * Valida usuarios appliance
            */
            $auth = $u->validaUserZBusiness();

            /*@CALL requestApiZabbixUrl:
            *
            *Chama o metodo de Autenticacao Api Zabbix
            *  */
            $login  = $ApiZabbix->responseApiZabbixAuth($urlApi, $auth['zbusiness_user'], $auth['zbusiness_hash']);


            //Lista os dados de incidentes aberto
            $evento_aberto = @$ApiZabbix->buscaEventoAbertoApiZabbix($urlApi, $login->result, $login->id, "event.get", $pegaDataAtual);

           // if(isset($evento_aberto->result[0]->eventid)):
            
            //Extrai od dados de Abertura do incidente
            foreach(@$evento_aberto->result as $i => $lista):

            //==INSECAO DA DATA DE ABERTUA DE INCIDENTES ZABBIX========================

                $data_abertura = date("Y-m-d H:i:s ", $lista->clock);

                //@EXTRACT: extrai os dados: token Empresa
                $listarEmpresa = $noc->getHostIdTokenEmpresa(App::getId());

                //@EXTRACT
                foreach($listarEmpresa as $i => $hostEmpresa):

                    //@COMPARE:
                    //Verifica se os HOSTID TOKEN EMPRESA EH IDENTICO AO HOST CADASTRADO NO ZABBIX
                    if($hostEmpresa['HOSTID'] === @$lista->hosts[0]->hostid):

                        //@CALL: Chama o metodo da Model Nocs para as possiveis inclusao
                        $noc->insertNocApiZabbix($hostEmpresa['IDEMPRESA'], $hostEmpresa['IDEMPRESA'], $hostEmpresa['IDLOJA'], $lista->hosts[0]->hostid, $lista->eventid, $lista->name, $data_abertura, $lista->severity);

                        //@CALL: extrai os dados id_noc
                        $pegaIdNoc = $noc->extraiIdNoc($lista->eventid);

                        //@EXTRACT:
                        //Verifica se o status e o tipo NOC ITENS eh igual ao cidado no metodo abaixo
                        $buscaIncidenteNoc_itens = $noc->extraiIdNocNoc_items($pegaIdNoc[0]['id_noc'], "AUTO", "incidente");

                        //@CONDITION:
                        //Se for verdadeiro nao faz nada, caso contrario adiciona os dados de abertura na tabela noc itens;
                        if($buscaIncidenteNoc_itens):

                           //return false;

                        else:

                            if(!empty($lista->name)):

                              //@CALL: Chama o metodo da Model Nocs para as possiveis insercao na tabela items Noc
                              $noc->addItensNocApiZabbix($pegaIdNoc[0]['id_noc'] ,$lista->name, "AUTO", "incidente");

                            else:

                              $noc->addItensNocApiZabbix($pegaIdNoc[0]['id_noc'] ,"Sem mensagem cadastrada!", "AUTO", "incidente");

                            endif;

                        endif;


            //===FIM DE INSERCAO========================================================

                    //Obtem dados nao nulos
                    $pegaRetornoEventoId = ($lista->r_eventid ? $lista->r_eventid : $lista->r_eventid = "NULL");

                    //Converte os dados em array
                    $r_eventid = array($pegaRetornoEventoId);

                    //Lista os dados de incidentes aberto
                    @$evento_encerrado = $ApiZabbix->buscaEventoFechadoApiZabbix($urlApi, $login->result, $login->id, "event.get",$r_eventid, $pegaDataAtual);

                        //if(isset($evento_encerrado->result[0]->eventid)):

                        //Extrai od dados de Encerramento do incidente
                        foreach(@$evento_encerrado->result as $k => $encerrado):

                            //Compara o retorno id do evento do incidente aberto com o evento do id do incidente finalizado
                            if($lista->r_eventid && $lista->r_eventid === $encerrado->eventid):

                                $data_encerramento = date("Y-m-d H:i:s ", $encerrado->clock);

                                //@CALL: Chama o metodo da Model Nocs para as possiveis alteracoes
                                $noc->finalizaNocApiZabbix($data_encerramento, $lista->eventid);

                                //@CALL: extrai os dados id_noc
                                $pegaIdNoc = $noc->extraiIdNoc($lista->eventid);

                                //@EXTRACT:
                                //Verifica se o status e o tipo NOC ITENS eh igual ao cidado no metodo abaixo
                                $buscaIncidenteNoc_itens = $noc->extraiIdNocNoc_items($pegaIdNoc[0]['id_noc'], "AUTO", "resolvido");


                                //@CONDITION:
                                //Se for verdadeiro nao faz nada, caso contrario adiciona os dados de abertura na tabela noc itens;
                                if($buscaIncidenteNoc_itens):

                                   //return false;

                                else:

                                    if(!empty($encerrado->alerts[0]->message)):

                                        //@CALL: Chama o metodo da Model Nocs para as possiveis insercao na tabela items Noc
                                        $noc->addItensNocApiZabbix($pegaIdNoc[0]['id_noc'] ,$encerrado->alerts[0]->message, "AUTO", "resolvido");

                                    else:

                                       $noc->addItensNocApiZabbix($pegaIdNoc[0]['id_noc'] ,"Sem mensagem cadastrada!", "AUTO", "resolvido");

                                    endif;

                                endif;

                            endif;

                        endforeach;

                       //endif; // fim da condicao

                    endif;

                endforeach;

            endforeach;

        // else:

        //     echo "<b>Alerta:</b> Nenhum incidente Aberto!";

        // endif;

        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

        endif;


    } // Fim do Metodo: refreshNoc

    public function getNoc(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            $idCliente = App::getId();

            $idNoc = App::getCatId();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            $nocItens = $n->getNoc($idCliente, $idNoc);

            if ($nocItens != false){

                echo json_encode($nocItens);

                return true;
            }

//        header("HTTP/1.1 401 Unauthorized");
            echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';

            return false;

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function nocItens(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            //Chama a Classe Helpers App do metodo getId()
            $id_noc = App::getId();

            $data = array();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');


            $nocItens = $n->getNocItens($id_noc);

            echo json_encode($nocItens);

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function nocCliente(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $idRamificacao = App::getId();



            //$idRamificacao = null;

            $data = array();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //@method override: chama a Model Empresas
            $e = $this->model("/{$this->modulo}", 'Empresas');

            $cliente = $e->getLoja($idRamificacao);

            echo json_encode($cliente);

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function incidentesRelacionados(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $idtrigger = App::getId();

            $data = array();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            $nocItens = $n->getNocIncidentes(123);

            echo json_encode($nocItens);

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function terceiros(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            $nocItens = $n->getNocTerceiros(123);

            echo json_encode($nocItens);


        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function sendActv(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            //@method override: chama a Model User
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            $idNoc      = isset($_POST['id_noc']) ? $_POST['id_noc'] : null;

            if (!isset($_POST['id_noc']) && !isset($_POST['upload'])){

                header("HTTP/1.1 401 Unauthorized");

                echo json_encode(['false']);

                return false;

            } else {

                $executar = isset($_POST['executar']) ? $_POST['executar'] : null;

                $mensagem = isset($_POST['mensagem']) ? $_POST['mensagem'] : null;

                $fator = isset($_POST['fator']) ? $_POST['fator'] : null;

                $protocolo = isset($_POST['protocolo']) ? $_POST['protocolo'] : '';

                $upload = array();

                foreach ($_POST['upload'] as $item){

                    array_push($upload, $item);
                }

                $uItem = false;

                switch ($executar){

                    case 'registrar':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'MENSAGEM',$mensagem);

                        $n->primeiroAtendimento($idNoc);

                        break;

                    case 'causador':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'CAUSADOR', $mensagem);

                        $n->primeiroAtendimento($idNoc);

                        $n->causadorNoc($idNoc, $fator, $protocolo);

                        break;

                    case 'falso positivo':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'FALSO POSITIVO',$mensagem);

                        $n->primeiroAtendimento($idNoc);

                        $n->falsoPositivoNoc($idNoc);

                        break;

                    case 'finalizar':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'RESOLVIDO',$mensagem);

                        $n->primeiroAtendimento($idNoc);

                        $n->finalizaNoc($idNoc);

                        break;

                    case 'foraExpediente':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'RESOLVIDO',$mensagem);

                        $n->primeiroAtendimento($idNoc);

                        $n->foraExpediente($idNoc, 'interno');

                        break;

                    case 'oscilacao':

                        $uItem = $n->addItensNoc($idNoc, 'MANUAL', 'FALSO POSITIVO',$mensagem);

                        $n->primeiroAtendimento($idNoc);

                        $n->oscilacao($idNoc, 'interno');

                        break;
                }

                if ($uItem != false){

                    foreach ($upload as $foto){

                        $data = 'data:image/png;base64,'.$foto;

                        list($type, $data) = explode(';', $data);

                        list(, $data)      = explode(',', $data);

                        $data = base64_decode($data);

                        $dir_to_save = getcwd().'/';

                        $sub_dir = 'upload/'.$this->modulo.'/noc/';

                        if (!is_dir($dir_to_save.$sub_dir)) {

                            mkdir($dir_to_save.$sub_dir);
                        }
                        $name = uniqid().'-comprovante.png';

                        file_put_contents($dir_to_save.$sub_dir.$name, $data);

                        $n->uploadAnexo($uItem, $sub_dir.$name);
                    }
                }

                header("HTTP/1.1 200 Ok");

                echo json_encode(['True', $uItem]);

                return true;
            }

            header("HTTP/1.1 401 Unauthorized");

            echo json_encode(['false']);

            return false;

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function detalhaItem(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $id_item = App::getId();

            $data = array();

            //@method override: chama a Model Users
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            $nocItens = $n->getNocItem($id_item);

            $nocAnexoItem = $n->getAnexos($id_item);

            $nocAnexoItem != false ? array_push($nocItens, $nocAnexoItem) : false;

            echo json_encode($nocItens);

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function abrirChamado(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            $u = $this->model("/{$this->modulo}", 'Users');

            //@method override: chama a Model Users
            $u->setLoggedUser();

            //method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            //@method override: chama a Model Categorias
            $cat = $this->model("/{$this->modulo}", 'Categorias');

            //@method override: chama a Model Empresas
            $emp = $this->model("/{$this->modulo}", 'Empresas');

            //@method override: chama a Model Ticket
            $t = $this->model("/{$this->modulo}", 'Ticket');

            //@method override: chama a Model Itensticket
            $item = $this->model("/{$this->modulo}", 'Itensticket');

            //@method override: chama a Model Email
            $m = $this->model("/{$this->modulo}", 'Email');

            //@method override: chama a Model Equipe
            $e = $this->model("/{$this->modulo}", 'Equipe');

            //@method override: chama a Model COnfigs
            $f = $this->model("/{$this->modulo}", 'Configs');

            $usrRequerente    = $u->getId();

            $empRequerente    = $u->getEmpresa();

            $empresaRequerida = $u->getMatriz();

            $idNoc            = isset($_POST['idNoc']) ? $_POST['idNoc'] : false;

            $assunto          = isset($_POST['ticketDescricao']) ? $_POST['ticketDescricao'] : false;

            $categoria        = isset($_POST['ticketCategoria']) ? $_POST['ticketCategoria'] : false;

            $mensagem         = isset($_POST['ticketMensagem']) ? $_POST['ticketMensagem'] : false;

            if (!$assunto || !$categoria || !$mensagem || !$idNoc){

                header("HTTP/1.1 401 Unauthorized");

                echo json_encode(['false','falta de parametros']);

                return false;
            }

            $f->getConfigTickets($u->getMatriz());

            $c = $cat->getCategoriasSla($u->getMatriz(), $categoria)['SLA_TEMPO'];

            if ($f->getSlaPorEmpresa()){

                $c            = $emp->getSlaEmpresa($empRequerente);
            }

            $slaTempo         = (int)$c[0] * 60;

            $dateSlaSolucao   = date('Y-m-d H:i:s');

            $last_id          = $t->newTicket($u->getId(), $u->getMatriz());
            $retTicket        = $t->insertNewTicket($usrRequerente, $empRequerente, $assunto, $categoria, $empresaRequerida, $last_id, $dateSlaSolucao, $slaTempo, $idNoc);
            $retItem          = $item->newItemTicket($last_id, $usrRequerente, $mensagem);

            if (($retTicket) and ($retItem)){

                $n->escalonarTicketNoc($idNoc, $last_id);

                echo json_encode([$last_id]);

                return true;
            }

            header("HTTP/1.1 401 Unauthorized");

            echo json_encode(['false']);

            return false;

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function getEquipamento(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $id = App::getId();

            $data = array();

            //@method override: chama a Model Users
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //@method override: chama a Model Empresas
            $e = $this->model("/{$this->modulo}", 'Empresas');

            echo json_encode($e->getEquipamento($id));

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

    public function getLastNoc(){

        //@method override: chama a Model Users
        $u = $this->model("/{$this->modulo}", 'Users');

        if ($u->isLogged() == FALSE) {

            header("Location:" . BASE_URL . "/{$this->modulo}/login");
        }

        /*VALIDA SE EXISTE UM TOKEN DO FORMULARIO DE LOGIN.
        * EM SEGUIDA, VERIFICA SE O MODULO EH IGUAL AO SISTEMA
        */
        if(isset($_SESSION['logado']['checa_token']) && $this->modulo == $_SESSION['logado']['sistema']):

            $data = array();

            //@method override: chama a Model Users
            $u = $this->model("/{$this->modulo}", 'Users');

            $u->setLoggedUser();

            //@method override: chama a Model Noc
            $n = $this->model("/{$this->modulo}", 'Nocs');

            echo json_encode(['last' => $n->getLastNoc()]);

        //EXIBE ERROR 404 E LIMPA A SESSAO
        else:

            //echo "Sistema nao identificado";

            $this->view("/{$this->modulo}", '404');

            /*Destroy a sessao do usuario*/
            App::session_destroy();

        endif; // FIM DA VERIFICACAO DE TOKEN E DO SISTEMA

    }

}
