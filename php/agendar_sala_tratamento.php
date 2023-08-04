<?php
    session_start();
    $codigo_sala = $_POST['codigo_sala'];
    $descricao_sala = $_POST['descricao_sala'];
    $_SESSION['codigo_sala'] = $codigo_sala;
    $_SESSION['descricao_sala'] = $descricao_sala;

    header("location: ../html/agendamento.php");
?>