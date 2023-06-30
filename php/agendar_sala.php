<?php
    include '../php/conectar_banco_de_dados.php';
    
    session_start();
    $data = new DateTime(); // Pega o momento atual
    $data = $data->format('Y-m-d'); // Exibe no formato desejado

        $professor = mysqli_real_escape_string($ConexaoSQL, $_SESSION['email_funcionario']);
        $horarios = $_POST['horarios'];
        $sala = mysqli_real_escape_string($ConexaoSQL, $_SESSION['codigo_sala']);
        $data_agendamento = mysqli_real_escape_string($ConexaoSQL, $data);
        $data_inicio = mysqli_real_escape_string($ConexaoSQL, $_POST['data_inicio']);
        $data_fim = mysqli_real_escape_string($ConexaoSQL, $_POST['data_termino']);

        if($professor == "" || $horarios == "" || $sala == "" || $data_agendamento == "" || $data_inicio == "" || $data_fim == "") {
            $_SESSION['error_agendar_sala'] = 1;
        } else {
            $professor = mysqli_query($ConexaoSQL, "SELECT id FROM funcionarios WHERE email = '$professor'");
            $professor = mysqli_fetch_assoc($professor);
            $professor = $professor['id'];
        
            $horarios = mysqli_query($ConexaoSQL, "SELECT id FROM horario WHERE inicio = '$horarios'");
            $horarios = mysqli_fetch_assoc($horarios);
            $horarios = $horarios['id'];
        
            $sala = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$sala'");
            $sala = mysqli_fetch_assoc($sala);
            $sala = $sala['id'];
            $_SESSION['error_agendar_sala'] = 2;
        
            //$Enviando_dados = mysqli_query($ConexaoSQL, "INSERT INTO agendamentos(id_funcionarios, id_horario, id_sala, data_agendamento, inicio, fim) VALUES ('$professor','$horarios','$sala','$data_agendamento', '$data_inicio','$data_fim')");
        }
        
        


    header(("location: ../html/agendamento.php"));



?>