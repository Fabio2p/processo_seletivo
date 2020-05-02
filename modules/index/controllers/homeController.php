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

        //@method override: chama o método view 
        $this->view("/index",'teste-alerts');

    }

    public function swheetAlert(){


        echo "<pre>";
            print_r($_POST);
        echo "</pre>";

    	/*$data = true;

    	if($data == true):

    		echo "Cadastro realizdo com sucesso";

    	else:
    	
    		echo "Falha ao cadastrar os dados";	

    	endif;	*/
    }
}