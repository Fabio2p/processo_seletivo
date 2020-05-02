<?php
define('_exec', 1);

	/*
	* Author: Fábio Silveira dos Anjos
	* AuthorEmail: fabio.s.a.proweb@gmail.com

	/ Arquivo index.php: ponto de partida da App
	*/
	
	/*
	* Inclui o arquivo Routing.class.php; Os roteamentos.
	*/
    require_once(realpath('../system/core/Routing.class.php'));

    /*
	* Inclui o arquivo config.load.php; Carrega arquivos em toda a aplicação sem a necessidade de includes.
	*/
    require_once(realpath('../config/config.load.php'));

    /*+
    * Cria um objeto da classe Routing;
    */
    $instance = new Routing();

    /*
    * Roda a Aplicação;
    */
    $instance->run();
?>