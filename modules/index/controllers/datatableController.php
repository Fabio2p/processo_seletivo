<?php 
class dataTable extends Controller
{
    
    public function index(){

        $this->view('/index','datatables');
    }

    public function graficos(){

        $this->view("/index",'graficos');

    }

    public function dataTableJson(){
        
        $teste = @$_POST['t'] ? $_POST['t'] : "";

        $teste = $this->model("/index",'Nocs');

        //$json = array("data" => $teste->selecionaNoc_host());

        echo json_encode($teste->selecionaNoc_host(10166), true);

    }

    public function dataTableJsons(){
        
        $testes = $_POST['t'];

        $teste = $this->model("/index",'Nocs');

        //$json = array("data" => $teste->selecionaNoc_host());

        echo json_encode($teste->selecionaNoc_hosts($testes), true);

    }
}

