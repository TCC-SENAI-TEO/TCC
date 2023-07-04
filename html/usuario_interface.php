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
        $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email'");
        $quantidade_salas_agendadas = mysqli_num_rows($quantidade_salas_agendadas);
        
        $a = 0;

        for ($i = 1; $i <= $quantidade_salas_agendadas; $i++) {  
            $a++;
            $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND agendamentos.id = '$a'");
            
            while(mysqli_num_rows($codigo_sala) == 0) {
                    $a++;
                    $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND agendamentos.id = '$a'");
                }
                
                $codigo_sala_assoc = mysqli_fetch_assoc($codigo_sala);
                $codigo_sala_result = $codigo_sala_assoc['codigo'];
                
                $data = mysqli_query($ConexaoSQL, "SELECT agendamentos.inicio FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email' and agendamentos.id = '$a'");
                $data_assoc = mysqli_fetch_assoc($data);
                $data_result = $data_assoc['inicio'];
                
                $horarios = mysqli_query($ConexaoSQL, "SELECT horario.inicio FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN horario on agendamentos.id_horario = horario.id WHERE email = '$email' and agendamentos.id = '$a'");
                $horarios_assoc = mysqli_fetch_assoc($horarios);
                $horarios_result = $horarios_assoc['inicio'];

                $verificar_data = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN salas on agendamentos.id_sala = salas.id INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE agendamentos.inicio = '$data_result' AND email = '$email' AND salas.codigo = '$codigo_sala_result'"); //VERIFICA QUANTAS VEZES REPETIU AS LINHAS

                echo mysqli_num_rows($verificar_data);
                
                echo "<tr>
                <td>".$codigo_sala_result."</td>
                <td>".$data_result."</td>".
                "<td>".verificar_horario(1)."</td>".
                "<td>".verificar_horario(2)."</td>".
                "<td>".verificar_horario(3)."</td>".
                "<td>".verificar_horario(4)."</td>".
                "<td>".verificar_horario(5)."</td>".
                "<td>".verificar_horario(6)."</td>".
                "</tr>";
                        

            }
                    
            function verificar_horario($teste) {
                global $horarios_result;
                if($teste == 1 && $horarios_result == "7:00") {
                    return "X";
                }
                else if($teste == 2 && $horarios_result == "7:50") {
                    return "X";
                }
                else if($teste == 3 && $horarios_result == "8:40") {
                    return "X";
                }
                else if($teste == 4 && $horarios_result == "9:50") {
                    return "X";
                }
                else if($teste == 5 && $horarios_result == "10:40") {
                    return "X";
                }
                else if($teste == 6 && $horarios_result == "11:30") {
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