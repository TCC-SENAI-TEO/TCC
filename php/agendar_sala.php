<?php
    include '../php/conectar_banco_de_dados.php';
    /*
    $professor = mysqli_real_escape_string($ConexaoSQL, $_SESSION['email_funcionario']);
    $horarios = mysqli_query($ConexaoSQL, $_POST['horarios']);
    $sala = mysqli_real_escape_string($ConexaoSQL, $_SESSION['codigo_sala']);
    $data_agendamento = mysqli_real_escape_string($ConexaoSQL, $_POST['data_agendamento']);
    $data_inicio = mysqli_real_escape_string($ConexaoSQL, $_POST['data_inicio']);
    $data_fim = mysqli_real_escape_string($ConexaoSQL, $_POST['data_fim']);
    */

    $professor = '1';
    $horarios = '1';
    $sala = '1';
    $data_agendamento = '2023-06-27';
    $data_inicio = '2023-06-27';
    $data_fim = '2023-06-27';

    $Enviando_dados = mysqli_query($ConexaoSQL, "INSERT INTO agendamentos(id_funcionarios, id_horario, id_sala, data_agendamento, inicio, fim) VALUES ('$professor','$horarios','$sala','$data_agendamento', '$data_inicio','$data_fim')");


?>