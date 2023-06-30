<?php
    include '../php/conectar_banco_de_dados.php';
    session_start();

    $data = mysqli_real_escape_string($ConexaoSQL, $_POST['data']); // Exibe no formato desejado
    $_SESSION['data'] = $data;

    $horario = mysqli_real_escape_string($ConexaoSQL, $_POST['horario']);


    switch($horario) {
        case '7:00':$_SESSION['horario'] = 1;
        break;
        case '7:50':$_SESSION['horario'] = 2;
        break;
        case '8:40':$_SESSION['horario'] = 3;
        break;
        case '9:50':$_SESSION['horario'] = 4;
        break;
        case '10:40':$_SESSION['horario'] = 5;
        break;
        case '11:30':$_SESSION['horario'] = 6;
        break;
    }

    header("location: ../html/home.php");
?>