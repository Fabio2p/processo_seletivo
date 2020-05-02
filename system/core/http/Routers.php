<?php
/*
* Author: Fábio Silveira dos Anjos
* AuthorEmail: fabio.s.a.proweb@gmail.com

* data: 16-08-2019

* Arquivo Routes: Responsável pelo o controle de urls amigáveis
* dando mais segurança a aplicação
* 
*/
$Routers = [
    /**
     * Controla de forma amigável as controllers
     */
    'Controllers' => [

        /**
         * Controller: login
         * 
         *  * ../modules/login/controllers/loginController.php
         */
        'pagina-de-login' => 'login',

        /**
         * Controller: painelAdministrativo localizado no modulo 'login' em:
         * 
         * ../modules/login/controllers/painelAdministrativoController.php
         * 
         * Autentica o usuário na administração do site
         */
        'authenticate' => 'painelAdministrativo',
    ],
    
    /**
     *  Controla de forma amigável os método
     */
    'Actions' => [

        /**
         * Método logout da classe loginController localizado em:
         * 
         * ../modules/login/controllers/loginController.php
         */
        'sair-do-sistema' => 'logout',
    	/**
         * Método logout da classe painelAdministrativoController localizado em:
         * 
         * ../modules/login/controllers/painelAdministrativoController.php
         * 
         * Redireciona o usuário para a área administrativa do site
         */
        'user/checked' => 'index',

        /**
         * Método importação de xml da classe painelAdministrativoController localizado em:
         * 
         * ../modules/login/controllers/painelAdministrativoController.php
         */
        'importacao-xml'      => 'importa_xml',

    ],
];
