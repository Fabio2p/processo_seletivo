<?php
/**
 * Author: Fábio Silveira dos Anjos
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * 
 * Data: 16-08-2019
 * 
 * Classe PainelAdministrativo
 */

class PainelAdministrativo extends Controller{

    public function Index(){

        App::session();

        if(isset($_SESSION['logado'])):

            $lista_registros = $this->model('/login', 'usuario');
            
            // exibe o título da página
            $dados['title'] = 'Dashboard - Painel Administrativo.';

            // exibe o nome do usuário
            $dados['nome_do_usuario'] = $_SESSION['logado']['nome_do_usuario'];

            /*
            * Metodo lista_dados: listas registros da base
            *
            */
            $dados['exibe_registros'] =  $lista_registros->lista_dados();


            /**
             *chama a view do modulo em:
             * 
             * ../modules/login/views/painelAdministrativo.view.php
             *
             */ 
            $this->view('/login', 'painelAdministrativo', $dados);

        else:

            App::session_destroy();

            
        endif;
        
    }

    /*
    * Método importa_xml: faz a importação dos dados de um arquivo xml para o banco de dados
    *
    */
    public function importa_xml(){

        /*classe auxliadora localizado em:
        *
        * ../system/helpers/App.php
        *
        */ 
        App::session();

        // Verifica se o usuário está logado
        if($_SESSION['logado']):

           if(isset($_SESSION['token'])):
            /* cria um instância da classe usuario localizado em:
            *
            * ../modules/login/models/usuarioModel.php 
            *
            */
            $importa_dados = $this->model('/login', 'usuario');

            if(isset($_FILES['importar_xml']['name'])):

                // Carrega os dados do arquivo xml
                $importa = simplexml_load_file($_FILES['importar_xml']['tmp_name']);

                // percorre os valores
                foreach($importa as $items):

                    /*
                    *
                    *chama o método importa_xml_banco para a inclusão dos dados no banco
                    *
                    */
                    $importa_dados->importa_xml_banco($items['nome'],$items['documento'],$items['cep'],$items['endereco'],$items['bairro'],$items['cidade'],$items['uf'],$items['telefone'],$items['email'],$items['ativo']);
                
                endforeach;
                    

                echo "Dados importado com Sucesso!";
                /*
                * Redireciona para a pagina de administação
                */
                header("Refresh: 1;url=?module=login&option=painel-administrativo&view=usuario/autenticado");

            endif; 

            else:

            App::session_destroy(); 

           endif;  

        else:

            App::session_destroy();

        endif;    

    }

    /*
    * Recebe os valores passado via parâmetro
    * Aloca os dados em campos editáveis
    */
    public function editar(){

        App::session();

        if(isset($_SESSION['logado'])):

            $id = FILTER_INPUT(INPUT_GET, 'id');

            if(isset($id)):


                $list_dado_unico = $this->model('/login', 'usuario');

                /*
                * seta o título da página
                */
                $passa_dados_para_view['title'] = "Dashboard - Editar Usuário!";

                $passa_dados_para_view['lista_objeto'] = $list_dado_unico->lista_dados_unico($id);

                $this->view('/login', 'editar_dados_usuario', $passa_dados_para_view);

             endif;   

         else:

            App::session_destroy();

        endif;

    }

    /*
    * Recebe os valores passado via formulário
    * Salva  os dados em banco
    */

    public function salvar_dados_edita(){

        App::session();

        if(isset($_SESSION['logado'])):

            if(isset($_SESSION['token'])):
                    
                $usuario = $this->model('/login', 'usuario');

                $id = $_POST['id'];

                $nome = $_POST['nome'];
                
                $documento = $_POST['documento'];
                
                $cep = $_POST['cep'];
                
                $endereco = $_POST['endereco'];
                
                $bairro = $_POST['bairro'];
                
                $cidade = $_POST['cidade'];
                
                $uf = $_POST['uf'];
                
                $telefone = $_POST['telefone'];
                
                $email = $_POST['email'];
                
                $ativo = $_POST['ativo'];

                $usuario->edita_dados_usuario($nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo, $id);

                echo  "Dados Editado com sucesso!";

               /*
                * Redireciona para a pagina de administação
                */ 
               header("Refresh: 1;url=?module=login&option=painel-administrativo&view=usuario/autenticado");

            else:

                App::session_destroy();

            endif;

        else:

            App::session_destroy();

        endif;

    }

    /*
    * Método cadastra_usuario: Cadastra usuario
    *
    */
    public function cadastra_usuario(){

        App::session();

        if(isset($_SESSION['logado'])):

            /*
                * seta o título da página
                */
                $titulo['title'] = "Dashboard - Cadastro de Usuário!";

            $this->view('/login', 'cadastro_usuario', $titulo);

         else:

            App::session_destroy();

        endif;


    }

     /*
    * Método: recebe os dados passado via parâmetros e salva em banco
    *
    */

    public function salvar_dados_cadastro(){

         App::session();

        if(isset($_SESSION['logado'])):

            if(isset($_SESSION['token'])):
                    
                $usuario = $this->model('/login', 'usuario');

                $nome = $_POST['nome'];
                
                $documento = $_POST['documento'];
                
                $cep = $_POST['cep'];
                
                $endereco = $_POST['endereco'];
                
                $bairro = $_POST['bairro'];
                
                $cidade = $_POST['cidade'];
                
                $uf = $_POST['uf'];
                
                $telefone = $_POST['telefone'];
                
                $email = $_POST['email'];
                
                $ativo = $_POST['ativo'];

                $usuario->salva_dados_usuario($nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo);

                echo  "Dados Salvos com sucesso!";

                /*
                * Redireciona para a pagina de administação
                */
                header("Refresh: 1;url=?module=login&option=painel-administrativo&view=usuario/autenticado");

            else:

                App::session_destroy();

            endif;

        else:

            App::session_destroy();

        endif;

    }

    /*
    * Carrega o formulario de E-mail
    */

    public function enviar_email(){

        App::session();

        if(isset($_SESSION['logado'])):

            /*
            * seta o título da página
            */
            $titulo['title'] = "Dashboard - Envio de E-mail!";

            $this->view('/login', 'formulario_envia_email', $titulo);

        else:

            App::session_destroy();

        endif;

    }

     /*
    * Método email_enviado: recebe os dados passado via parâmetros e para o E-mail do cliente
    *
    */
    public function email_enviado(){

        App::session();

        if(isset($_SESSION['logado'])):

            if(isset($_SESSION['token'])):
               
    
                $headers = "MIME-Version: 1.1\r\n";

                $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
                
                $headers .= "From: fabio.s.a.proweb@gmail.com\r\n";
                
                $headers .= "Return-Path: fabio.s.a.proweb@gmail.com\r\n";
                
                $envio = mail($_POST['envia_email'], "Notificação- p21 Sistema", $_POST['envia_texto'], $headers);
                 
                if($envio):

                    echo "E-mail enviada com sucesso";

                else:

                 echo "E-mail não pode ser enviada";

                endif;

                /*
                * Redireciona para a pagina de E-mail
                */
                header("Refresh: 1;url=?module=login&option=painel-administrativo&view=enviar_email");

            else: 

                App::session_destroy();

            endif;

        else:

            App::session_destroy();

        endif;

    }
}
