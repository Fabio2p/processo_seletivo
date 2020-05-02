<?php
/*
*Class Model: Cria uma instância da classe Database.php

*/
require(realpath('../system/database/Database.php'));
class Model {
	//@var banco: Acessivel aos controllers
	public $banco;
	
	//@var __construct: inicializa a classe Database
	public function __construct() {
		
		$this->banco = new Database();

	}
}