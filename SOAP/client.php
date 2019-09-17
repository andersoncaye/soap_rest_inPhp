<?php
    include 'nusoap-master/src/nusoap.php';
    $url = 'http://ws-aula.syscoffe.com.br/SOAP/soap.php?wsdl';
    $parameter = '{"":"","":""}';
    $funcao = '';
    $resultado = '';
    if( $_POST ){

        $url = $_POST['url'];
        $parameter = $_POST['parameter'];
        $funcao = $_POST['funcao'];

        //Cliente
//        $cliente = new nusoap_client('http://localhost/SYSCoffe/soap_rest_inPhp/SOAP/soap.php?wsdl');
        $cliente = new nusoap_client($url);
//        $parametros = array(
//            'nome'=>'tetas',
//            'email'=>'tetas@t.com'
//        );
        $parametros = json_decode($parameter);
        if($funcao == 'get'){
            $array = array(
                'id'=> $parametros->id
            );
            $resultado = $cliente->call($funcao, $array);
        } else if($funcao == 'insert'){
            $array = array(
                'nome'  =>  $parametros->nome,
                'email' =>  $parametros->email
            );
            $resultado = $cliente->call('insert', $array);
        } else if($funcao == 'update'){
            $array = array(
                'id'    =>  $parametros->id,
                'nome'  =>  $parametros->nome,
                'email' =>  $parametros->email
        );
            $resultado = $cliente->call('update', $array);
        } else if($funcao == 'delete'){
            $array = array(
                'id'=> $parametros->id
            );
            $resultado = $cliente->call('delete', $array);
        }

        $resultado = utf8_encode($resultado);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>CLIENTE SOAP</title>
    </head>
    <body>
        <!--<h1>CLIENTE SOAP</h1>-->
        <form action="client.php" method="POST">
            <center>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <label>URL do WS SOAP</label><br>
                           <input type="text" placeholder="URL SOAP" style="width: 500px;" name="url" value="<?php echo $url; ?>">
                        </tr>
                        <tr>
                            <br>
                            <label>Parâmetros em JSON</label><br>
                            <textarea placeholder="Retorno" style="width:500px; height:200px;" name="parameter"><?php echo $parameter; ?></textarea>
                        </tr>
                        <tr>
                            <br>
                            <label>Nome da função</label><br>
                            <input type="text" placeholder="Nome da função" style="width: 500px;" name="funcao" value="<?php echo $funcao; ?>" required>
                        </tr>
                        <br><br>
                        <tr>
                            <input type="submit" value="ENVIAR AO WS SOAP" name="get">
                            <!--<input type="submit" value="GET" name="get">
                            <input type="submit" value="INSERT" name="insert">
                            <input type="submit" value="UPDATE" name="update">
                            <input type="submit" value="DELETE" name="delete">-->

                        </tr>
                    </thead>
                    <tbody>
                        <td>
                            <tr>
                                <br>
                                <label>Resultado</label><br>
                                <textarea placeholder="Retorno" style="width:500px; height:150px; align: center;"><?php echo $resultado; ?></textarea>
                            </tr>
                        </td>
                    </tbody>
                </table>
            </center>
        </form>
        <!-- JavaScript (Opcional) -->
        <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>

