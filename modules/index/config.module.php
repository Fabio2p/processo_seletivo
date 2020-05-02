<?php

spl_autoload_register(function ($class) {

    $path = ["/models", "/helpers"];

	foreach($path as $diretorio):

		if(file_exists(__DIR__ ."{$diretorio}/{$class}.php") && !is_dir(__DIR__ ."{$diretorio}/{$class}.php")):

			include_once(__DIR__ ."{$diretorio}/{$class}.php");
			
		endif;

	endforeach;
});

?>