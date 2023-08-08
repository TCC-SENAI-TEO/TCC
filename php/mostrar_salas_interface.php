<?php
    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    echo 
    "<table>
    <tr>
        <th colspan='8'>Meus agendamentos</th>
    </tr>
    <tr>
        <th>Salas</th>
        <th>Dia</th>
        <th>7:00</th>
        <th>7:50</th>
        <th>8:40</thd>
        <th>9:50</th>
        <th>10:40</th>
        <th>11:30</th>
    </tr>";
    
    include "../php/conectar_banco_de_dados.php";
    


    $email = $_SESSION['email_funcionario'];

    if(isset($_POST['nome_usuario'])) {
        $nome_usuario_ajax = $_POST['nome_usuario'];
        $email = mysqli_query($ConexaoSQL, "SELECT email FROM funcionarios WHERE nome = '$nome_usuario_ajax'");
        $email = mysqli_fetch_assoc($email);
        $email = $email['email'];   
    } 
    

    $data_atual = date("Y-m-d");
    if(isset($_POST['data'])) {
        $data_atual = $_POST['data'];
        echo $data_atual;
    } else {
        $data_atual = date("Y-m-d"); 
    }

    if(isset($_POST['checkbox'])) {
        $checar_data = $_POST['checkbox'];
        if($checar_data == "checado") {
            $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email'"); //total de X do usuário
        } else {
            $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email' and DATE(agendamentos.inicio) >= '$data_atual'"); //total de X do usuário
        }
        
    } else {
        $quantidade_salas_agendadas = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id WHERE email = '$email' and DATE(agendamentos.inicio) >= '$data_atual'"); //total de X do usuário
    }

    

    $quantidade_salas_agendadas = mysqli_num_rows($quantidade_salas_agendadas);

    $codigo_sala = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' ORDER BY inicio asc"); 

    $horarios_armazenados = [];
    $codigo2 = '';
    $inicio2 = '';

    for($i = 1; $i <= $quantidade_salas_agendadas; $i++) {  
        
        $codigo_sala_assoc = mysqli_fetch_assoc($codigo_sala);
        $codigo1 = $codigo_sala_assoc['codigo'];
        $inicio1 = $codigo_sala_assoc['inicio'];
        
        $horario = mysqli_query($ConexaoSQL, "SELECT codigo, id_sala, inicio, id_horario FROM agendamentos INNER JOIN funcionarios on agendamentos.id_funcionarios = funcionarios.id INNER JOIN salas on agendamentos.id_sala = salas.id WHERE email = '$email' AND inicio = '$inicio1' ORDER BY inicio");
        $num = mysqli_num_rows($horario);

        $date = $inicio1;
        $dateObj = date_create_from_format('Y-m-d', $date);
        $formattedDate = $dateObj->format('d-m-Y');

        if($codigo1 != $codigo2 || $inicio1 != $inicio2) {

            for($l = 0; $l < $num ; $l++) {     
                $horario_assoc = mysqli_fetch_assoc($horario);
                $horarios_armazenados[] = $horario_assoc['id_horario']; //armazena o horario presente nas salas
            }
            echo 
            "<tr>
            <td>".$codigo1."</td>
            <td>".$formattedDate."</td>".
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
    echo "<table>"
    ?>