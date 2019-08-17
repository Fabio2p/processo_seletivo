<?php
	/*
	* Author: Fábio Silveira dos Anjos

	* AuthorEmail: fabio.s.a.proweb@gmail.com
	
	* data: 16-09-2019
	* 
	* Arquivo de Auto load.
    * carrega arquivo com a extenssão .php de forma dinâmicas em classe da App
	*/

	define('BASE_SITE',"../public");

	function __autoload($class){

	/*
	* Inclui o endereço dos arquivos a serem carregados de forma dinâmica
	*/
    $path = ["/../system/core/",'/../system/database/','/../system/helpers/'];

	foreach($path as $dir):

		if(file_exists(__DIR__ ."{$dir}/{$class}.php") && !is_dir(__DIR__ ."{$dir}/{$class}.php")):

			include_once(__DIR__ ."{$dir}/{$class}.php");

		endif;

	endforeach;

}
