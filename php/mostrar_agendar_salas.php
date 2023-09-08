<?php

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include "../php/conectar_banco_de_dados.php";

    if(isset($_POST['data_escolhida'])) {
        $data_escolhida = $_POST['data_escolhida'];

    } else {
        $data_escolhida = date("Y-m-d");
    }

    $codigo_sala = $_POST['codigo_sala'];
    

    $verificar_horario_disponivel = mysqli_query($ConexaoSQL, "SELECT * FROM agendamentos inner join salas on agendamentos.id_sala = salas.id WHERE inicio = '$data_escolhida' AND codigo = '$codigo_sala'");
    $lista_horarios_fechados = [];
    
    
    for ($i = 0; $i < mysqli_num_rows($verificar_horario_disponivel); $i++) { 
        $verificar_horario_disponivel_assoc = mysqli_fetch_assoc($verificar_horario_disponivel);
        $horario_fechado = $verificar_horario_disponivel_assoc['id_horario'];
        
        $lista_horarios_fechados[] = $horario_fechado;
    }

    echo 
    "<section>".
            "<ul>".
            "<label for='horarios[]'>7:00</label>".
                desabilitar_checkbox(1).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>7:50</label>".
                desabilitar_checkbox(2).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>8:40</label>".
                desabilitar_checkbox(3).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>9:30</label>".
                desabilitar_checkbox(4).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>10:40</label>".
                desabilitar_checkbox(5).
            "</ul>".
            "<ul>".
            "<label for='horarios[]'>11:30</label>".
                desabilitar_checkbox(6).
            "</ul>".
    "</section>";

    function desabilitar_checkbox($id_horario) {

        global $lista_horarios_fechados;
        

        switch($id_horario) {
            case 1:
                if(in_array(1, $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='7:00' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='7:00'>";
                } 

            break;
            case 2:
                if(in_array(2, $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='7:50' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='7:50'>";
                } 
            break;
            case 3:
                if(in_array(3, $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='8:40' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='8:40'>";
                } 
            break;
            case 4:
                if(in_array('4', $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='9:50' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='9:50'>";
                } 
            break;
            case 5:
                if(in_array('5', $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='10:40' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='10:40'>";
                } 
            break;
            case 6:
                if(in_array('6', $lista_horarios_fechados)) {
                    return "<input type='checkbox' name='horarios[]' value='11:30' disabled>";
                } else {
                    return "<input type='checkbox' name='horarios[]' value='11:30'>";
                } 
            break;
        }
       
    }



?>
