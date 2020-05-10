<?php
    /*Ambiente de Desenvolvimento
    */

    $DESENVOLVIMENTO = [

       'HOST' => "172.17.0.3", //HOST: VM SDREDES - 10.73.1.59
       'BASE' => 'zabbix',
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
