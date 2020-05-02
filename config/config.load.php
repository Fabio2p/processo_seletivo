<?php
	/*
	* Author: Fábio Silveira dos Anjos

	* AuthorEmail: fabio.s.a.proweb@gmail.com

	* data: 16-09-2019
	*
	* Arquivo de Auto load.
    * carrega arquivo com a extenssão .php de forma dinâmicas em classe da App
	*/
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

	//define('BASE_URL',"https://homologacaosuporte.sdredes.info");

	define('BASE_URL',"http://host.local.dev-sys");

	date_default_timezone_set("America/Sao_Paulo");

	define('BASE_ASSETS',"assets");

	define('BASE_UPLOAD', "/");

	function __autoload($class){

	/*
	* Inclui o endereço dos arquivos a serem carregados de forma dinâmica
	*/
    $path = ["/../system/core/",'/../system/database/','/../system/helpers/'];

	foreach($path as $diretorio):

		if(file_exists(__DIR__ ."{$diretorio}/{$class}.php") && !is_dir(__DIR__ ."{$diretorio}/{$class}.php")):

			include_once(__DIR__ ."{$diretorio}/{$class}.php");

		endif;

	endforeach;

}
