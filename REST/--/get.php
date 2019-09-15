<?php
    require_once 'webservice_init.php';

    # verificando se estamos recebendo um POST. Não aceitamos GET
    if( $_SERVER['REQUEST_METHOD'] !== "POST" )
        __output_header__( false, "Método de requisição não aceito.", null );

    # criando uma instancia da nossa tabela usuarios
    $vita->usuarios = new Framework\Vita\Core\SYS_Table( 'usuarios' );

    # setando o que sera pesquisado no banco de dados
    $_where = array(
        'email' => $vita->post->email,
        'senha' => md5($vita->post->senha)
    );

    # realizando consulta SQL
    $r = $vita->usuarios->select()->where( $_where )->single();

    # se erro
    if( $r === false )
        __output_header__( false, 'Usuário não encontrado.', null);

    # se sucesso
    __output_header__( true, null, $r );

    #
?>