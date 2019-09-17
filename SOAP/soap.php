<?php
    //Servidor

    include 'nusoap-master/src/nusoap.php';
    require 'Database.php';
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost'); //local
    define('DB_NAME', 'rest_ws'); //banco
    define('DB_USER', 'root'); //usuario
    define('DB_PASS', ''); //senha
    $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

    $servidor = new nusoap_server();

    //Configurar o WSDL
    $servidor->configureWSDL('urn:WS-SOAP');
    $servidor->wsdl->schemasTagetNamespace = 'urn:WS-SOAP';

    function get($id)
    {
        $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $return = $database->select("SELECT * FROM contatos WHERE id=$id");
        $return = json_encode($return);
        return ($return);
    }

    $servidor->register(
        'get',
        array(
            'id'=>'xsd:int'
        ),
        array(
            'retorno'=>'xsd:string'
        ),
        'urn:WS-SOAP.insert',
        'urn:WS-SOAP.insert',
        'rpc',
        'encoded',
        'Pegando informações na base de dados usando NuSOAP PHP'
    );

    function insert ($nome, $email)
    {
        $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $return = array(
            'nome'=>$nome,
            'email'=>$email
        );
        $temp = $database->insert('contatos', $return);
        $return['id'] = $temp;
        $return = json_encode($return);
        return ($return);
    }

    $servidor->register(
        'insert',
        array(
            'nome'=>'xsd:string',
            'email'=>'xsd:string'
        ),
        array(
            'retorno'=>'xsd:string'
        ),
        'urn:WS-SOAP.insert',
        'urn:WS-SOAP.insert',
        'rpc',
        'encoded',
        'Inserir informações na base de dados usando NuSOAP PHP'
    );

    function update ($id, $nome, $email)
    {
        $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $return = array(
            'nome'=>$nome,
            'email'=>$email
        );
        $database->update('contatos', $return, "id = $id");
        $return['id'] = $id;
        $return = json_encode($return);
        return ($return);
    }

    $servidor->register(
        'update',
        array(
            'id'=>'xsd:int',
            'nome'=>'xsd:string',
            'email'=>'xsd:string'
        ),
        array(
            'retorno'=>'xsd:string'
        ),
        'urn:WS-SOAP.update',
        'urn:WS-SOAP.update',
        'rpc',
        'encoded',
        'Atualizando informações na base de dados usando NuSOAP PHP'
    );

    function delete ($id)
    {
        $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
        $database->delete('contatos', "id=$id");
        $return = array(
            'id' => $id
        );
        $return = json_encode($return);
        return ($return);
    }

    $servidor->register(
        'delete',
        array(
            'id'=>'xsd:int'
        ),
        array(
            'retorno'=>'xsd:string'
        ),
        'urn:WS-SOAP.delete',
        'urn:WS-SOAP.delete',
        'rpc',
        'encoded',
        'Deletando informações na base de dados usando NuSOAP PHP'
    );

    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $servidor->service($HTTP_RAW_POST_DATA);


?>