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
        $users = $this->model('/index','Usuarios');
        $data['lista_usuarios'] = $users->listUsuariosStatic();

        $this->view('/index','datatables', $data);
        
      }catch(Exception $error){ json_encode(array('message' => $error, 'status' => 500)); }

    }

    public function data(){
      
      try{
        
        $users = $this->model('/index','Usuarios');

        $page = !empty($_POST['draw']) ? $draw =$_REQUEST['draw'] : 1;

        $start = !empty($_POST['start']) ? $_POST['start'] : 0;

        $length = !empty($_POST['length']) ? $_POST['length'] : 5;
        
        $order = $_POST['order'][0];
        $ordenamento = $order['dir'];
        $posicao = $order['column'];

        $coluna = array(
          0 => 'id',
          1 => 'nome',
          2 => 'sobrenome'
        );

        $campos = $coluna[$posicao];

        $lista_usuarios = $users->listUsuarios($length,$start,$campos,$ordenamento);

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

      }catch(Exception $e){ json_encode(array('message' => $e, 'status' => 500));}
    }
}