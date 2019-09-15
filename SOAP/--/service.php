<?php
    @require 'lib/nusoap.php';

    $server =  new nusoap_server();
    $server->configureWSDL("soap", "urn:soap");
    
    $server->register
    (
        "price", //name of function
        array(
            'name' => 'xsd:string'
        ), //input
        array(
            'return' => 'xsd:inter'
        ) //output
    );

    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);

    //echo 'Tamo aqui';
?>