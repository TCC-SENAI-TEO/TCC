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

        $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' ORDER BY codigo"); 

        $horarios_armazenados = [];
        $codigo2 = '';
        $inicio2 = '';

        for($i = 1; $i <= $quantidade_salas_agendadas; $i++) {  
            
            $codigo_sala_assoc = mysqli_fetch_assoc($codigo_sala);
            $codigo1 = $codigo_sala_assoc['codigo'];
            $inicio1 = $codigo_sala_assoc['inicio'];
            
            $horario = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND inicio = '$inicio1' ORDER BY codigo");
            $num = mysqli_num_rows($horario);
            
            
            if($codigo1 != $codigo2 || $inicio1 != $inicio2) {

                for($l = 0; $l < $num ; $l++) {     
                    $horario_assoc = mysqli_fetch_assoc($horario);
                    $horarios_armazenados[] = $horario_assoc['id_horario']; //armazena o horario presente nas salas
                }
                echo 
                "<tr>
                <td>".$codigo1."</td>
                <td>".$inicio1."</td>".
                "<td>".marcar_horario(1)."</td>".
                "<td>".marcar_horario(2)."</td>".
                "<td>".marcar_horario(3)."</td>".
                "<td>".marcar_horario(4)."</td>".
                "<td>".marcar_horario(5)."</td>".
                "<td>".marcar_horario(6)."</td>".
                "</tr>";

                
            }
            $horarios_armazenados = array();
            $codigo2 = $codigo1;
            $inicio2 = $inicio1;
            
        }
        function marcar_horario($num_horario) {
            global $horarios_armazenados;
            if(empty($horarios_armazenados)) {
                return "";
            } else {
                foreach($horarios_armazenados as $teste) {
                    if($num_horario == 1 && $teste == 1) {
                        return "X";
                    } else if($num_horario == 2 && $teste == 2) {
                        return "X";
                    } else if($num_horario == 3 && $teste == 3) {
                        return "X";
                    } else if($num_horario == 4 && $teste == 4) {
                        return "X";
                    } else if($num_horario == 5 && $teste == 5) {
                        return "X";
                    } else if($num_horario == 6 && $teste == 6) {
                        return "X";
                    }
                    
                }
            }
        }
            
        ?>
            </table>
        </main>
    </body>
    </html>