<?php
    include '../php/conectar_banco_de_dados.php';
    
    session_start();

    $data = new DateTime(); // Pega o momento atual
    $data = $data->format('Y-m-d'); // Exibe no formato desejado

    $horarios = $_POST['horarios'];
    $professor = mysqli_real_escape_string($ConexaoSQL, $_SESSION['email_funcionario']);
    $sala = mysqli_real_escape_string($ConexaoSQL, $_SESSION['codigo_sala']);
    $data_agendamento = mysqli_real_escape_string($ConexaoSQL, $data);
    $data_inicio = mysqli_real_escape_string($ConexaoSQL, $_POST['data_inicio']);
    $data_fim = mysqli_real_escape_string($ConexaoSQL, $_POST['data_termino']);

    if($professor == "" || $horarios == "" || $sala == "" || $data_agendamento == "" || $data_inicio == "" || $data_fim == "") {
        $_SESSION['error_agendar_sala'] = 1;
    } else {

        foreach($horarios as $teste) {
            
            $horarios = mysqli_query($ConexaoSQL, "SELECT id FROM horario WHERE inicio = '$teste'");
            $horarios_assoc = mysqli_fetch_assoc($horarios);      
            $horarios_result = $horarios_assoc['id'];
            
            $professor_sql = mysqli_query($ConexaoSQL, "SELECT id FROM funcionarios WHERE email = '$professor'");
            $professor_assoc = mysqli_fetch_assoc($professor_sql);
            $professor_result = $professor_assoc['id'];
            
            $sala_sql = mysqli_query($ConexaoSQL, "SELECT id FROM salas WHERE codigo = '$sala'");
            $sala_assoc = mysqli_fetch_assoc($sala_sql);
            $sala_result = $sala_assoc['id'];
            
            $Enviando_dados = mysqli_query($ConexaoSQL, "INSERT INTO agendamentos(id_funcionarios, id_horario, id_sala, data_agendamento, inicio, fim) VALUES ('$professor_result','$horarios_result','$sala_result','$data_agendamento', '$data_inicio','$data_fim')");
        }
        $_SESSION['error_agendar_sala'] = 2;
    }

    header(("location: ../html/agendamento.php"));
    
?>