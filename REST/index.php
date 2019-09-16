<?php
require 'Database.php';
    define('DB_TYPE', 'mysql');
    define('DB_HOST', 'localhost'); //local
    define('DB_NAME', 'rest_ws'); //banco
    define('DB_USER', 'root'); //usuario
    define('DB_PASS', ''); //senha
    $database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    $return = $database->select("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Meta tags Obrigatórias -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <title>TABELA USUARIOS</title>
    </head>
    <body>
        <h1>USUARIOS</h1>

        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">nome</th>
                    <th scope="col">sobrenome</th>
                    <th scope="col">email</th>
                    <th scope="col">senha</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($return as $row){?>
                <tr>
                    <th scope="row"><?php echo $row->id ?></th>
                    <td><?php echo $row->nome ?></td>
                    <td><?php echo $row->sobrenome ?></td>
                    <td><?php echo $row->email ?></td>
                    <td><?php echo $row->senha ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <!-- JavaScript (Opcional) -->
        <!-- jQuery primeiro, depois Popper.js, depois Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>
