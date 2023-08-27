<?php
    /*Ambiente de Desenvolvimento
    */

    $DESENVOLVIMENTO = [

       'HOST' => "10.5.0.2",
       'BASE' => 'projetos_dev',
       'USER' => 'root',
       'PASS' => 'F@bio3306',

    ];

    $HOMOLOGACAO = [

           'HOST' => '',
           'BASE' => '',
           'USER' => '',
           'PASS' => ''
    ];

    $PRODUCAO = [

        'HOST' => '',
        'BASE' => '',
        'USER' => '',
        'PASS' => ''
        
    ];


    $AMBIENTE = true;

    $seta = $AMBIENTE ? $DESENVOLVIMENTO : $PRODUCAO;


?>
