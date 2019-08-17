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
        
            /**
             * carrega a view login.view.php em:
             * 
             * ../modules/index/views/login.view.php
             */
          $this->view('/index', 'login');
          
          exit;
    }

}