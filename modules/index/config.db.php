<?php
    /*Ambiente de Desenvolvimento
    */

    $DESENVOLVIMENTO = [

       'HOST' => "172.18.0.2", //HOST: VM SDREDES - 10.73.1.59
       'BASE' => 'banco',
       'USER' => 'administrador',
       'PASS' => 'F@bio5505',

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
