<?php
    session_start();
    $codigo_sala = $_POST['codigo_sala'];
    $descricao_sala = $_POST['descricao_sala'];
    $_SESSION['codigo_sala'] = $codigo_sala;
    $_SESSION['descricao_sala'] = $descricao_sala;

    if(isset($_POST['identificar_reporte'])) {
        header("location: ../html/reportar_sala.php");
    } else {
        header("location: ../html/agendamento.php");
    }

?>