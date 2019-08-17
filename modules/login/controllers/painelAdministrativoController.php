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
            
            // exibe o título da página
            $dados['title'] = 'Dashboard - Painel Administrativo.';

            // exibe o nome do usuário
            $dados['nome_do_usuario'] = $_SESSION['logado']['nome_do_usuario'];

            /**
             *chama a view do modulo em:
             * 
             * ../modules/login/views/painelAdministrativo.view.php
             */ 
            $this->view('/login', 'painelAdministrativo', $dados);

        else:

            App::session_destroy();
            
        endif;
        
    }
}
