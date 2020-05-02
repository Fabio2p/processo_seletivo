<?php
/**
 * Author: Fábio Silveira dos Anjos
 * 
 * AuthorEmail: fabio.s.a.proweb@gmail.com
 * 
 * data: 17-08-2019
 * 
 * Classe App: Classe auxiliar
 * 
 */
class App{

    public static function title(){

        return '/index';
    }

    /**
     * Inicia uma sessão
     */
    public static function session(){

        if(session_status() !== PHP_SESSION_ACTIVE):
            
            session_start();

        endif;

    } 

    public static function getId(){

        $id = FILTER_INPUT(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        return $id;
    }

    /**
     * Destroi uma sessão
     */
    public static function session_destroy(){

        session_regenerate_id();

        session_destroy(App::session());

        unset($_SESSION['logado']);
        
        header("Location: ?module=index");

    }

    /**
     * Aumenta a segurança em reuisições de formulários
     * 
     * Ant cross-site request forgery
     * 
     */
    public static function token(){

        if(session_status() !== PHP_SESSION_ACTIVE):

            session_start();

            $_SESSION['token'] =  strtoupper(hash('sha1', uniqid(rand(), true)));

			return $_SESSION['token'];

        endif;    

    }

}
?>