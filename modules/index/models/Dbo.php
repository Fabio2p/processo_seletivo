<?php
require_once(realpath('../system/database/Model.php'));

class Dbo extends Model{

	//@Var: acessivel para as controllers e models
    public $db;

    private $host;

    private $base;

    private $user;

    private $pass;

    private $setup;

    //@method: inicializa a variável db da classe Model.php
    public function __construct(){

      require_once __DIR__."../../config.db.php";

      $this->setup = @$seta;

      $this->host = @$this->setup['HOST'];

      $this->base = @$this->setup['BASE'];

      $this->user = @$this->setup['USER'];

      $this->pass = @$this->setup['PASS'];

      parent::__construct();

      //@var seta as configurações do SGBD de desenvolvimento
      $this->db = $this->banco->setConn("{$this->host}", "{$this->base}", "{$this->user}", "{$this->pass}");

    }

}
