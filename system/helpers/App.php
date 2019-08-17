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

    /**
     * Inicia uma sessão
     */
    public static function session(){

        if(session_status() !== PHP_SESSION_ACTIVE):
            
            session_start();

        endif;

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