<?php

	$retorno = "";

	function curl($dados="",$tipo="",$meta="",$GET=false) {


//		if ($GET) {
//			$curl = curl_init("http://localhost/SYSCoffe/soap_rest_inPhp/REST/rest.php/usuario/" . $dados);
//		} else {
//			$curl = curl_init("http://localhost/SYSCoffe/soap_rest_inPhp/REST/rest.php/usuario");
//		}

        if ($GET) {
            $curl = curl_init("http://ws-aula.syscoffe.com.br/REST/rest.php/usuario/" . $dados);
        } else {
            $curl = curl_init("http://ws-aula.syscoffe.com.br/REST/rest.php/usuario");
        }

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		/* PARA METODOS POST, PUT e DELETE */
		if (!$GET) curl_setopt($curl, $meta, $tipo);
        if (!$GET) curl_setopt($curl, $meta, $tipo);
		if (!$GET) curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);

        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: text/html', 'Content-Type: text/html'));
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8") );

        $curl_response = curl_exec($curl);
		curl_close($curl);

		return $curl_response;
	}

	$dados = "";
	$id = "";
    $nome = "";
    $sobrenome = "";
    $email = "";
    $senha = "";

	if ($_POST) {

		//$dados = $_POST['dados'];
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $array_temp = array(
            'id' => $id,
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'email' => $email,
            'senha' => $senha
        );

        $json_str = json_encode($array_temp);

        echo $json_str."<br>";
        $array = json_decode($json_str);
		switch ($_POST['metodo']) {
			case 'GET':
				$retorno = curl($id,"","",true);
				break;
			case 'POST':
				$retorno = curl($json_str,"POST", CURLOPT_POST);
				break;
			case 'PUT':
				$retorno = curl($json_str,"PUT",CURLOPT_CUSTOMREQUEST);
				break;
			case 'DELETE':
				$retorno = curl($id,"DELETE",CURLOPT_CUSTOMREQUEST);
				break;
		
		}

	}
?>

<!DOCTYPE HTML>
<html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <title>Cliente REST</title>
    </head>
    <body>
        <br>
        <form action="client.php" method="POST">
            <center>
                <table>
                    <tr>
                        <td valign="TOP">
                            <input type="hidden" id='met' name='metodo'>
                            <input onclick="document.getElementById('met').value='GET'" style="width:80px" type="submit" value="GET"><br>
                            <input onclick="document.getElementById('met').value='POST'" style="width:80px" type="submit" value="POST"><br>
                            <input onclick="document.getElementById('met').value='PUT'" style="width:80px" type="submit" value="PUT"><br>
                            <input onclick="document.getElementById('met').value='DELETE'" style="width:80px" type="submit" value='DELETE'>
                        </td>
                        <td valign="TOP">
                            <!--<textarea placeholder="Dados" name="dados" style="width:500px; height:94px;"><?php echo $dados;?></textarea><br>-->
                            <label>
                                <p>Dados de Envio</p>
                                <!--<input type="text" name="id" value="<?php echo $id; ?>" style="width: 490px; height: 30px; padding: 5px;" placeholder="ID"><br>
                                <input type="text" name="nome" value="<?php echo $nome; ?>" style="width: 490px; height: 30px; padding: 5px;" placeholder="Nome"><br>
                                <input type="text" name="sobrenome" value="<?php echo $sobrenome; ?>" style="width: 490px; height: 30px; padding: 5px;" placeholder="Sobrenome"><br>
                                <input type="email" name="email" value="<?php echo $email; ?>" style="width: 490px; height: 30px; padding: 5px;" placeholder="E-mail"><br>
                                <input type="password" name="senha" value="<?php echo $senha; ?>" style="width: 490px; height: 30px; padding: 5px;" placeholder="Senha"><br>-->
                                <textarea placeholder="Dados" name="dados" style="width:500px; height:94px;"><?php echo $dados;?></textarea><br>
                            </label>
                            <br><br>
                            <p>Dados de RETORNO</p>
                            <textarea placeholder="Retorno" style="width:500px; height:200px;"><?php echo $retorno; ?></textarea>
                        </td>
                    </tr>
                </table>
            </center>
        </form>
    </body>
</html>