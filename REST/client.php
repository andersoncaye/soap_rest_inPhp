<?php

    $url = 'http://localhost/SYSCoffe/soap_rest_inPhp/REST/rest.php/usuario';
    $parameter =
'{
    "nome":"",
    "sobrenome":"",
    "email":"",
    "senha":""
}';
    $retorno = '';
    $json_array = 'json/array';

	function cul($dados="",$tipo="",$meta="",$GET=false, $url){

        if ($GET) { $curl = curl_init($url."/" . $dados); echo $url."/" . $dados;}
        else { $curl = curl_init($url.''); }
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		/* PARA METODOS POST, PUT e DELETE */
		if (!$GET) curl_setopt($curl, $meta, $tipo);
        if (!$GET) curl_setopt($curl, $meta, $tipo);
		if (!$GET) curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        $curl_response = curl_exec($curl);
		curl_close($curl);
		return $curl_response;
	}

	if ($_POST) {
        $json_array = $_POST['json_array'];
        $json_str = $_POST['parameter'];
        echo $json_str."<br>";
        $array = array();

        if ( $json_array == 'json' ){ $array = $json_str; }
        else { $array = json_decode($json_str); }

        switch ($_POST['metodo']) {
			case 'GET':
			    $id = json_decode($json_str);
				$retorno = cul($id->id,"","",true, $url);
				break;
			case 'POST':
				$retorno = cul($array,"POST", CURLOPT_POST, $url);
				break;
			case 'PUT':
				$retorno = cul($array,"PUT",CURLOPT_CUSTOMREQUEST, $url);
				break;
			case 'DELETE':
				$retorno = cul($array,"DELETE",CURLOPT_CUSTOMREQUEST, $url);
				break;
		}

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
                        <label>URL do WS REST</label><br>
                        <input type="text" placeholder="URL SOAP" style="width: 500px;" name="url" value="<?php echo $url; ?>">
                    </tr>
                    <tr>
                        <br>
                        <label>Parâmetros em JSON</label><br>
                        <textarea placeholder="Retorno" style="width:500px; height:200px;" name="parameter"><?php echo $parameter; ?></textarea>
                    </tr>
                    <tr>
                        <br>
                        <input type="hidden" id='met' name='metodo'>
                        <input onclick="document.getElementById('met').value='GET'" style="width:80px" type="submit" value="GET"><br>
                        <input onclick="document.getElementById('met').value='POST'" style="width:80px" type="submit" value="POST"><br>
                        <input onclick="document.getElementById('met').value='PUT'" style="width:80px" type="submit" value="PUT"><br>
                        <input onclick="document.getElementById('met').value='DELETE'" style="width:80px" type="submit" value='DELETE'>
                        <br>
                        <input type="text" name="json_array" value="<?php echo $json_array; ?>">
                    </tr>
                    <br><br>
                    <tr>
                        <!--<input type="submit" value="ENVIAR AO WS SOAP" name="get">
                        <input type="submit" value="GET" name="get">
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
                            <textarea placeholder="Retorno" style="width:500px; height:150px; align: center;"><?php echo $retorno; ?></textarea>
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

<!--
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
                            <br>
                            <p>Dados de ENVIO</p>
                            <textarea placeholder="Retorno" style="width:500px; height:200px;"><?php echo $dados; ?></textarea>
                            <br>
                            <p>Dados de RETORNO</p>
                            <textarea placeholder="Retorno" style="width:500px; height:200px;"><?php echo $retorno; ?></textarea>
                        </td>
                    </tr>
                </table>
            </center>
        </form>
    </body>
</html>
-->