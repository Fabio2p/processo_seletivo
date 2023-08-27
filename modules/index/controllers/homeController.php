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
    
      try{
        $this->view('/index','datatables');
        
      }catch(Exception $error){ }

    }

    public function data(){

      $users = $this->model('/index','Usuarios');

      $page = !empty($_POST['draw']) ? $draw =$_REQUEST['draw'] : 1;

      $start = !empty($_POST['start']) ? $_POST['start'] : 0;

      $length = !empty($_POST['length']) ? $_POST['length'] : 5;
      
      $lista_usuarios = $users->listUsuarios($length,$start);

      $rows = [];

      $data['draw'] = intval($page);
      $data['recordsTotal']  = 50;
      $data['recordsFiltered'] = 50;
      
      foreach($lista_usuarios as $user){
        $rows[] = array($user['id'], $user['nome'],$user['sobrenome']);
      }

      $data['data'] = $rows;

      header("Content-type: application/json");
      echo json_encode($data, true);
    }
}