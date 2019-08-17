<?php
/*
 * Author: Fábio Silveira dos Anjos
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * data: 15-08-2019

 * Classe Routing: Carrega as classes controllers em: ../modules/controllers/+modulo+/+controllers_desejado
 * valida a classe de acordo com a chamada via url;
 * caso exista uma classe semelhante a chamada via url, cria se um objeto dessa classe
 
 */
class Routing{
    /**
     * Atributo  $path_modules;
     */
    private $path_modules = null;

    /**
     * Atributo $route;
     * 
     */
    private $route        = null;

    /**
     * Atributo $view;
     * 
     */
     private $view        = null;

    /**
     * Obtem os dados necessário passado pelo o usuário via url.
     * Filtra os dados
     * Atribui o dado ao atributo  $path_modules;
     *
     */
    private function setModules(){
        
        $this->path_modules = FILTER_INPUT(INPUT_GET, 'module', FILTER_SANITIZE_STRING);

    }

    /**
     * Obtem os dados necessário passado pelo o usuário via url.
     * Filtra os dados
     * Atribui o dado ao atributo  $route;
     *
     */

    private function setRoute(){

        $this->route = FILTER_INPUT(INPUT_GET, 'option', FILTER_SANITIZE_STRING);
    }


    /**
     * Obtem os dados necessário passado pelo o usuário via url.
     * Filtra os dados
     * Atribui o dado ao atributo  $view;
     *
     */
    private function setView(){

        $this->view = FILTER_INPUT(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
    }
    
    /*
    * Metodo: run();
    * responsável pela a inicialização da aplicação
    * 
    * O método run é chamado em: ../public/index.php
    *
    */
    public function run(){
        
        $this->setModules();

        $this->setRoute();

        $this->setView();

        /*
         *Somente se o usuário digitar o módulo e rota 
         * exemplo: 192.168.2.2/meuApp/public/pagina-inicial/meu-primeiro-metodo
         */
        if(!empty($this->path_modules) && !empty($this->route)):

            $path_module = realpath('../modules/'. trim($this->path_modules));
            
            /*
            * Valida se o dado digitado pelo o usuário via url condiz a um diretório;
            */
            if(is_dir($path_module)):

                /* Verifica se o arquivo Routers.php, responsável pela url amigável existe, caso não existe rotas setado no arquivo Routers.php, então deverá ser digitado o nome da classe e o nome do método.
                *
                *exemplo:
                * sem as rotas "alias" ficaria dessa forma: 192.168.2.2/meuApp/public/?module=home&option=index

                * com as rotas ficaria: 192.168.2.2/meuApp/public/pagina-inicial/meu-primeiro-metodo
                */
                
                if(realpath('../system/core/http/Routers.php')):

                    // Inclui o arqui Routers.php
                    require_once(realpath('../system/core/http/Routers.php'));
                    
                    /*
                    * verifica se existe rota setados no arquivo: 
                    *
                    *../system/core/http/Routers.php
                    */    
                    $routes = (isset($Routers['Controllers'][$this->route]) ? $Routers['Controllers'][$this->route] : $this->route);

                    $path_controller = $path_module."/controllers/".trim($routes."Controller.php");
                    
                    if(file_exists($path_controller)):

                        require_once($path_controller);

                        if(class_exists($routes)):

                            /**
                             * Cria o objeto
                             */
                            $obj_controller = new $routes();
                        
                            /**
                            * Verifica se existe url amigavél no arquivo Routers
                            */
                            $method = (isset($Routers['Actions'][$this->view]) ? $Routers['Actions'][$this->view] : $this->view);

                            if(method_exists($obj_controller, $method)):
                                
                                /**
                                 * atribui o metodo a classe
                                 */
                                $obj_controller->$method();

                            else:

                                echo "Metodo não encontrado!";

                            endif; // Verifica se existe um metodo.
                        
                        endif; // Verifica se existe classe;

                    endif; // Verifica se existe o arquivo de rota

                    endif; // verifica se existe arquivo 

            endif; //valida se é um diretório
        

        /*
         * Somente se o usuário digitar o nome do módulo
         *
         * exemplo: 192.168.2.2/meuApp/public/pagina-inicial/
         * */    
        elseif(!empty($this->path_modules)):

            $path_module = realpath('../modules/'. trim($this->path_modules));
            
            /*
            * Valida se o dado digitado pelo o usuário via url condiz a um diretório;
            */
            if(is_dir($path_module)):

                // Verifica se o arquivo Routers.php, responsável pela url amigável existe
                
                if(realpath('../system/core/http/Routers.php')):

                    // Inclui o arqui Routers.php
                    require_once(realpath('../system/core/http/Routers.php'));
                    
                    /*
                    * verifica se existe rota setados no arquivo: ../system/core/http/Routers.php
                    */    
                    $routes = (isset($Routers['Controllers'][$this->route]) ? $Routers['Controllers'][$this->route] : 'home');

                    $path_controller = $path_module."/controllers/".trim($routes."Controller.php");
                    
                    if(file_exists($path_controller)):

                        require_once($path_controller);

                        if(class_exists($routes)):

                            /**
                             * Cria o objeto
                             */
                            $obj_controller = new $routes();
                        
                            /**
                            * Verifica se existe url amigavél no arquivo Routers
                            */
                            $method = (isset($Routers['Actions'][$this->view]) ? $Routers['Actions'][$this->view] : 'index');

                            if(method_exists($obj_controller, $method)):
                                
                                /**
                                 * atribui o metodo a classe
                                 */
                                $obj_controller->$method();

                            else:

                                echo "Metodo não encontrado!";

                            endif; // Verifica se existe um metodo.
                        
                        endif; // Verifica se existe classe;

                    endif; // Verifica se existe o arquivo de rota

                    endif; // verifica se existe arquivo 

                else:

                    echo "Módulo <b>{$this->path_modules}</b> não localizado!";

            endif; //valida se é um diretório
        
        /**
         * Somente se o usuário digitar o endereço da aplicação.
         *
         * ex: 192.169.2.2/php-pdo/public 
         * 
         * ou www.minhaaplicação.com.br
         */
        else:

            $path_module = realpath("../modules/index");
            
            /*
            * Valida se o dado digitado pelo o usuário via url condiz a um diretório;
            */
            if(is_dir($path_module)):

                    $path_controller = $path_module."/controllers/homeController.php";
                    
                    if(file_exists($path_controller)):

                        require_once($path_controller);

                        if(class_exists('home')):

                            /**
                             * Cria o objeto
                             */
                            $obj_controller = new Home();
                        
                            if(method_exists($obj_controller, 'index')):
                                
                                /**
                                 * atribui o metodo a classe
                                 */
                                $obj_controller->Index();

                            else:

                                echo "Metodo não encontrado!";

                            endif; // Verifica se existe um metodo.
                        
                        endif; // Verifica se existe classe;

                    endif;
        
            endif; //valida se é um diretório

        endif; // Verifica se os valores não são vazio
    }

}