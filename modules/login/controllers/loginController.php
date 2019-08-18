<?php
/*
	* Author: Fábio Silveira dos Anjos
    * AuthorEmail: fabio.s.a.proweb@gmail.com
    
    * Data: 17-08-2019
    * 
    * classe controller Login

    * permite autenticar usuarios e sair do sistema
	*/
class Login extends Controller{

    /**
     * Método index: pagina inicial
     */
    public function Index(){
        
        /**
         * Classe App: classes auxiliares localizada em:
         * 
         * ../system/helpers/App.php
         * 
         */
        App::session();

        /**
         * Valida o token requisitado pelo formulário de login
         */

        $_SESSION['token'] = (!isset($_POST['token']) ? App::token() :  $_POST['token']);

        /**
         * Valida se o token é igual ao do formulário
         */
        if(!empty($_POST['token']) && $_POST['token'] == $_SESSION['token']):

            /**
             * Cria uma instância da classe usuário localizado em:
             * 
             * /modules/login/models/usuarioModel.php
             * 
             */
            $autenticacao = $this->model('/login', 'usuario');
            
            /**
             * chama o metodo login da classe usuario
             */
            $usuario = $autenticacao->login($_POST['login']);

            //echo password_hash($_POST['senha'], PASSWORD_DEFAULT);

           // var_dump($usuario);

           /**
            * valida os dados do formulário com a consulta SQL na classe usuario
            * 
            */
            if($usuario):
                
                // Atribui a um array
                $dados_usuario['dados_login'] = $usuario;

                // extrai os dados do objeto
                extract($dados_usuario);

                // Verifica se a senha do formulário é igual ao do banco de dados
                if(password_verify($_POST['senha'], $dados_login[0]->senha_usuario)):
                    
                    /**
                     * Armazenas os dados em um array para possível recuperação posterior
                     */
                    $armazena_dados['nome_do_usuario'] = $dados_login[0]->nome;

                    $armazena_dados['email_do_usuario'] = $dados_login[0]->email_usuario;

                    $_SESSION['logado'] = $armazena_dados;

                    /**
                     * redireciona para o painel Administrativo
                     * 
                     * cpara melhor entendimento das rotas, consular o arquivo responsável pelo controle em:
                     * 
                     * ../system/core/http/Routes.php
                     */
                    header("Location: ?module=login&option=painel-administrativo&view=usuario/autenticado");

               
                endif;


            else:
                 echo "<b>Usuário</b> ou <b>Senha</b> incorreto!";

                 App::session_destroy();

                  header("Refresh: 1;url=?module=login");
            endif;


        else:

            echo "<b>Token</b> não confere com o do <b>formulário de Login</b>!";

        endif;    

       
        
    }

    /**
     * Permite o usuário sair da aplicação
     */
    public function logout(){
        
        App::session();

        // Verifica se o usuário está logado
        if(isset($_SESSION['logado'])):

           // Captura o valor passado na session
           $logout = $_GET['session']; 
           
           /**
            * codifica o id da sessão  em base 64 e criptogragia md5
            */
           if($logout == base64_encode(md5(session_id()))):
 
                session_regenerate_id();

                session_destroy(App::session());

                unset($_SESSION['loggado']);

                header('Location: ?module=index');

           endif;

        else:
            
            App::session_destroy();

        endif;    
    }
}