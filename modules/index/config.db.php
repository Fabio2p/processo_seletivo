<?php
    /*Ambiente de Desenvolvimento
    */

    $DESENVOLVIMENTO = [

       'HOST' => "172.17.0.2",
       'BASE' => 'projetos_dev',
       'USER' => 'fabio',
       'PASS' => '5505',

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
