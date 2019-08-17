<?php
/*
* Author: Fábio Silveira dos Anjos
* AuthorEmail: fabio.s.a.proweb@gmail.com
* data: 16-08-2019

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
            
            extract($dados, EXTR_PREFIX_ALL, 'view');

        endif;

        if(file_exists(realpath("../modules{$module}/views/{$view}.view.php"))):

            return require_once(realpath("../modules{$module}/views/{$view}.view.php"));
            
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

        if(file_exists(realpath("../modules{$module}/models/{$model}Model.php"))):

            require_once(realpath("../modules{$module}/models/{$model}Model.php"));
            
            if(class_exists($model)):

                return new $model();

            else:

            	echo "Classe {$model} não encontrada!";
            
            endif;
        else:
            echo "Arquivo <b>$model</b> não encontrado!";    
        endif;

    }
    /*
	* Método view: carrega as bibliotecas localizadas em: 
    *
	* ../system/helpers/+a biblioteca propriamente.
    *
	*/
    protected function library($library){

    	if(file_exists(realpath("../system/helpers/{$library}.php"))):

    		return require_once(realpath("../system/helpers/{$library}.php"));

    		exit;

    	else:

    		echo "Biblioteca {$library} não encontrada!";

    	endif;
    }
    
}
