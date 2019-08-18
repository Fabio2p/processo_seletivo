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

    /*
    *Método importa_xml_banco:
    *
    *Faz a inclusão dos dados
    *
    */
    public function importa_xml_banco($nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo){

      $dados_importa = [

          'nome' => $nome,
          
          'documento' => $documento,

          'cep' => $cep,

          'endereco' => $endereco,

          'bairro' => $bairro,

          'cidade' => $cidade,

          'uf' => $uf,

          'telefone' => $telefone,

          'email' => $email,

          'ativo' => $ativo
      ];

      /*
      * Chama o método insert() localizado em:
      *
      * ../system/database/Dbo.php
      */
      $this->insert('torcedores', $dados_importa);

    }

    public function lista_dados(){

      return $this->select('*', 'torcedores');

    }

    public function lista_dados_unico($params){

      $dados = [

          'id' => $params
      ];

      return $this->select('nome,documento,cep,endereco,bairro,cidade,uf,telefone,email,ativo, id', 'torcedores', $dados);

    }

  /*
    *Método edita_dados_usuario:
    *
    *Faz a alteração dos dados
    *
    */
  public function edita_dados_usuario($nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo, $params){

      $edita_usuario = [

          'nome' => $nome,
          
          'documento' => $documento,

          'cep' => $cep,

          'endereco' => $endereco,

          'bairro' => $bairro,

          'cidade' => $cidade,

          'uf' => $uf,

          'telefone' => $telefone,

          'email' => $email,

          'ativo' => $ativo
      ];

      $this->update('torcedores',$edita_usuario, 'id', $params);

    }

     /*
    *Método salva_dados_usuario:
    *
    *Salva os dados em banco
    *
    */
    public function salva_dados_usuario($nome,$documento,$cep,$endereco,$bairro,$cidade,$uf,$telefone,$email,$ativo){

      $salva_usuario = [

          'nome' => $nome,
          
          'documento' => $documento,

          'cep' => $cep,

          'endereco' => $endereco,

          'bairro' => $bairro,

          'cidade' => $cidade,

          'uf' => $uf,

          'telefone' => $telefone,

          'email' => $email,

          'ativo' => $ativo
      ];

     return  $this->insert('torcedores',$salva_usuario);

     $this->close();

    }
 
}
