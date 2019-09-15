<?php
    #
    # obtendo nosso arquivo de configuracões
    require_once 'webservice_init.php';

    # verificando se o método de envio é mesmo  POST.
    if( $_SERVER['REQUEST_METHOD'] !== "POST" )
        __output_header__( false, "Método de requisição não aceito.", null );

    # usando o vita para criar uma instancia da tabela usuarios
    # localizada no banco de dados.
    $vita->usuarios = new Framework\Vita\Core\SYS_Table( 'usuarios' );

    # verificando se o usuario ja esta cadastrado
    $r = $vita->usuarios->select()->where( "email = '".$vita->post->email."'" )->single();
    if( ! ($r === false) )
        __output_header__( false, 'Usuário já cadastrado.', null);

    # Lembre-se que os dados são recebidos via POST
    # o Vita processa e trata esse tipo de requisição além de limpar
    # contra ataques de sql injection.
    # Se você usa uma Framework, ou esta fazendo código Puro,
    # obtenha e processe aqui os dados através do $_POST

    # obtendo os dados $_POST com o vita
    $_dados['nome']  = $vita->post->nome;
    $_dados['sobrenome'] = $vita->post->sobrenome;
    $_dados['email'] = $vita->post->email;
    $_dados['senha'] = md5( $vita->post->senha );

    # fazendo validacoes basicas. No caso apenas o E-mail
    if( ! $vita->validate->email( $_dados['email'] ) )
        __output_header__( false, 'E-mail inválido.', null);

    # se você usa PHP Puro , use aqui um mysql_insert e escreva a consulta.
    # registrando na base de dados
    $r = $vita->usuarios->save( $_dados );

    __output_header__( ($r > 0), "Usuário adicionado com sucesso", $_dados );

    #
?>