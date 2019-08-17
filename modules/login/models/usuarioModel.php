<?php
/*
	* Author: Fábio Silveira dos Anjos

  * AuthorEmail: fabio.s.a.proweb@gmail.com
    
    * Data: 17-08-2019
    * 
    * classe controller Usuario

    * permite Consultar usuarios
	*/
class Usuario extends Dbo{

  /**
   * Método login()
   */
  public function login($login){ 
      /**
       * Cria condição WHERE
       * 
       * para melhor endendimento consultar o arquivo em:
       * 
       * ../system/database/Dbo.php método select();
       */
      $dados = array(

        'nome_usuario'  => $login
      );

      return $this->select('nome_usuario,senha_usuario, nome, email_usuario', 'usuarios', $dados);

      $this->close();
    }
 
}
