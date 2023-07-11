<?php 
session_start(); //inicia a sessão do usuario para que se possa pegar as informações contidas nela posteriormente
if($_SESSION['login'] != true) { //verifica se o usuario fez login anteriormente
    header("Location: ../html/login.php");
}
include "../php/conectar_banco_de_dados.php"
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/usuario.css">
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <title>Meus Agendamentos</title>
</head>
<body>
    <header>
        <a class="voltar" href="home.php">Voltar</a>
        <h1 class='titulo'>Usuário</h1>
    </header>
    <main>
        <table>
            <tr>
                <th colspan='8'>Meus agendamentos</th>
            </tr>
            <tr>
                <th>Salas</th>
                <th>Dia</th>
                <th>7:00</th>
                <th>7:50</th>
                <th>8:40</th>
                <th>9:50</th>
                <th>10:40</th>
                <th>11:30</th>
            </tr>
        
        <?php

        include "../php/conectar_banco_de_dados.php";
        $email = $_SESSION['email_funcionario'];
        $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email'"); //total de X do usuário
        $quantidade_salas_agendadas = mysqli_num_rows($quantidade_salas_agendadas);

        //$data = mysqli_query($ConexaoSQL, "SELECT agendamentos.inicio FROM agendamentos inner join funcionarios WHERE email = '$email'");

        $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' ORDER BY inicio asc");            
        
        for ($i = 1; $i <= $quantidade_salas_agendadas; $i++) {  

            print_r($quantidade_salas_agendadas);
            echo "<br>";

            $codigo_sala_assoc = mysqli_fetch_assoc($codigo_sala);
            $ultima_data = $codigo_sala_assoc['inicio'];

            //$data_assoc = mysqli_fetch_assoc($data);
            //$data_result = $data_assoc['inicio'];

            //$data_linha = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, id_horario FROM agendamentos INNER JOIN funcionarios INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' and agendamentos.inicio = '$data_result' AND agendamentos.id_sala = '$codigo_sala_result'");

            //print_r($codigo_sala_assoc['codigo']);
            //echo '<br>';

            //for ($t=0; $t < 2; $t++) { 
            //do {
                echo
                "<tr>
                    <td>".$codigo_sala_assoc['codigo']."</td>
                    <td>".$codigo_sala_assoc['inicio']."</td>";
    
                //for($l = 1; $l <= 6; $l++) {
                    echo
                    "<td>".verificar_horario(1,$codigo_sala_assoc['id_horario'])."</td>".
                    "<td>".verificar_horario(2,$codigo_sala_assoc['id_horario'])."</td>".
                    "<td>".verificar_horario(3,$codigo_sala_assoc['id_horario'])."</td>".
                    "<td>".verificar_horario(4,$codigo_sala_assoc['id_horario'])."</td>".
                    "<td>".verificar_horario(5,$codigo_sala_assoc['id_horario'])."</td>".
                    "<td>".verificar_horario(6,$codigo_sala_assoc['id_horario'])."</td>";
               // }
                echo
                "</tr>";
                if($ultima_data == null) {
                    $ultima_data = $codigo_sala_assoc['inicio'];
                }
                            
            //}
                //} while ($ultima_data = $codigo_sala_assoc['inicio']);
            
                    
                
            }
            function verificar_horario($teste, $horarios_result) {
                if($teste == 1 && $horarios_result == "1") {
                    return "X";
                }
                else if($teste == 2 && $horarios_result == "2") {
                    return "X";
                }
                else if($teste == 3 && $horarios_result == "3") {
                    return "X";
                }
                else if($teste == 4 && $horarios_result == "4") {
                    return "X";
                }
                else if($teste == 5 && $horarios_result == "5") {
                    return "X";
                }
                else if($teste == 6 && $horarios_result == "6") {
                    return "X";
                } else {
                    return "";
                }
        }
            ?>
            </table>
    </main>
</body>
</html>