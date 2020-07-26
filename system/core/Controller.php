<?php
/*
 * /*DATA: 15-11-2019
 *
* Classe Controller: A classe controller é responsável pelo carregamento das views, models e bibliotecas.
*
* deve ser estendida para ser utilizada
*/
abstract class Controller{

	/*
	* Método view: carrega as view localizadas em: 
    *
	* ../modules/+o-módulos-chamado+/views/+a view propriamente.
	*/
    protected function view($module, $view, $dados = null){

        if(is_array($dados) && $dados > 0):
            
            extract($dados);

        endif;

        if(file_exists(realpath("../modules{$module}/views/{$view}.php"))):

                return require_once(realpath("../modules{$module}/views/{$view}.php"));
            
            exit;

        endif;

    }

    /*
	* Método model: carrega as modelos localizadas em: 
    *
	* ../modules/+o-módulos-chamado+/models/+a model propriamente.
    *
	* Retorna um objeto a classe que a herada.
	*/
    protected function model($module, $model){

        if(file_exists(realpath("../modules{$module}/models/{$model}.php"))):

            require_once(realpath("../modules{$module}/models/{$model}.php"));
            
            if(class_exists($model)):

                return new $model();

            else:

            	echo "Classe <b>{$model}</b> não encontrada!";
            
            endif;
            
        else:

            echo "Arquivo <b>$model</b> não encontrado!";   

        endif;

    }

    /*DATA: 11-12-2019
    *
    *MÏtodo modelCustom: Responsável pelo carregamento de um arquivo Model; podendo
     * este ser instanciado nas controllers.
    */
    protected function modelCustom($module, $model){

        if(file_exists(realpath("../modules{$module}/models/{$model}.php"))):

            require_once(realpath("../modules{$module}/models/{$model}.php"));
            
            if(class_exists($model)):

                return realpath("../modules{$module}/models/{$model}.php");

            else:

                echo "Classe <b>{$model}</b> não encontrada!";
            
            endif;
            
        else:

            echo "Arquivo <b>$model</b> não encontrado!";   

        endif;

    }

    
    /*
     * Método headerloadTemplate: carrega o cabeçalho do template localizadas em views
     *
     */
    public function headerloadTemplate($module, $view, $dados = array()) {

       if(is_array($dados) && $dados > 0):
            
            extract($dados);

        endif;

        if(file_exists(realpath("../modules{$module}/views/{$view}.php"))):

                return require_once(realpath("../modules{$module}/views/{$view}.php"));
            
            exit;

        endif;

    }

    /*Método footerloadTemplate: carrega o Rodapé do template localizadas em views
    *
    */
    public function footerloadTemplate($module, $view, $dados = null) {

       if(is_array($dados) && $dados > 0):
            
            extract($dados);

        endif;

        if(file_exists(realpath("../modules{$module}/views/{$view}.php"))):

                return require_once(realpath("../modules{$module}/views/{$view}.php"));
            
            exit;

        endif;

    }

    /*
	* Método view: carrega as bibliotecas localizadas em: 
    *
	* ../system/helpers/+a biblioteca propriamente.
    *
	*/
    protected function library($library){

    	if(file_exists(realpath("../system/libraries/{$library}.php"))):

    		return require_once(realpath("../system/libraries/{$library}.php"));

    		exit;

    	else:

    		echo "Biblioteca <b>{$library}</b> não encontrada!";

    	endif;
    }

     /*
    * @
    * @METHOD: Converte mensagens para JSON */
    public function getJSON($field, $mensagem){

        header('Content-Type: application/json');

        $json = array();

        $json['body'] = array();

        $response = array("{$field}" => "{$mensagem}");

        array_push($json['body'], $response);

        echo json_encode($json);
    }


    /*
    * @
    * @METHOD: Converte mensagens para JSON */
    public function convertJSON($json = array()){

       header('Content-type: application/json');
        
       echo json_encode($json);
    }
    
}
