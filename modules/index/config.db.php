<?php
    /*Ambiente de Desenvolvimento
    */

    $DESENVOLVIMENTO = [

       'HOST' => "192.168.0.111",
       'BASE' => 'projetos_dev',
       'USER' => 'fabio',
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


    $AMBIENTE = TRUE;

    $seta = $AMBIENTE ? $DESENVOLVIMENTO : $PRODUCAO;


?>
